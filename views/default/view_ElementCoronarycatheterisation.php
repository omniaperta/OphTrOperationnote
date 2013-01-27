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

<h4><?php echo $element->elementType->name ?></h4>

<div class="cols2">
	<div class="right">
		<?php
		$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
				'scriptArray'=>array('ED_Cardiology.js'),
				'side'=>'R',
				'mode'=>'view',
				'width'=>300,
				'height'=>300,
				'idSuffix'=> 'RPS',
				'model'=>$element,
				'attribute'=>'eyedraw',
		))?>
	</div>
	<div class="left">
		<table class="subtleWhite normalText">
			<tbody>
				<tr>
					<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('local_anaesthetic_time'))?>:</td>
					<td><span class="big"><?php echo substr($element->local_anaesthetic_time,0,5)?></span></td>
				</tr>
				<?php /*
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('side_id'))?>:</td>
					<td><span class="big"><?php echo $element->side->name?></span></td>
				</tr>
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('access_id'))?>:</td>
					<td><span class="big"><?php echo $element->access->name?></span></td>
				</tr>
				<?php if ($element->access_id == 2 && $element->vein_artery) {?>
					<tr>
						<td><?php echo CHtml::encode($element->getAttributeLabel('vein_artery_id'))?>:</td>
						<td><span class="big"><?php echo $element->vein_artery->name?></span></td>
					</tr>
				<?php }?>
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('type_id'))?>:</td>
					<td><span class="big"><?php echo CHtml::encode($element->type->name)?></span></td>
				</tr>
				*/?>
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('edv'))?>:</td>
					<td><span class="big"><?php echo CHtml::encode($element->edv)?> mL</span></td>
				</tr>
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('pullback_gradiant'))?>:</td>
					<td><span class="big"><?php echo CHtml::encode($element->pullback_gradiant)?> mmHg</span></td>
				</tr>
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('dccv'))?>:</td>
					<td><span class="big"><?php echo CHtml::encode($element->dccv ? $element->dccv_notes : 'No')?></span></td>
				</tr>
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('completion_time'))?>:</td>
					<td><span class="big"><?php echo CHtml::encode(substr($element->completion_time,0,5))?></span></td>
				</tr>
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('contrast_given'))?>:</td>
					<td><span class="big"><?php echo CHtml::encode($element->contrast_given)?> mL</span></td>
				</tr>
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('xray_amount'))?>:</td>
					<td><span class="big"><?php echo CHtml::encode($element->xray_amount)?> mSv</span></td>
				</tr>
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('angeo_seal'))?>:</td>
					<td><span class="big"><?php echo CHtml::encode($element->angeo_seal ? 'Yes' : 'No')?></span></td>
				</tr>
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('tr_band'))?>:</td>
					<td><span class="big"><?php echo CHtml::encode($element->tr_band ? 'Yes' : 'No')?></span></td>
				</tr>
				<?php /*
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('catheter_id'))?>:</td>
					<td><span class="big"><?php echo CHtml::encode($element->catheter->name)?></span></td>
				</tr>
				*/?>
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('stenosis_type'))?>:</td>
					<td><span class="big"><?php echo CHtml::encode($element->stenosis_type)?></span></td>
				</tr>
				<tr>
					<td><?php echo CHtml::encode($element->getAttributeLabel('stenosis_percent'))?>:</td>
					<td><span class="big"><?php echo CHtml::encode($element->stenosis_percent)?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="colsX clearfix">
	<div class="colFourth">
		<h4>Catheterisation report</h4>
		<div class="eventHighlight medium">
			<h4>
				<?php foreach (explode(chr(10),CHtml::encode($element->eyedraw_report)) as $line) {?>
					<?php echo $line?><br/>
				<?php }?>
			</h4>
		</div>
	</div>

	<div class="colFourth">
		<h4>Catheters used</h4>
		<div class="eventHighlight medium">
			<table class="catheterListView">
				<thead>
					<tr>
						<th>Type</th>
						<th>Access</th>
						<th>Side</th>
						<th>Vessel</th>
						<th>Use</th>
						<th>Result</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($element->catheters as $catheter) {?>
						<tr>
							<td><?php echo $catheter->catheter->name?></td>
							<td><?php echo $catheter->access->name?></td>
							<td><?php echo $catheter->side->name?></td>
							<td><?php echo $catheter->vein_artery->name?></td>
							<td><?php echo $catheter->type->name?></td>
							<td><?php echo $catheter->success ? 'Success' : 'Failed'?></td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>

<?php /*
	<div class="colThird">
		<h4>Cataract complications</h4>
		<div class="eventHighlight medium">
			<?php if (!$element->complications && !$element->complication_notes) {?>
				<h4>None</h4>
			<?php }else{?>
				<h4>
					<?php foreach ($element->complications as $complication) {?>
						<?php echo $complication->name?><br/>
					<?php }?>
					<?php echo CHtml::encode($element->complication_notes)?>
				</h4>
			<?php }?>
		</div>
	</div>
	*/?>
</div>
