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

<?php
$layoutColumns = array(
	'label' => 4,
	'field' => 8
);?>

<div class="element-fields">
	<div class="row">
		<div class="large-2 column">
			<label>Complications:</label>
		</div>
		<div class="large-8 column end">
			<table class="complications">
				<thead>
					<tr>
						<th class="type">Type</th>
						<th class="name">Complications</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach (OphTrOperationnote_Complication_Type::model()->findAll(array('order' => 'display_order')) as $type) {?>
						<tr id="complication_type_<?php echo $type->id?>" <?php if (empty($element->{strtolower($type->name)."_complications"})) {?> style="display: none"<?php }?>>
							<td><?php echo $type->name?></td>
							<td>
								<div class="multi-select multi-select-list">
									<ul class="MultiSelectList multi-select-selections">
										<?php foreach ($element->{strtolower($type->name)."_complications"} as $complication) {?>
											<li>
												<span class="text"><?php echo $complication->name?></span>
												<a class="removeComplication remove-one">Remove</a>
												<input type="hidden" name="<?php echo CHtml::modelName($element)?>[complications]" value="<?php echo $complication->id?>" />
											</li>
										<?php }?>
									</ul>
								</div>
							</td>
						</tr>
					<?php }?>
				</tbody>
				<tfoot>
					<tr>
						<td>
							<?php echo CHtml::dropDownList('complication_type','',CHtml::listData(OphTrOperationnote_Complication_Type::model()->findAll(array('order' => 'display_order')),'id','name'))?>
						</td>
						<td>
							<?php echo CHtml::dropDownList('complication','',$element->getComplicationsNotSelectedByType(1),array('empty' => '- Select -'))?>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="large-6 column">
			<?php echo $form->textArea($element, 'comments',array(),false,array(),$layoutColumns)?>
		</div>
	</div>
</div>
