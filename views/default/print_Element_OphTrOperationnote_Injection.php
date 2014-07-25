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

<section class="sub-element">
	<header class="sub-element-header">
		<h3 class="sub-element-title"><?php echo $element->elementType->name ?></h3>
	</header>

	<div class="sub-element-data">
		<div class="row highlight-container">
			<div class="large-6 column data-value highlight">
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('lens_status_id'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->lens_status->name?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('pre_antisept_drug_id'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->pre_antisept_drug ? $element->pre_antisept_drug->name : 'None'?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('pre_skin_drug_id'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->pre_skin_drug ? $element->pre_skin_drug->name : 'None'?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('pre_ioplowering_required'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->pre_ioplowering_required ? 'Yes' : 'No'?></div>
					</div>
				</div>
				<?php if ($element->pre_ioplowering_required) {?>
					<div class="row data-row">
						<div class="large-6 column">
							<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('pre_ioploweringdrugs'))?>:</div>
						</div>
						<div class="large-6 column">
							<div class="data-value">
								<?php foreach ($element->pre_ioploweringdrugs as $drug) {?>
									<?php echo $drug->name?><br/>
								<?php }?>
							</div>
						</div>
					</div>
				<?php }?>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('drug_id'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->drug ? $element->drug->name : 'None'?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('number'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->number?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('batch_number'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->batch_number?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('batch_expiry_date'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->NHSDate('batch_expiry_date')?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('injection_given_by_id'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->injection_given_by ? $element->injection_given_by->fullName : 'None'?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('injection_time'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo substr($element->injection_time,0,5)?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('post_ioplowering_required'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->post_ioplowering_required ? 'Yes' : 'No'?></div>
					</div>
				</div>
				<?php if ($element->post_ioplowering_required) {?>
					<div class="row data-row">
						<div class="large-6 column">
							<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('post_ioploweringdrugs'))?>:</div>
						</div>
						<div class="large-6 column">
							<div class="data-value">
								<?php foreach ($element->post_ioploweringdrugs as $drug) {?>
									<?php echo $drug->name?><br/>
								<?php }?>
							</div>
						</div>
					</div>
				<?php }?>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('finger_count'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->finger_count ? 'Yes' : 'No'?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('iop_checked'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->iop_checked ? 'Yes' : 'No'?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-6 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('postinject_drops_id'))?>:</div>
					</div>
					<div class="large-6 column">
						<div class="data-value"><?php echo $element->postinject_drops ? $element->postinject_drops->name : 'None'?></div>
					</div>
				</div>
			</div>
			<div class="large-6 column">
				<?php
				$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
						'idSuffix'=>'Cataract',
						'side'=>$element->eye->getShortName(),
						'mode'=>'view',
						'width'=>200,
						'height'=>200,
						'model'=>$element,
						'attribute'=>'eyedraw',
						'idSuffix'=>'Injection',
					));
				?>
			</div>
		</div>
	</div>
</section>
