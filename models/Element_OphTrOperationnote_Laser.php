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
 * This is the model class for table "element_procedurelist".
 *
 * The followings are the available columns in table 'element_operation':
 * @property string $id
 * @property integer $event_id
 * @property integer $surgeon_id
 * @property integer $assistant_id
 * @property integer $anaesthetic_type
 *
 * The followings are the available model relations:
 * @property Event $event
 */
class Element_OphTrOperationnote_Laser extends Element_OnDemand
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ElementOperation the static model class
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
		return 'et_ophtroperationnote_laser';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('antseg, postpole, fundus, lens_id, duration_id, power, shots, spot_size_id, pattern_id, yag_pulses, yag_power, yag_energy', 'safe'),
			array('lens_id, duration_id, power, shots, spot_size_id, pattern_id', 'required'),
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
			'element_type' => array(self::HAS_ONE, 'ElementType', 'id','on' => "element_type.class_name='".get_class($this)."'"),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'lens' => array(self::BELONGS_TO, 'OphTrOperationnote_Laser_Lens', 'lens_id'),
			'duration' => array(self::BELONGS_TO, 'OphTrOperationnote_Laser_Duration', 'duration_id'),
			'spot_size' => array(self::BELONGS_TO, 'OphTrOperationnote_Laser_Spot_Size', 'spot_size_id'),
			'pattern' => array(self::BELONGS_TO, 'OphTrOperationnote_Laser_Pattern', 'pattern_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lens_id' => 'Lens',
			'lens_other' => 'Other lens',
			'duration_id' => 'Duration',
			'power' => 'Power',
			'shots' => 'Shots',
			'spot_size_id' => 'Spot size',
			'pattern_id' => 'Pattern',
			'yag_pulses' => 'Pulses',
			'yag_power' => 'Power',
			'yag_energy' => 'Total energy',
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

	public function getEye()
	{
		return Element_OphTrOperationnote_ProcedureList::model()->find('event_id=?',array($this->event_id))->eye;
	}

	public function beforeValidate()
	{
		if ($this->lens && $this->lens->name == 'Other (please specify)') {
			if (!$this->lens_other) {
				$this->addError('lens_other','Please specify the other lens type');
			}
		}

		if ($this->lens && $this->lens->name == 'YAG') {
			foreach (array('yag_pulses','yag_power','yag_energy') as $field) {
				if (strlen((string)$this->$field) <1) {
					$this->addError($field,$this->getAttributeLabel($field).' cannot be blank.');
				}
			}
		}

		return parent::beforeValidate();
	}
}
