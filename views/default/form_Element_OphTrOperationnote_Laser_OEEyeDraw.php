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
<div class="row field-row">
	<div class="large-4 column">
		<div class="inactive-form"<?php if (!$element->antseg) {?> style="display: block"<?php }?>>
			<div class="add-side add-eyedraw">
				<a href="#">
					Add Anterior segment
					<span class="icon-add-side"></span>
				</a>
			</div>
		</div>
		<div class="active-form"<?php if (!$element->antseg) {?> style="display: none"<?php }?>>
			<a href="#" class="icon-remove-side remove-side remove-eyedraw">Remove Anterior segment</a>
			<?php $this->renderPartial($element->form_view . '_OEEyeDraw_AnteriorSegment', array(
				'element' => $element,
				'form' => $form
			));?>
		</div>
	</div>
	<div class="large-4 column">
		<div class="inactive-form"<?php if (!$element->postpole) {?> style="display: block"<?php }?>>
			<div class="add-side add-eyedraw">
				<a href="#">
					Add Posterior pole
					<span class="icon-add-side"></span>
				</a>
			</div>
		</div>
		<div class="active-form"<?php if (!$element->postpole) {?> style="display: none"<?php }?>>
			<a href="#" class="icon-remove-side remove-side remove-eyedraw">Remove posterior pole</a>
			<?php $this->renderPartial($element->form_view . '_OEEyeDraw_PosteriorPole', array(
				'element' => $element,
				'form' => $form
			));?>
		</div>
	</div>
	<div class="large-4 column">
		<div class="inactive-form"<?php if (!$element->fundus) {?> style="display: block"<?php }?>>
			<div class="add-side add-eyedraw">
				<a href="#">
					Add Fundus
					<span class="icon-add-side"></span>
				</a>
			</div>
		</div>
		<div class="active-form"<?php if (!$element->fundus) {?> style="display: none"<?php }?>>
			<a href="#" class="icon-remove-side remove-side remove-eyedraw">Fundus</a>
			<?php $this->renderPartial($element->form_view . '_OEEyeDraw_Fundus', array(
				'element' => $element,
				'form' => $form
			));?>
		</div>
	</div>
</div>
