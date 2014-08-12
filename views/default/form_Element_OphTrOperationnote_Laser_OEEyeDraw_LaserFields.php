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
?>
<?php echo $form->dropDownList($element,'lens_id',CHtml::listData(OphTrOperationnote_Laser_Lens::model()->findAll(array('order'=>'display_order asc')),'id','name'),array('class' => 'linked-fields', 'data-linked-fields' => 'lens_other', 'data-linked-values' => 'Other (please specify)', 'empty' => '- Please select -'),false,array('label' => 2, 'field' => 2))?>
<?php echo $form->textField($element,'lens_other',array('hide' => !$element->lens || $element->lens->name != 'Other (please specify)'),array(),array('label' => 2, 'field' => 3))?>
<?php echo $form->dropDownList($element,'duration_id',CHtml::listData(OphTrOperationnote_Laser_Duration::model()->findAll(array('order'=>'display_order asc')),'id','name'),array('empty' => '- Please select -'),false,array('label' => 2, 'field' => 2))?>
<?php echo $form->textField($element,'power',array('append-text' => 'Milliwatts'),array(),array('label' => 2, 'field' => 2))?>
<?php echo $form->textField($element,'shots',array(),array(),array('label' => 2, 'field' => 1))?>
<?php echo $form->dropDownList($element,'spot_size_id',CHtml::listData(OphTrOperationnote_Laser_Spot_Size::model()->findAll(array('order'=>'display_order asc')),'id','name'),array('empty' => '- Please select -'),false,array('label' => 2, 'field' => 2))?>
<?php echo $form->dropDownList($element,'pattern_id',CHtml::listData(OphTrOperationnote_Laser_Pattern::model()->findAll(array('order'=>'display_order asc')),'id','name'),array('empty' => '- Please select -'),false,array('label' => 2, 'field' => 2))?>
