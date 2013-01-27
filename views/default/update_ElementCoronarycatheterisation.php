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
?>

<div class="element <?php echo $element->elementType->class_name?> ondemand<?php if (@$ondemand){?> hidden<?php }?>"
	data-element-type-id="<?php echo $element->elementType->id ?>"
	data-element-type-class="<?php echo $element->elementType->class_name ?>"
	data-element-type-name="<?php echo $element->elementType->name ?>"
	data-element-display-order="<?php echo $element->elementType->display_order ?>">
	<h4 class="elementTypeName"><?php echo $element->elementType->name ?></h4>

	<div class="splitElement clearfix" style="background-color: #DAE6F1;">
		<div class="left" style="width:45%;">
			<?php
			$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
					'doodleToolBarArray'=>array('Stenosis', 'MetalStent', 'Bypass'),
					'scriptArray'=>array('ED_Cardiology.js'),
					'side'=>'R',
					'mode'=>'edit',
					'width'=>400,
					'height'=>400,
					'idSuffix'=> 'RPS',
					'model'=>$element,
					'attribute'=>'eyedraw',
					'offsetX'=>10,
					'offsetY'=>10,
					'onReadyCommandArray'=>array(
						array('addDoodle', array('Aorta')),
						array('addDoodle', array('RightCoronaryArtery')),
						array('addDoodle', array('LeftCoronaryArtery')),
						array('deselectDoodles'),
					),
					'bindingArray'=>array(
						'Stenosis'=>array(
							'type'=>array('id'=>'ElementCoronarycatheterisation_stenosis_type'),
							'degree'=>array('id'=>'ElementCoronarycatheterisation_stenosis_percent')
						),
					),
					'deleteValueArray'=>array(
						//'Eyedraw_stringField1'=>'None',
					),
			))?>
			<?php echo $form->textArea($element, 'eyedraw_report', array('rows'=>6,'cols'=>50))?>
			<button class="cardioReport classy blue mini" type="button">
				<span class="button-span button-span-green">Report</span>
			</button>
		</div>
		<div class="right" style="width:55%;">
			<div class="halfHeight">
				<?php echo $form->textField($element, 'local_anaesthetic_time', array('style'=>'width: 50px'))?>
				<?php echo $form->radioButtons($element, 'side_id', 'ophtroperationnote_coronary_side')?>
				<?php echo $form->radioButtons($element, 'access_id', 'ophtroperationnote_coronary_access')?>
				<?php echo $form->radioButtons($element, 'vein_artery_id' ,'ophtroperationnote_coronary_vein_artery', null, false, ($element->access_id != 2))?>
				<?php echo $form->dropDownList($element, 'type_id', CHtml::listData(OphTrOperationnote_Coronary_Type::model()->findAll(array('order'=>'display_order')),'id','name'))?>
				<?php echo $form->textField($element, 'edv', array('style'=>'width: 50px', 'right_text'=>'mL'))?>
				<?php echo $form->textField($element, 'pullback_gradiant', array('style'=>'width: 50px', 'right_text'=>'mmHg'))?>
				<?php echo $form->radioBoolean($element, 'dccv')?>
				<?php echo $form->textField($element, 'dccv_notes', array('hide'=>!$element->dccv))?>
				<?php echo $form->textField($element, 'completion_time', array('style'=>'width: 50px'))?>
				<?php echo $form->textField($element, 'contrast_given', array('style'=>'width: 50px','right_text' => 'mL'))?>
				<?php echo $form->textField($element, 'xray_amount', array('style'=>'width: 50px','right_text'=>'mSv'))?>
				<?php echo $form->radioBoolean($element, 'angeo_seal')?>
				<?php echo $form->radioBoolean($element, 'tr_band')?>
				<?php echo $form->dropDownList($element, 'catheter_id', CHtml::listData(OphTrOperationnote_Coronary_Catheter::model()->findAll(array('order'=>'display_order')),'id','name'),array('empty'=>'-- Please select --'))?>
				<?php echo $form->dropDownList($element, 'stenosis_type', CHtml::listData(OphTrOperationnote_Coronary_Stenosis_Type::model()->findAll(array('order'=>'display_order')),'name','name'))?>
				<?php echo $form->textField($element, 'stenosis_percent', array('style'=>'width: 50px','right_text'=>'%'))?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$('input[name="ElementCoronarycatheterisation[access_id]"]').unbind('click').click(function() {
	if ($('#ElementCoronarycatheterisation_access_id_1').is(':checked')) {
		$('#ElementCoronarycatheterisation_vein_artery_id').hide();
	} else {
		$('#ElementCoronarycatheterisation_vein_artery_id').show();
	}
});
$('input[name="ElementCoronarycatheterisation[dccv]"]').unbind('click').click(function() {
	if ($('#ElementCoronarycatheterisation_dccv_1').is(':checked')) {
		$('#div_ElementCoronarycatheterisation_dccv_notes').show();
	} else {
		$('#div_ElementCoronarycatheterisation_dccv_notes').hide();
	}
});
$('button.cardioReport').unbind('click').click(function() {
	$('#ElementCoronarycatheterisation_eyedraw_report').text(ed_drawing_edit_RPS.report());
	return false;
});
</script>
