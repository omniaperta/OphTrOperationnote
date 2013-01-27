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

/**
 * This is the model class for table "et_ophtroperationnote_coronary_catheterisation".
 *
 * The followings are the available columns in table 'et_ophtroperationnote_coronary_catheterisation':
 * @property integer $id
 * @property integer $event_id
 * @property integer $incision_site_id
 * @property string $length
 * @property string $meridian
 * @property integer $incision_type_id
 * @property string $eyedraw
 * @property string $report
 * @property integer $iol_position_id
 * @property string $complication_notes
 * @property string $eyedraw2
 * @property string $iol_power
 * @property integer $iol_type_id
 * @property string $report2
 *
 * The followings are the available model relations:
 * @property Event $event
 * @property IncisionType $incision_type
 * @property IncisionSite $incision_site
 * @property IOLPosition $iol_position
 * @property CataractComplication[] $complications
 * @property CataractOperativeDevice[] $operative_devices
 * @property IOLType $iol_type
 */
class ElementCoronarycatheterisation extends BaseEventTypeElement
{
	public $service;

	/**
	 * Returns the static model of the specified AR class.
	 * @return ElementCataract the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'et_ophtroperationnote_coronary_catheterisation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, local_anaesthetic_time, edv, pullback_gradiant, dccv, dccv_notes, completion_time, contrast_given, xray_amount, angeo_seal, tr_band, eyedraw, stenosis_type, stenosis_percent, eyedraw_report', 'safe'),
			array('local_anaesthetic_time, edv, pullback_gradiant, dccv, completion_time, contrast_given, xray_amount, angeo_seal, tr_band, eyedraw, stenosis_type, stenosis_percent', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, event_id, incision_site_id, length, meridian, incision_type_id, eyedraw, report, wound_burn, iris_trauma, zonular_dialysis, pc_rupture, decentered_iol, iol_exchange, dropped_nucleus, op_cancelled, corneal_odema, iris_prolapse, zonular_rupture, vitreous_loss, iol_into_vitreous, other_iol_problem, choroidal_haem', 'on' => 'search'),
		);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'catheters' => array(self::HAS_MANY, 'OphTrOperationnote_Coronary_Catheter', 'element_id', 'order' => 'display_order'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'local_anaesthetic_time' => 'Time of local anaesthetic',
			'access_id' => 'Access',
			'side_id' => 'Side',
			'vein_artery_id' => 'Vein/artery',
			'type_id' => 'Type',
			'edv' => 'EDV',
			'pullback_gradiant' => 'Pullback gradiant',
			'dccv' => 'DCCV',
			'dccv_notes' => 'DCCV Notes',
			'completion_time' => 'Completion time',
			'contrast_given' => 'Contrast given',
			'xray_amount' => 'X-ray amount',
			'angeo_seal' => 'Angeo seal',
			'tr_band' => 'TR band',
			'catheter_id' => 'Catheter',
			'stenosis_type_id' => 'Stenosis type',
			'stenosis_percent' => 'Stenosis degree',
			'eyedraw_report' => 'Report',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);
		
		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
			));
	}

	/**
	 * Set default values for forms on create
	 */
	public function setDefaultOptions()
	{
		if (Yii::app()->getController()->getAction()->id == 'create' || Yii::app()->getController()->getAction()->id == 'loadElementByProcedure') {
			$this->local_anaesthetic_time = date('H:i');
			$this->completion_time = date('H:i');
		}
	}

	public function afterFind() {
		$this->local_anaesthetic_time = substr($this->local_anaesthetic_time,0,5);
		$this->completion_time = substr($this->completion_time,0,5);
		return parent::afterFind();
	}

	/**
	 * Need to delete associated records
	 * @see CActiveRecord::beforeDelete()
	 */
	protected function beforeDelete() {
		return parent::beforeDelete();
	}
	
	protected function beforeSave()
	{
		return parent::beforeSave();
	}

