<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

/**
 * This is the model class for table "et_ophtroperationnote_injection".
 *
 * The followings are the available columns in table 'et_ophtroperationnote_injection':
 * @property integer $id
 * @property integer $event_id
 */
class Element_OphTrOperationnote_Injection extends Element_OnDemand
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Element_OphTrOperationnote_Injection the static model class
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
		return 'et_ophtroperationnote_injection';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, eyedraw, lens_status_id, pre_antisept_drug_id, pre_skin_drug_id, pre_ioplowering_required, drug_id, number, batch_number, batch_expiry_date, injection_given_by_id, injection_time, post_ioplowering_required, finger_count, iop_checked, postinject_drops_id', 'safe'),
			array('eyedraw, lens_status_id', 'required'),
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
			'lens_status' => array(self::BELONGS_TO, 'OphTrOperationnote_LensStatus', 'lens_status_id'),
			'pre_antisept_drug' => array(self::BELONGS_TO, 'OphTrOperationnote_Injection_Antiseptic_Drug', 'pre_antisept_drug_id'),
			'pre_skin_drug' => array(self::BELONGS_TO, 'OphTrOperationnote_Injection_Skin_Drug', 'pre_skin_drug_id'),
			'drug' => array(self::BELONGS_TO, 'OphTrOperationnote_Injection_Treatment_Drug', 'drug_id'),
			'injection_given_by' => array(self::BELONGS_TO, 'User', 'injection_given_by_id'),
			'postinject_drops' => array(self::BELONGS_TO, 'OphTrOperationnote_Injection_Drop', 'postinject_drops_id'),
			'pre_ioploweringdrugs_assignment' => array(self::HAS_MANY, 'OphTrOperationnote_Injection_Pre_IOP_Lowering_Assignment', 'element_id'),
			'pre_ioploweringdrugs' => array(self::HAS_MANY, 'OphTrOperationnote_Injection_IOP_Lowering', 'iopl_id', 'through' => 'pre_ioploweringdrugs_assignment'),
			'post_ioploweringdrugs_assignment' => array(self::HAS_MANY, 'OphTrOperationnote_Injection_Post_IOP_Lowering_Assignment', 'element_id'),
			'post_ioploweringdrugs' => array(self::HAS_MANY, 'OphTrOperationnote_Injection_IOP_Lowering', 'iopl_id', 'through' => 'post_ioploweringdrugs_assignment'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lens_status_id' => 'Lens status',
			'drug_id' => 'Drug',
			'number' => 'Number of injections',
			'batch_number' => 'Batch number',
			'batch_expiry_date' => 'Batch expiry date',
			'injection_given_by_id' => 'Injection given by',
			'injection_time' => 'Injection time',
			'pre_antisept_drug_id' => 'Pre injection antiseptic',
			'pre_skin_drug_id' => 'Pre injection skin cleanser',
			'pre_ioploweringdrugs' => 'Pre injection IOP lowering therapy',
			'post_ioploweringdrugs' => 'Post injection IOP lowering therapy',
			'finger_count' => 'Counting fingers checked?',
			'iop_checked' => 'IOP needs to be checked?',
			'postinject_drops_id' => 'Post injection drops',
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
	 * The eye of the procedure is stored in the parent procedure list element
	 *
	 * @return Eye
	 */
	public function getEye()
	{
		return Element_OphTrOperationnote_ProcedureList::model()->find('event_id=?',array($this->event_id))->eye;
	}
}
