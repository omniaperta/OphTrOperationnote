<div class="operation-meta">
	<div class="row data-row">
		<div class="large-3 column">
			<div class="data-label">Operation(s) Performed:</div>
		</div>
		<div class="large-9 column">
			<ul>
			<?php
				$operations_perf = Element_OphTrOperationnote_ProcedureList::model()->find("event_id = ?", array($this->event->id));
				foreach ($operations_perf->procedures as $procedure) {
					echo "<li>{$operations_perf->eye->name} {$procedure->term}</li>";
				}
			?>
			</ul>
		</div>
	</div>
	<?php
		$surgeon_element = Element_OphTrOperationnote_Surgeon::model()->find("event_id = ?", array($this->event->id));
	?>
	<div class="row data-row surgeons">
		<?php foreach ($surgeon_element->items as $item) {?>
			<div class="large-4 column">
				<div class="data-label"><?php echo $item->role->name?></div>
				<div class="data-value"><?php echo $item->user->fullNameAndTitle?></div>
			</div>
		<?php }?>
	</div>
