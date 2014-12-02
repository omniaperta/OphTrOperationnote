<?php

/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

//TODO: direct use of models should be replaced by API when this is not master branch

class ReportController extends BaseController
{
	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('index', 'operation'),
				'roles' => array('OprnGenerateReport'),
			)
		);
	}

	protected function array2Csv(array $data)
	{
		if (count($data) == 0) {
			return null;
		}
		ob_start();
		$df = fopen("php://output", 'w');
		fputcsv($df, array_keys(reset($data)));
		foreach ($data as $row) {
			fputcsv($df, $row);
		}
		fclose($df);
		return ob_get_clean();
	}

	protected function sendCsvHeaders($filename)
	{
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$filename");
		header("Pragma: no-cache");
		header("Expires: 0");
	}

	public function actionIndex()
	{
		$this->redirect(array('operation'));
	}

	public function actionOperation()
	{
		if (isset($_GET['yt0'])) {
			$surgeon = null;
			$date_from = date('Y-m-d', strtotime("-1 year"));
			$date_to = date('Y-m-d');

			if (@$_GET['surgeon_id'] && (int)$_GET['surgeon_id']) {
				$surgeon_id = (int)$_GET['surgeon_id'];
				if (!$surgeon = User::model()->findByPk($surgeon_id)) {
					throw new CException("Unknown surgeon $surgeon_id");
				}
			}
			if (@$_GET['date_from'] && date('Y-m-d', strtotime($_GET['date_from']))) {
				$date_from = date('Y-m-d', strtotime($_GET['date_from']));
			}
			if (@$_GET['date_to'] && date('Y-m-d', strtotime($_GET['date_to']))) {
				$date_to = date('Y-m-d', strtotime($_GET['date_to']));
			}
			$filter_procedures = null;
			if (@$_GET['Procedures_procs']) {
				$filter_procedures = $_GET['Procedures_procs'];
			}
			$filter_complications =  null;
			if (@$_GET['complications']) {
				$filter_complications = $_GET['complications'];
			}

			// ensure we don't hit PAS
			Yii::app()->event->dispatch('start_batch_mode');
			$results = $this->getOperations($surgeon, $filter_procedures, $filter_complications, $date_from, $date_to);
			Yii::app()->event->dispatch('end_batch_mode');

			$filename = 'operation_report_' . date('YmdHis') . '.csv';
			$this->sendCsvHeaders($filename);

			$columns = array(
				'operation_date' => 'Operation date',
				'hos_num' => 'Hospital No',
				'first_name' => 'First name',
				'last_name' => 'Last name',
				'gender' => 'Gender',
				'patient_dob' => 'Date of birth',
				'procedures' => 'Procedure(s)',
				'complications' => 'Complication(s)',
				// booking
				'bookingcomments' => 'Booking comments',
				'booking_diagnosis' => 'Booking diagnosis',
				'operation_date' => 'Surgery date',
				'theatre' => 'Theatre',
				// examination
				'comorbidities' => 'Comorbidities',
				'first_or_second_eye' => 'First or second eye',
				'pre-op refraction' => 'Pre-op refraction',
				'most recent post-op refraction' => 'Most recent post-op refraction',
				'target_refraction' => 'Target refraction',
				'pre-op va' => 'Pre-op VA',
				'most recent post-op va' => 'Most recent post-op VA',
				// opnote
				'cataract_report' => 'Cataract report',
				'tamponade_used' => 'Tamponade used',
				'anaesthetic_type' => 'Anaesthetic type',
				'anaesthetic_delivery' => 'Anaesthetic delivery',
				'anaesthetic_complications' => 'Anaesthetic complications',
				'anaesthetic_comments' => 'Anaesthetic comments',
				'surgeon' => 'Surgeon',
				'surgeon_role' => 'Surgeon role',
				'assistant' => 'Assistant',
				'assistant_role' => 'Assistant role',
				'supervising_surgeon' => 'Supervising surgeon',
				'supervising_surgeon_role' => 'Supervising surgeon role',
				'opnote_comments' => 'Operation note comments',
				// patient data
				'patient_diagnoses' => 'Ophthalmic diagnoses',
			);

			if (count($results) > 0) {
				$i = 0; $_columns = array();
				foreach ($columns as $column => $label) {
					$keys = array_keys($results[0]);

					if (in_array($column,$keys)) {
						$_columns[] = $column;

						if ($i >0) {
							echo ",";
						}
						echo $label;
						$i++;
					}
				}

				echo "\n";

				foreach ($results as $result) {
					foreach ($_columns as $i => $column) {
						if ($i >0) {
							echo ",";
						}
						echo '"'.$result[$column].'"';
					}

					echo "\n";
				}

				return;
			}

			$error = 'No results found, please widen your search criteria.';
		}

		Yii::app()->assetManager->registerCssFile('css/report.css', 'application.modules.OphTrOperationnote.assets', 10);

		$context['surgeons'] = CHtml::listData(User::model()->findAll(array('condition' => 'is_surgeon = 1', 'order' => 'first_name,last_name')), 'id', 'fullname');
		$context['error'] = @$error;
		$this->render('operation', $context);
	}

	/**
	 * Generate operation report
	 * @param User $surgeon
	 * @param array $filter_procedures
	 * @param array $filter_complications
	 * @param $from_date
	 * @param $to_date
	 * @param array $appenders - list of methods to call with patient id and date to retrieve additional data for each row
	 * @return array
	 */
	protected function getOperations($surgeon = null, $filter_procedures = array(), $filter_complications = array(), $from_date, $to_date)
	{
		$filter_procedures_method = 'OR';
		$filter_complications_method = 'OR';

		$select = "e.id, c.first_name, c.last_name, e.created_date, su.surgeon_id, su.assistant_id, su.supervising_surgeon_id, p.hos_num,".
			"p.gender, p.dob, pl.id as plid, cat.id as cat_id, eye.name AS eye, ep.patient_id, pl.booking_event_id";
		
		$command = Yii::app()->db->createCommand()
			->from("event e")
			->join("episode ep", "e.episode_id = ep.id")
			->join("patient p", "ep.patient_id = p.id")
			->join("et_ophtroperationnote_procedurelist pl", "pl.event_id = e.id")
			->join("et_ophtroperationnote_surgeon su", "su.event_id = e.id")
			->join("contact c", "p.contact_id = c.id")
			->join("eye", "eye.id = pl.eye_id")
			->leftJoin("et_ophtroperationnote_cataract cat", "cat.event_id = e.id")
			->where("e.deleted = 0 and ep.deleted = 0 and e.created_date >= :from_date and e.created_date < :to_date + interval 1 day")
			->order("p.id, e.created_date asc");

		if (@$_GET['booking_diagnosis'] || @$_GET['theatre'] || @$_GET['booking']) {
			if (Yii::app()->db->getSchema()->getTable('et_ophtroperationbooking_operation')) {
				$command->leftJoin('et_ophtroperationbooking_operation eo','eo.event_id = pl.booking_event_id');

				if (@$_GET['booking']) {
					$select .= ", eo.comments as bookingcomments";
				}

				if (@$_GET['booking_diagnosis']) {
					$command->leftJoin('et_ophtroperationbooking_diagnosis di','di.event_id = pl.booking_event_id')
						->leftJoin('disorder bd','di.disorder_id = bd.id')
						->leftJoin('eye bde','di.eye_id = bde.id');
					$select .= ", bd.term as bd_disorder, bde.name as bd_eye";
				}

				if (@$_GET['theatre'] || @$_GET['surgerydate']) {
					$command->leftJoin('ophtroperationbooking_operation_booking b','eo.latest_booking_id = b.id');

					if (@$_GET['theatre']) {
						$command->leftJoin('ophtroperationbooking_operation_theatre t','b.session_theatre_id = t.id');
						$select .= ", t.name as theatre";
					}
				}
			}
		}

		if (@$_GET['anaesthetic_type'] || @$_GET['anaesthetic_delivery'] || @$_GET['anaesthetic_comments'] || @$_GET['anaesthetic_complications']) {
			$command->join('et_ophtroperationnote_anaesthetic an','an.event_id = e.id');
			$select .= ", an.id as an_id";

			if (@$_GET['anaesthetic_comments']) {
				$select .= ", an.anaesthetic_comment as anaesthetic_comments";
			}

			if (@$_GET['anaesthetic_type']) {
				$command->join('anaesthetic_type ant','an.anaesthetic_type_id = ant.id');
				$select .= ", ant.name as anaesthetic_type";
			}

			if (@$_GET['anaesthetic_delivery']) {
				$command->join('anaesthetic_delivery and','an.anaesthetic_delivery_id = and.id');
				$select .= ", and.name as anaesthetic_delivery";
			}
		}

		if (@$_GET['cataract_report']) {
			$command->leftJoin('ophtroperationnote_cataract_iol_type iol','iol.id = cat.iol_type_id');
			$select .= ", cat.report as cataract_report, cat.predicted_refraction as cataract_predicted_refraction, iol.name as cataract_iol_type, cat.iol_power as cataract_iol_power";
		}

		if (@$_GET['tamponade_used']) {
			$command->leftJoin('et_ophtroperationnote_tamponade tam','tam.event_id = e.id')
				->leftJoin('ophtroperationnote_gas_type gas','tam.gas_type_id = tam.id');
			$select .= ", gas.name as tamponade_used";
		}

		if (@$_GET['surgeon'] || @$_GET['surgeon_role'] || @$_GET['assistant'] || @$_GET['assistant_role'] || @$_GET['supervising_surgeon'] || @$_GET['supervising_surgeon_role']) {
			if (@$_GET['surgeon'] || @$_GET['surgeon_role']) {
				$command->leftJoin('user surgeon_user','surgeon_user.id = su.surgeon_id');

				if (@$_GET['surgeon']) {
					$select .= ", surgeon_user.first_name as surgeon_first_name, surgeon_user.last_name as surgeon_last_name";
				}
				if (@$_GET['surgeon_role']) {
					$select .= ", surgeon_user.role as surgeon_role";
				}
			}
			if (@$_GET['assistant'] || @$_GET['assistant_role']) {
				$command->leftJoin('user assistant_user','assistant_user.id = assistant_id');

				if (@$_GET['assistant']) {
					$select .= ", assistant_user.first_name as assistant_first_name, assistant_user.last_name as assistant_last_name";
				}
				if (@$_GET['assistant_role']) {
					$select .= ", assistant_user.role as assistant_role";
				}
			}

			if (@$_GET['supervising_surgeon'] || @$_GET['supervising_surgeon_role']) {
				$command->leftJoin('user supervisor_user','supervisor_user.id = supervising_surgeon_id');

				if (@$_GET['supervising_surgeon']) {
					$select .= ", supervisor_user.first_name as supervising_surgeon_first_name, supervisor_user.last_name as supervising_surgeon_last_name";
				}
				if (@$_GET['supervising_surgeon_role']) {
					$select .= ", supervisor_user.role as supervising_surgeon_role";
				}
			}
		}

		if (@$_GET['opnote_comments']) {
			$command->leftJoin('et_ophtroperationnote_comments comments','comments.event_id = e.id');
			$select .= ", comments.comments as opnote_comments";
		}

		$command->select($select);

		$params = array(':from_date' => $from_date, ':to_date' => $to_date);

		if ($surgeon) {
			$command->andWhere(
				"(su.surgeon_id = :user_id or su.assistant_id = :user_id or su.supervising_surgeon_id = :user_id)"
			);
			$params[':user_id'] = $surgeon->id;
		}

		$this->debug('executing query: '.$command->getText()."\n");
		$this->debug('params: '.print_r($params,true)."\n");

		$results = $command->queryAll(true, $params);

		$patient_ids = array();
		$cat_ids = array();
		$pl_ids = array();
		$an_ids = array();

		foreach ($results as $row) {
			$patient_ids[] = $row['patient_id'];
			$pl_ids[] = $row['plid'];

			if (@$row['an_id']) {
				$an_ids[] = $row['an_id'];
			}

			if ($row['cat_id']) {
				$cat_ids[] = $row['cat_id'];
			}
		}

		$cache = array();

		if (!empty($cat_ids)) {
			foreach (Yii::app()->db->createCommand()
				->select("ophtroperationnote_cataract_complications.*, ophtroperationnote_cataract_complication.cataract_id")
				->from("ophtroperationnote_cataract_complication")
				->join("ophtroperationnote_cataract_complications","ophtroperationnote_cataract_complication.complication_id = ophtroperationnote_cataract_complications.id")
				->where("cataract_id in (".implode(',',$cat_ids).")")
				->queryAll() as $cc) {
				$cache['complications'][$cc['cataract_id']][$cc['id']] = $cc['name'];
			}
		}

		if (!empty($pl_ids)) {
			foreach (Yii::app()->db->createCommand()
				->select("ophtroperationnote_procedurelist_procedure_assignment.procedurelist_id, proc.*")
				->from("ophtroperationnote_procedurelist_procedure_assignment")
				->join("proc","ophtroperationnote_procedurelist_procedure_assignment.proc_id = proc.id")
				->where("procedurelist_id in (".implode(',',$pl_ids).")")
				->queryAll() as $pa) {
				$cache['procedures'][$pa['procedurelist_id']][$pa['id']] = $pa['term'];
			}
		}

		if (@$_GET['patient_oph_diagnoses']) {
			$oph = Specialty::model()->find('name=?',array('Ophthalmology'))->id;

			foreach (Yii::app()->db->createCommand()
				->select("sd.patient_id, d.term, e.name")
				->from("secondary_diagnosis sd")
				->join("disorder d","sd.disorder_id = d.id")
				->leftJoin("eye e","sd.eye_id = e.id")
				->where("sd.patient_id in (".implode(',',$patient_ids).") and d.specialty_id = $oph")
				->queryAll() as $sd) {
				$eye = $sd['name'] ? ($sd['name'] == 'Both' ? 'Bilateral' : $sd['name']) : null;
				$cache['oph_diagnoses'][$sd['patient_id']][] = ($eye ? "$eye " : "") . $sd['term'];
			}

			foreach (Yii::app()->db->createCommand()
				->select("disorder_id, eye_id, patient_id, disorder.term, eye.name")
				->from("episode")
				->leftJoin('eye','eye_id = eye.id')
				->join('disorder','disorder_id = disorder.id')
				->where("patient_id in (".implode(',',$patient_ids).") and episode.deleted = 0")
				->queryAll() as $episode) {
				$eye = $episode['name'] ? ($episode['name'] == 'Both' ? 'Bilateral' : $episode['name']) : null;
				$cache['ep_diagnoses'][$episode['patient_id']][] = ($eye ? "$eye " : "") . $episode['term'];
			}
		}

		if (@$_GET['anaesthetic_complications']) {
			foreach (Yii::app()->db->createCommand()
				->select("ophtroperationnote_anaesthetic_anaesthetic_complication.et_ophtroperationnote_anaesthetic_id, com.*")
				->from("ophtroperationnote_anaesthetic_anaesthetic_complication")
				->join("ophtroperationnote_anaesthetic_anaesthetic_complications com","com.id = anaesthetic_complication_id")
				->where("et_ophtroperationnote_anaesthetic_id in (".implode(',',$an_ids).")")
				->queryAll() as $ac) {
				$cache['anaesthetic_complications'][$ac['et_ophtroperationnote_anaesthetic_id']][] = $ac['name'];
			}
		}

		$_results = array();

		foreach ($results as $row) {
			$this->debug('query finished');

			set_time_limit(1);
			$complications = array();
			if ($row['cat_id']) {
				if (!empty($cache['complications'][$cc['cataract_id']])) {
					foreach ($cache['complications'][$cc['cataract_id']] as $id => $name) {
						$complications[(string)$id] = $name;
					}
				}
			}

			$this->debug('done complications');

			$matched_complications = 0;
			if ($filter_complications) {
				foreach ($filter_complications as $filter_complication) {
					if (isset($complications[$filter_complication])) {
						$matched_complications++;
					}
				}
				if (($filter_complications_method == 'AND' && $matched_complications < count(
							$filter_complications
						)) || !$matched_complications
				) {
					continue;
				}
			}

			$this->debug('done complications 2');

			$procedures = array();

			if (!empty($cache['procedures'][$row['plid']])) {
				foreach ($cache['procedures'][$row['plid']] as $id => $term) {
					$procedures[(string)$id] = $term;
				}
			}

			$this->debug('done proclist assignment');

			$matched_procedures = 0;
			if ($filter_procedures) {
				foreach ($filter_procedures as $filter_procedure) {
					if (isset($procedures[$filter_procedure])) {
						$matched_procedures++;
					}
				}
				if (($filter_procedures_method == 'AND' && $matched_procedures < count(
							$filter_procedures
						)) || !$matched_procedures
				) {
					continue;
				}
			}

			$this->debug('done proclist assignment 2');

			$record = array_merge($row,array(
				"operation_date" => date('j M Y', strtotime($row['created_date'])),
				"patient_hosnum" => $row['hos_num'],
				"patient_firstname" => $row['first_name'],
				"patient_surname" => $row['last_name'],
				"patient_gender" => $row['gender'],
				"patient_dob" => date('j M Y', strtotime($row['dob'])),
				"eye" => $row['eye'],
				"procedures" => implode(', ', $procedures),
				"complications" => implode(', ', $complications),
			));

			if ($surgeon) {
				if ($row['surgeon_id'] == $surgeon->id) {
					$record['surgeon_role'] = 'Surgeon';
				} else {
					if ($row['assistant_id'] == $surgeon->id) {
						$record['surgeon_role'] = 'Assistant surgeon';
					} else {
						if ($row['supervising_surgeon_id'] == $surgeon->id) {
							$record['surgeon_role'] = 'Supervising surgeon';
						}
					}
				}
			}

			$this->debug('surgeon stuff');

			//appenders
			if (@$_GET['patient_oph_diagnoses']) {
				$this->appendPatientValues($record, @$cache['ep_diagnoses'][$row['patient_id']], @$cache['oph_diagnoses'][$row['patient_id']]);
			}

			$this->debug('patient values');
			$this->appendBookingDiagnosis($record);

			if (@$_GET['anaesthetic_complications']) {
				if (isset($cache['anaesthetic_complications'][$row['an_id']])) {
					$record['anaesthetic_complications'] = implode(', ',$cache['anaesthetic_complications'][$row['an_id']]);
				} else {
					$record['anaesthetic_complications'] = '';
				}
			}

			if (@$_GET['cataract_report']) {
				if (!$record['cataract_iol_type']) {
					$record['cataract_iol_type'] = 'Unknown';
				}
				$record['cataract_report'] = trim(preg_replace('/\s\s+/', ' ', $record['cataract_report']));
			}

			if (@$_GET['tamponade_used']) {
				if (!$record['tamponade_used']) {
					$record['tamponade_used'] = 'None';
				}
			}

			if (@$_GET['surgeon']) {
				$record['surgeon'] = $record['surgeon_first_name'] ? $record['surgeon_first_name'].' '.$record['surgeon_last_name'] : 'None';
			}
			if (@$_GET['surgeon_role']) {
				if (!$record['surgeon_role']) {
					$record['surgeon_role'] = 'None';
				}
			}

			if (@$_GET['assistant']) {
				$record['assistant'] = $record['assistant_first_name'] ? $record['assistant_first_name'].' '.$record['assistant_last_name'] : 'None';
			}
			if (@$_GET['assistant_role']) {
				if (!$record['assistant_role']) {
					$record['assistant_role'] = 'None';
				}
			}

			if (@$_GET['supervising_surgeon']) {
				$record['supervising_surgeon'] = $record['supervising_surgeon_first_name'] ? $record['supervising_surgeon_first_name'].' '.$record['supervising_surgeon_last_name'] : 'None';
			}
			if (@$_GET['supervising_surgeon_role']) {
				if (!$record['supervising_surgeon_role']) {
					$record['supervising_surgeon_role'] = 'None';
				}
			}

			if (@$_GET['opnote_comments']) {
				$record['opnote_comments'] = trim(preg_replace('/\s\s+/', ' ', $record['opnote_comments']));
			}

			$this->debug('booking values');
			$this->appendExaminationValues($record, $row['id']);
			$this->debug('examination values');

			$_results[] = $record;
		}

		return $_results;
	}

	public function debug($msg)
	{
		$fp = fopen("/home/mark/debug.log","a+");
		fwrite($fp,date('H:i:s')." - $msg\n");
		fclose($fp);
	}

	protected function appendPatientValues(&$record, $ep_diagnoses, $oph_diagnoses)
	{
		if (@$_GET['patient_oph_diagnoses']) {
			$diagnoses = array();

			if (!empty($ep_diagnoses)) {
				foreach ($ep_diagnoses as $diagnosis) {
					$diagnoses[] = $diagnosis;
				}
			}

			if (!empty($oph_diagnoses)) {
				foreach ($oph_diagnoses as $diagnosis) {
					$diagnoses[] = $diagnosis;
				}
			}

			if (!empty($diagnoses)) {
				$record['patient_diagnoses'] = implode(', ', $diagnoses);
			} else {
				$record['patient_diagnoses'] = '';
			}
		}
	}

	protected function appendBookingDiagnosis(&$record)
	{
		if (@$_GET['booking_diagnosis']) {
			if ($record['bd_disorder']) {
				$eye = $record['bd_eye'] == 'Both' ? 'Bilateral' : $record['bd_eye'];

				$record['booking_diagnosis'] = $eye.' '.$record['bd_disorder'];
			} else {
				$record['booking_diagnosis'] = 'Unknown';
			}
		}
	}

	protected function appendExaminationValues(&$record, $event_id)
	{
		$event = Event::model()->with('episode')->findByPk($event_id);

		if ($api = Yii::app()->moduleAPI->get('OphCiExamination')) {

			$preOpCriteria = $this->preOperationNoteCriteria($event);
			$postOpCriteria = $this->postOperationNoteCriteria($event);

			if (@$_GET['comorbidities']) {
				$record['comorbidities'] = $this->getComorbidities($preOpCriteria);
			}

			if (@$_GET['target_refraction']) {
				$record['target_refraction']= $this->getTargetRefraction($preOpCriteria);
			}

			if (@$_GET['first_eye']) {
				$record['first_or_second_eye']=$this->getFirstEyeOrSecondEye($preOpCriteria);
			}

			if (@$_GET['va_values']) {
				$record['pre-op va'] = $this->getVaReading($preOpCriteria,$record);
				$record['most recent post-op va'] = $this->getVaReading($postOpCriteria,$record);
			}

			if (@$_GET['refraction_values']) {
				$record['pre-op refraction'] = $this->getRefractionReading($preOpCriteria,$record);
				$record['most recent post-op refraction'] = $this->getRefractionReading($postOpCriteria,$record);
			}
		}
	}

	protected function preOperationNoteCriteria($event)
	{
		return $this->operationNoteCriteria($event, true);
	}

	public function postOperationNoteCriteria($event)
	{
		return $this->operationNoteCriteria($event,false);
	}

	public function operationNoteCriteria($event, $searchBackwards)
	{
		$criteria = new CDbCriteria();
		if ($searchBackwards) {
			$criteria->addCondition('event.created_date < :op_date');
		}
		else {
			$criteria->addCondition('event.created_date > :op_date');
		}
		$criteria->addCondition('event.episode_id = :episode_id');
		$criteria->params[':episode_id'] = $event->episode_id;
		$criteria->params[':op_date'] = $event->created_date;
		$criteria->order = 'event.created_date desc';
		$criteria->limit = 1;
		return $criteria;
	}

	protected function eyesCondition($record)
	{
		if (strtolower($record['eye']) == 'left') {
			$eyes = array(Eye::LEFT,Eye::BOTH);
		}
		else {
			$eyes = array(Eye::RIGHT, Eye::BOTH);
		}
		return $eyes;
	}

	protected function getComorbidities($criteria)
	{
		$comorbiditiesElement = \OEModule\OphCiExamination\models\Element_OphCiExamination_Comorbidities::model()->with(array('event'))->find($criteria);

		$comorbidities = array();
		if (isset($comorbiditiesElement->items)) {
			foreach($comorbiditiesElement->items as $comorbiditity) {
				$comorbidities[] = $comorbiditity['name'];
			}
		return implode(',', $comorbidities);
		}
	}

	protected function getTargetRefraction($criteria)
	{
		$cataractManagementElement = \OEModule\OphCiExamination\models\Element_OphCiExamination_CataractSurgicalManagement::model()->with(array('event'))->find($criteria);
		if ($cataractManagementElement) {
		return $cataractManagementElement['target_postop_refraction'];
		}
	}

	public function getFirstEyeOrSecondEye($criteria)
	{
		$cataractManagementElement = \OEModule\OphCiExamination\models\Element_OphCiExamination_CataractSurgicalManagement::model()->with(array('event'))->find($criteria);
		if ($cataractManagementElement) {
		return $cataractManagementElement->eye['name'];
		}
	}

	public function getVAReading($criteria,$record)
	{
		$criteria->addInCondition('eye_id', $this->eyesCondition($record));
		$va = \OEModule\OphCiExamination\models\Element_OphCiExamination_VisualAcuity::model()->with(array('event'))->find($criteria);
		$reading = null;
		$sides = array(strtolower($record['eye']));
		if ($sides[0] == 'both') {
			$sides = array('left', 'right');
		}

		if ($va) {
			$res = '';
			foreach ($sides as $side) {
				$reading = $va->getBestReading($side);
				if ($res) {
					$res .= " ";
				}
				if ($reading) {
					$res .= ucfirst($side) . ": " . $reading->convertTo($reading->value, $va->unit_id) . ' (' . $reading->method->name . ')';
				}
				else {
					$res .= ucfirst($side) . ": Unknown";
				}
			}
			return $res;
		}
		return "Unknown";
	}

	public function getRefractionReading($criteria,$record)
	{
		$criteria->addInCondition('eye_id', $this->eyesCondition($record));
		$refraction = \OEModule\OphCiExamination\models\Element_OphCiExamination_Refraction::model()->with('event')->find($criteria);
		if ($refraction) {
			return $refraction->getCombined(strtolower($record['eye']));
		}
		else {
			return 'Unknown';
		}
	}

	/**
	 * Generates a cataract outcomes report
	 *
	 * inputs (all optional):
	 * - firm_id
	 * - surgeon_id
	 * - assistant_id
	 * - supervising_surgeon_id
	 * - date_from
	 * - date_to
	 *
	 * outputs:
	 * - number of cataracts (number)
	 * - age of patients (mean and range)
	 * - eyes (numbers and percentage for left/right)
	 * - final visual acuity (mean and range)
	 * - pc ruptures (number and percentage)
	 * - complications (number and percentage)
	 *
	 * @param array $params
	 * @return array
	 */
	public	function reportCataractOperations(
		$params
	) {
		$data = array();

		$where = '';

		@$params['firm_id'] and $where .= " and f.id = {$params['firm_id']}";

		$surgeon_where = '';
		foreach (array('surgeon_id', 'assistant_id', 'supervising_surgeon_id') as $field) {
			if (@$params[$field]) {
				if ($surgeon_where) {
					$surgeon_where .= ' or ';
				}
				$surgeon_where .= "s.$field = {$params[$field]}";
			}
		}

		$surgeon_where and $where .= " and ($surgeon_where)";

		if (preg_match('/^[0-9]+[\s\-][a-zA-Z]{3}[\s\-][0-9]{4}$/', @$params['date_from'])) {
			$params['date_from'] = Helper::convertNHS2MySQL($params['date_from']);
		}
		if (preg_match('/^[0-9]+[\s\-][a-zA-Z]{3}[\s\-][0-9]{4}$/', @$params['date_to'])) {
			$params['date_to'] = Helper::convertNHS2MySQL($params['date_to']);
		}
		@$params['date_from'] and $where .= " and e.created_date >= '{$params['date_from']}'";
		@$params['date_to'] and $where .= " and e.created_date <= '{$params['date_to']}'";

		$data['cataracts'] = 0;
		$data['eyes'] = array(
			'left' => array(
				'number' => 0,
			),
			'right' => array(
				'number' => 0,
			),
		);
		$data['age']['from'] = 200; // wonder if this will ever need to be changed..
		$data['age']['to'] = 0;
		$data['final_visual_acuity'] = array(
			'from' => 0,
			'to' => 0,
			'mean' => 0,
		);
		$data['pc_ruptures']['number'] = 0;
		$data['complications']['number'] = 0;

		$ages = array();

		if (!($db = Yii::app()->params['report_db'])) {
			$db = 'db';
		}

		foreach (Yii::app()->$db->createCommand()
			->select("pl.eye_id, p.dob, p.date_of_death, comp.id as comp_id, pc.id as pc_id")
			->from("et_ophtroperationnote_procedurelist pl")
			->join("et_ophtroperationnote_cataract c","pl.event_id = c.event_id")
			->join("event e","c.event_id = e.id")
			->join("et_ophtroperationnote_surgeon s","s.event_id = e.id")
			->join("episode ep","e.episode_id = ep.id")
			->join("firm f","ep.firm_id = f.id")
			->join("patient p","ep.patient_id = p.id")
			->leftJoin("et_ophtroperationnote_cataract_complication comp","comp.cataract_id = c.id")
			->leftJoin("et_ophtroperationnote_cataract_complication pc","pc.cataract_id = c.id and pc.complication_id = 11")
			->where("pl.deleted = 0 and c.deleted = 0 and e.deleted = 0 and s.deleted = 0 and ep.deleted = 0 and f.deleted = 0 and p.deleted = 0 and (comp.id is null or comp.deleted = 0) and (pc.id is null or pc.deleted = 0) $where")
			->queryAll() as $row) {

			$data['cataracts']++;
			($row['eye_id'] == 1) ? $data['eyes']['left']['number']++ : $data['eyes']['right']['number']++;

			$age = Helper::getAge($row['dob'], $row['date_of_death']);
			$ages[] = $age; //this is taking ages

			if ($age < $data['age']['from']) {
				$data['age']['from'] = $age;
			}

			if ($age > $data['age']['to']) {
				$data['age']['to'] = $age;
			}

			$row['pc_id'] and $data['pc_ruptures']['number']++;
			$row['comp_id'] and $data['complications']['number']++;
		}

		if (count($ages) == 0) {
			$data['age']['from'] = 0;
		}

		$data['eyes']['left']['percentage'] = ($data['cataracts'] > 0) ? number_format(
			$data['eyes']['left']['number'] / ($data['cataracts'] / 100),
			2
		) : 0;
		$data['eyes']['right']['percentage'] = ($data['cataracts'] > 0) ? number_format(
			$data['eyes']['right']['number'] / ($data['cataracts'] / 100),
			2
		) : 0;
		$data['age']['mean'] = (count($ages) > 0) ? number_format(array_sum($ages) / count($ages), 2) : 0;
		$data['pc_ruptures']['percentage'] = ($data['cataracts'] > 0) ? number_format(
			$data['pc_ruptures']['number'] / ($data['cataracts'] / 100),
			2
		) : 0;
		$data['complications']['percentage'] = ($data['cataracts'] > 0) ? number_format(
			$data['complications']['number'] / ($data['cataracts'] / 100),
			2
		) : 0;
		$data['pc_rupture_average']['number'] = 0;
		$data['complication_average']['number'] = 0;

		if (!($db = Yii::app()->params['report_db'])) {
			$db = 'db';
		}

		foreach (Yii::app()->$db->createCommand()
			->select("pl.eye_id, p.dob, p.date_of_death, comp.id as comp_id, pc.id as pc_id")
			->from("et_ophtroperationnote_procedurelist pl")
			->join("et_ophtroperationnote_cataract c","pl.event_id = c.event_id")
			->join("event e","c.event_id = e.id")
			->join("et_ophtroperationnote_surgeon s","s.event_id = e.id")
			->join("episode ep","e.episode_id = ep.id")
			->join("firm f","ep.firm_id = f.id")
			->join("patient p","ep.patient_id = p.id")
			->leftJoin("et_ophtroperationnote_cataract_complication comp","comp.cataract_id = c.id")
			->leftJoin("et_ophtroperationnote_cataract_complication pc","pc.cataract_id = c.id and pc.complication_id = 11")
			->where("pl.deleted = 0 and c.deleted = 0 and e.deleted = 0 and s.deleted = 0 and ep.deleted = 0 and f.deleted = 0 and p.deleted = 0 and (comp.id is null or comp.deleted = 0) and (pc.id is null or pc.deleted = 0)")
			->queryAll() as $i => $row) {

			$row['pc_id'] and $data['pc_rupture_average']['number']++;
			$row['comp_id'] and $data['complication_average']['number']++;
		}

		$i++;

		$data['pc_rupture_average']['percentage'] = number_format(
			$data['pc_rupture_average']['number'] / ($i / 100),
			2
		);
		$data['complication_average']['percentage'] = number_format(
			$data['complication_average']['number'] / ($i / 100),
			2
		);

		return $data;
	}

	public function reportOperations($params=array())
	{
		$where = '';

		if (strtotime($params['date_from'])) {
			$where .= " and e.created_date >= '".date('Y-m-d',strtotime($params['date_from']))." 00:00:00'";
		}
		if (strtotime($params['date_to'])) {
			$where .= " and e.created_date <= '".date('Y-m-d',strtotime($params['date_to']))." 23:59:59'";
		}

		if ($user = User::model()->findByPk($params['surgeon_id'])) {
			$clause = '';
			if (@$params['match_surgeon']) {
				$clause .= "s.surgeon_id = $user->id";
			}
			if (@$params['match_assistant_surgeon']) {
				if ($clause) $clause .= ' or ';
				$clause .= "s.assistant_id = $user->id";
			}
			if (@$params['match_supervising_surgeon']) {
				if ($clause) $clause .= ' or ';
				$clause .= "s.supervising_surgeon_id = $user->id";
			}
			$where .= " and ($clause)";
		}

		if (!($db = Yii::app()->params['report_db'])) {
			$db = 'db';
		}

		foreach (Yii::app()->$db->createCommand()
			->select("p.hos_num, c.first_name, c.last_name, e.created_date, s.surgeon_id, s.assistant_id, s.supervising_surgeon_id, pl.id as pl_id, e.id as event_id, cat.id as cat_id, eye.name as eye")
			->from('patient p')
			->join('contact c',"c.parent_class = 'Patient' and c.parent_id = p.id")
			->join('episode ep','ep.patient_id = p.id')
			->join('event e','e.episode_id = ep.id')
			->join('et_ophtroperationnote_procedurelist pl','pl.event_id = e.id')
			->join('eye','pl.eye_id = eye.id')
			->join('et_ophtroperationnote_surgeon s','s.event_id = e.id')
			->leftJoin('et_ophtroperationnote_cataract cat','cat.event_id = e.id')
			->where("p.deleted = 0 and c.deleted = 0 and ep.deleted = 0 and e.deleted = 0 and pl.deleted = 0 and s.deleted = 0 and (cat.id is null or cat.deleted = 0) $where")
			->order('e.created_date asc')
			->queryAll() as $row) {

			$operations[] = array(
				'date' => date('j M Y',strtotime($row['created_date'])),
				'hos_num' => $row['hos_num'],
				'first_name' => $row['first_name'],
				'last_name' => $row['last_name'],
				'procedures' => array(),
				'complications' => array(),
				'role' => ($row['surgeon_id'] == $user->id ? 'Surgeon' : ($row['assistant_id'] == $user->id ? 'Assistant surgeon' : 'Supervising surgeon')),
			);

			foreach (OphTrOperationnote_ProcedureListProcedureAssignment::model()->findAll('procedurelist_id=?',array($row['pl_id'])) as $i => $pa) {
				$operations[count($operations)-1]['procedures'][] = array(
					'eye' => $row['eye'],
					'procedure' => $pa->procedure->term,
				);
			}

			if ($row['cat_id']) {
				foreach (OphTrOperationnote_CataractComplication::model()->findAll('cataract_id=?',array($row['cat_id'])) as $complication) {
					$operations[count($operations)-1]['complications'][] = array('complication'=>$complication->complication->name);
				}
			}
		}

		return array('operations'=>$operations);
	}
}
