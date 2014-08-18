<?php

class m140818_140249_laser_event_changes extends CDbMigration
{
	public function up()
	{
		$this->addColumn('et_ophtroperationnote_laser','comments','varchar(2048) not null');
		$this->addColumn('et_ophtroperationnote_laser_version','comments','varchar(2048) not null');
	}

	public function down()
	{
		$this->dropColumn('et_ophtroperationnote_laser','comments');
		$this->dropColumn('et_ophtroperationnote_laser_version','comments');
	}
}
