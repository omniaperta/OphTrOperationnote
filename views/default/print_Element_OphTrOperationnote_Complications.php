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
<section class="element <?php echo $element->elementType->class_name?>">
	<h3 class="element-title highlight"><?php echo $element->elementType->name ?></h3>
	<div class="details">
		<div class="element-data">
			<div class="row">
				<div class="large-4 column">
					<div class="data-row">
						<h4 class="data-title"><?php echo CHtml::encode($element->getAttributeLabel('complications'))?></h4>
						<div class="data-value">
							<?php if ($element->complications) {?>
								<?php foreach ($element->complications as $complication) {?>
									<?php echo $complication->name?><br/>
								<?php }?>
							<?php }else{?>
								None
							<?php }?>
						</div>
					</div>
					<?php if (Element_OphTrOperationnote_Cataract::model()->find('event_id=?',array($element->event_id))) {?>
						<div class="data-row">
							<h4 class="data-title"><?php echo CHtml::encode($element->getAttributeLabel('cataract_complications'))?></h4>
							<div class="data-value">
								<?php if ($element->cataract_complications) {?>
									<?php foreach ($element->cataract_complications as $complication) {?>
										<?php echo $complication->name?><br/>
									<?php }?>
								<?php }else{?>
									None
								<?php }?>
							</div>
						</div>
					<?php }?>
					<?php if (Element_OphTrOperationnote_Trabectome::model()->find('event_id=?',array($element->event_id))) {?>
						<div class="data-row">
							<h4 class="data-title"><?php echo CHtml::encode($element->getAttributeLabel('trabectome_complications'))?></h4>
							<div class="data-value">
								<?php if ($element->trabectome_complications) {?>
									<?php foreach ($element->complication_assignments as $assignment) {
										if ($assignment->complication->type->name == 'Trabectome') {?>
											<?php if ($assignment->other) {
												echo $assignment->other;
											} else {
												echo $assignment->complication->name;
											}?>
											<br/>
										<?php }?>
									<?php }?>
								<?php }else{?>
									None
								<?php }?>
							</div>
						</div>
					<?php }?>
					<?php if (Element_OphTrOperationnote_Trabeculectomy::model()->find('event_id=?',array($element->event_id))) {?>
						<div class="data-row">
							<h4 class="data-title"><?php echo CHtml::encode($element->getAttributeLabel('trabeculectomy_complications'))?></h4>
							<div class="data-value">
								<?php if ($element->trabeculectomy_complications) {?>
									<?php foreach ($element->complication_assignments as $assignment) {
										if ($assignment->complication->type->name == 'Trabeculectomy') {?>
											<?php if ($assignment->other) {
												echo $assignment->other;
											} else {
												echo $assignment->complication->name;
											}?>
											<br/>
										<?php }?>
									<?php }?>
								<?php }else{?>
									None
								<?php }?>
							</div>
						</div>
					<?php }?>
				</div>
				<div class="large-8 column">
					<div class="data-row">
						<h4 class="data-title"><?php echo CHtml::encode($element->getAttributeLabel('comments'))?></h4>
						<div class="data-value<?php if (!$element->comments) {?> none<?php }?>"><?php echo CHtml::encode($element->comments) ? Yii::app()->format->Ntext($element->comments) : 'None'?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
