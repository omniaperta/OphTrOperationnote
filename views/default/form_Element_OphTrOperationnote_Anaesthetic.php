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
<div class="element-fields">
	<?php echo $form->radioButtons($element, 'anaesthetic_type_id', 'AnaestheticType',null,false,false,false,false,array(),array('label' => 2,'field' => 8))?>
	<?php echo $form->radioButtons($element, 'anaesthetist_id', 'Anaesthetist', false, false, $element->hidden, false,false,array(),array('label' => 2,'field' => 8))?>
	<?php if ($element->getSetting('fife')) {?>
		<?php echo $form->dropDownList($element, 'anaesthetic_witness_id', CHtml::listData($element->surgeons, 'id', 'FullName'), array('empty'=>'- Please select -'), $element->witness_hidden,array('label'=>2,'field'=>4));?>
	<?php }?>
	<?php echo $form->radioButtons($element, 'anaesthetic_delivery_id', 'AnaestheticDelivery', false,4, $element->hidden,false,false,array(),array('label' => 2,'field' => 8))?>
	<?php echo $form->multiSelectList($element, 'anaesthetic_agents', 'anaesthetic_agents', 'id', $this->getAnaesthetic_agent_list($element), null, array('empty' => '- Anaesthetic agents -', 'label' => 'Agents'), $element->hidden,false,null,false,false,array('label'=>2,'field'=>3))?>
	<div class="eventDetail row field-row">
		<div class="large-2 column"><label></label></div>
		<div class="large-8 column end">
			<span class="error">Anaesthetic complications are now in the <a class="showComplicationsElement">complications element</a></span>
		</div>
	</div>
	<?php echo $form->textArea($element, 'anaesthetic_comment', array(), $element->hidden, array('rows'=>4), array('label' => 2, 'field' => 4))?>
</div>
