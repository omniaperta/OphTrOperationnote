<?php

class m140801_122208_change_event_type_name extends CDbMigration
{
	public function up()
	{
		$this->update('event_type',
			array('name' => 'Operation note'),
			"class_name = 'OphTrOperationnote'"
		);
	}

	public function down()
	{
		$this->update('event_type',
			array('name' => 'Operation Note'),
			"class_name = 'OphTrOperationnote'"
		);
	}
}