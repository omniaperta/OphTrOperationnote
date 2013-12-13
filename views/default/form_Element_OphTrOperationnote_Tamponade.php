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

<section class="element <?php echo $element->elementType->class_name?> ondemand<?php if (@$ondemand) {?> hidden<?php }?><?php if ($this->action->id == 'update' && !$element->event_id) {?> missing<?php }?>"
	data-element-type-id="<?php echo $element->elementType->id ?>"
	data-element-type-class="<?php echo $element->elementType->class_name ?>"
	data-element-type-name="<?php echo $element->elementType->name ?>"
	data-element-display-order="<?php echo $element->elementType->display_order ?>">
	<?php if ($this->action->id == 'update' && !$element->event_id) {?>
		<div class="alert-box alert">This element is missing and needs to be completed</div>
	<?php }?>
	<header class="element-header">
		<h3 class="element-title"><?php  echo $element->elementType->name; ?></h3>
	</header>

	<div class="element-fields">
		<?php echo $form->dropDownList($element, 'gas_type_id', CHtml::listData(OphTrOperationnote_GasType::model()->findAll(array('order'=>'display_order')),'id','name'),array('empty'=>'- Please select -'),false,array('field'=>2))?>
		<?php echo $form->dropDownList($element, 'gas_percentage_id', CHtml::listData(OphTrOperationnote_GasPercentage::model()->findAll(array('order'=>'display_order')),'id','value'),array('empty'=>'- Please select -'),false,array('field'=>2))?>
		<?php echo $form->dropDownList($element, 'gas_volume_id', CHtml::listData(OphTrOperationnote_GasVolume::model()->findAll(array('order'=>'display_order')),'id','value'),array('empty'=>'- Please select -'),false,array('field'=>2))?>
	</div>
</section>
