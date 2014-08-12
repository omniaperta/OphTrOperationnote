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
					<div class="large-4 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('lens_id'))?>:</div>
					</div>
					<div class="large-8 column">
						<div class="data-value"><?php echo $element->lens->name?></div>
					</div>
				</div>
				<?php if ($element->lens->name == 'Other (please specify)') {?>
					<div class="row data-row">
						<div class="large-4 column">
							<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('lens_other'))?>:</div>
						</div>
						<div class="large-8 column">
							<div class="data-value"><?php echo $element->lens_other?></div>
						</div>
					</div>
				<?php }?>
				<div class="row data-row">
					<div class="large-4 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('duration_id'))?>:</div>
					</div>
					<div class="large-8 column">
						<div class="data-value"><?php echo $element->duration->name?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-4 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('power'))?>:</div>
					</div>
					<div class="large-8 column">
						<div class="data-value"><?php echo $element->power?> Milliwatts</div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-4 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('shots'))?>:</div>
					</div>
					<div class="large-8 column">
						<div class="data-value"><?php echo CHtml::encode($element->shots)?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-4 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('spot_size_id'))?>:</div>
					</div>
					<div class="large-8 column">
						<div class="data-value"><?php echo $element->spot_size->name?></div>
					</div>
				</div>
				<div class="row data-row">
					<div class="large-4 column">
						<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('pattern_id'))?>:</div>
					</div>
					<div class="large-8 column">
						<div class="data-value"><?php echo CHtml::encode($element->pattern->name)?></div>
					</div>
				</div>
				<?php if ($element->lens->name == 'YAG') {?>
					<div class="row data-row">
						<header class="sub-element-header">
							<h3 class="sub-element-title">YAG</h3>
						</header>
					</div>
					<div class="row data-row">
						<div class="large-4 column">
							<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('yag_pulses'))?>:</div>
						</div>
						<div class="large-8 column">
							<div class="data-value"><?php echo CHtml::encode($element->yag_pulses)?></div>
						</div>
					</div>
					<div class="row data-row">
						<div class="large-4 column">
							<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('yag_power'))?>:</div>
						</div>
						<div class="large-8 column">
							<div class="data-value"><?php echo CHtml::encode($element->yag_power)?> mJ</div>
						</div>
					</div>
					<div class="row data-row">
						<div class="large-4 column">
							<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('yag_energy'))?>:</div>
						</div>
						<div class="large-8 column">
							<div class="data-value"><?php echo CHtml::encode($element->yag_energy)?> mJ</div>
						</div>
					</div>
				<?php }?>
			</div>
			<div class="large-6 column">
				<?php if ($element->antseg) {
					$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
							'idSuffix'=>'AnteriorSegment',
							'side'=>$element->eye->getShortName(),
							'mode'=>'view',
							'width'=>200,
							'height'=>200,
							'model'=>$element,
							'attribute'=>'antseg',
						));
				}
				if ($element->postpole) {
					$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
							'idSuffix'=>'PosteriorPole',
							'side'=>$element->eye->getShortName(),
							'mode'=>'view',
							'width'=>200,
							'height'=>200,
							'model'=>$element,
							'attribute'=>'postpole',
						));
				}
				if ($element->fundus) {
					$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
							'idSuffix'=>'Fundus',
							'side'=>$element->eye->getShortName(),
							'mode'=>'view',
							'width'=>200,
							'height'=>200,
							'model'=>$element,
							'attribute'=>'fundus',
						));
				}
				?>
			</div>
		</div>
	</div>
</section>
