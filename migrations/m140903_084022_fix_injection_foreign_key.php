<?php

class m140903_084022_fix_injection_foreign_key extends CDbMigration
{
	public function up()
	{
		$this->dropForeignKey('et_ophtroperationnote_injection_igb_id_fk','et_ophtroperationnote_injection');
		$this->addForeignKey('et_ophtroperationnote_injection_igb_id_fk','et_ophtroperationnote_injection','injection_given_by_id','user','id');
	}

	public function down()
	{
		$this->dropForeignKey('et_ophtroperationnote_injection_igb_id_fk','et_ophtroperationnote_injection');
		$this->addForeignKey('et_ophtroperationnote_injection_igb_id_fk','et_ophtroperationnote_injection','injection_given_by_id','ophtroperationnote_inject_user','id');
	}
}