	protected function afterSave()
	{
		foreach (OphTrOperationnote_Coronary_Catheter::model()->findAll('element_id=?',array($this->id)) as $catheter) {
			$catheter->delete();
		}

		foreach ($_POST as $key => $value) {
			if (preg_match('/^catheter_id([0-9]+)$/',$key,$m)) {
				$id = (int)$m[1];

				$catheter = new OphTrOperationnote_Coronary_Catheter;
				$catheter->element_id = $this->id;
				$catheter->display_order = $id;
				$catheter->catheter_id = $value;
				$catheter->access_id = @$_POST["access_id$id"];
				$catheter->side_id = @$_POST["side_id$id"];
				$catheter->vein_artery_id = @$_POST["vein_artery_id$id"];
				$catheter->type_id = @$_POST["type_id$id"];
				$catheter->success = @$_POST["success$id"];
				if (!$catheter->save()) {
					throw new Exception("Failed to save catheter: ".print_r($catheter->getErrors(),true));
				}
			}
		}

		return parent::afterSave();
	}

	public function beforeValidate() {
		$errors = array();

		foreach ($_POST as $key => $value) {
			if (preg_match('/^catheter_id([0-9]+)$/',$key,$m)) {
				$id = (int)$m[1];

				if (!@$_POST["catheter_id$id"]) {
					if (!in_array('catheter_id',$errors)) {
						$this->addError('catheter_id','Catheter type must be specified for all catheters');
						$errors[] = 'catheter_id';
					}
				}
				if (!@$_POST["access_id$id"]) {
					if (!in_array('access_id',$errors)) {
						$this->addError('access_id','Catheter access must be specified for all catheters');
						$errors[] = 'access_id';
					}
				}
				if (!@$_POST["side_id$id"]) {
					if (!in_array('side_id',$errors)) {
						$this->addError('side_id','Catheter side must be specified for all catheters');
						$errors[] = 'side_id';
					}
				}
				if (!@$_POST["vein_artery_id$id"]) {
					if (!in_array('vein_artery_id',$errors)) {
						$this->addError('vein_artery_id','Catheter vessel must be specified for all catheters');
						$errors[] = 'vein_artery_id';
					}
				}
				if (!@$_POST["type_id$id"]) {
					if (!in_array('type_id',$errors)) {
						$this->addError('type_id','Catheter use must be specified for all catheters');
						$errors[] = 'type_id';
					}
				}
			}
		}

		return parent::beforeValidate();
	}

	public function getFormCatheters() {
		if (Yii::app()->getController()->getAction()->id == 'create' || Yii::app()->getController()->getAction()->id == 'loadElementByProcedure') {
			if (empty($_POST)) {
				return array(
					0 => array(
						'catheter_id' => '',
						'access_id' => '',
						'side_id' => '',
						'vein_artery_id' => '',
						'type_id' => '',
						'success' => '',
					),
				);
			} else {
				return $this->cathetersFromPost();
			}
		} else {
			if (empty($_POST)) {
				$catheters = array();

				foreach ($this->catheters as $id => $catheter) {
					$catheters[$id] = array(
						'catheter_id' => $catheter->catheter_id,
						'access_id' => $catheter->access_id,
						'side_id' => $catheter->side_id,
						'vein_artery_id' => $catheter->vein_artery_id,
						'type_id' => $catheter->type_id,
						'success' => $catheter->success,
					);
				}

				return $catheters;

			} else {
				return $this->cathetersFromPost();
			}
		}
	}

	public function cathetersFromPost() {
		$ids = array();
		foreach ($_POST as $key => $value) {
			if (preg_match('/^catheter_id([0-9]+)$/',$key,$m)) {
				$ids[] = (int)$m[1];
			}
		}

		$catheters = array();

		foreach ($ids as $id) {
			$catheters[$id] = array(
				'catheter_id' => @$_POST["catheter_id$id"],
				'access_id' => @$_POST["access_id$id"],
				'side_id' => @$_POST["side_id$id"],
				'vein_artery_id' => @$_POST["vein_artery_id$id"],
				'type_id' => @$_POST["type_id$id"],
				'success' => @$_POST["success$id"],
			);
		}

		return $catheters;
	}
}
