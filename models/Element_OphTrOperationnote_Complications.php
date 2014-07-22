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
 * @property integer $assistant_id
 * @property integer $anaesthetic_type
 *
 * The followings are the available model relations:
 * @property Event $event
 */
class Element_OphTrOperationnote_Complications extends Element_OpNote
{
	public $has_cataract = false;
	public $has_trabeculectomy = false;

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
		return 'et_ophtroperationnote_complications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, comments', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, event_id, comments', 'safe', 'on' => 'search'),
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
			'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'complication_assignments' => array(self::HAS_MANY, 'OphTrOperationnote_Complication_Assignment', 'element_id'),
			'complications' => array(self::HAS_MANY, 'OphTrOperationnote_Complication', 'complication_id', 'through' => 'complication_assignments'),
			'anaesthetic_complications' => array(self::HAS_MANY, 'OphTrOperationnote_Complication', 'complication_id', 'through' => 'complication_assignments', 'condition' => 'type_id = 1'),
			'cataract_complications' => array(self::HAS_MANY, 'OphTrOperationnote_Complication', 'complication_id', 'through' => 'complication_assignments', 'condition' => 'type_id = 2'),
			'trabeculectomy_complications' => array(self::HAS_MANY, 'OphTrOperationnote_Complication', 'complication_id', 'through' => 'complication_assignments', 'condition' => 'type_id = 3'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_id' => 'Event',
			'comments' => 'Comments',
			'anaesthetic_complications' => 'Anaesthetic complications',
			'cataract_complications' => 'Cataract complications',
			'trabeculectomy_complications' => 'Trabeculectomy complications',
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
		$criteria->compare('comments', $this->comments);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	public function getComplicationsNotSelectedByType($type_id)
	{
		if (!$type = OphTrOperationnote_Complication_Type::model()->findByPk($type_id)) {
			throw new Exception("complication type not found: $type_id");
		}

		$selected_ids = array();

		foreach ($this->{strtolower($type->name)."_complications"} as $complication) {
			$selected_ids[] = $complication->id;
		}

		$criteria = new CDbCriteria;
		$criteria->addCondition('type_id = :type_id');
		$criteria->params[':type_id'] = $type->id;
		$criteria->order = 'display_order asc';

		if (!empty($selected_ids)) {
			$criteria->addNotInCondition('id',$selected_ids);
		}

		return OphTrOperationnote_Complication::model()->findAll($criteria);
	}

	public function getComplicationTypesByOpenElements()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'display_order asc';

		if (!$this->has_cataract) {
			$criteria->addCondition("name != 'Cataract'");
		}

		if (!$this->has_trabeculectomy) {
			$criteria->addCondition("name != 'Trabeculectomy'");
		}

		return OphTrOperationnote_Complication_Type::model()->findAll($criteria);
	}

	public function hasComplicationsOfType($type)
	{
		foreach ($this->complication_assignments as $assignment) {
			if ($assignment->complication->type_id == $type->id) {
				return true;
			}
		}

		return false;
	}
}
