<?php

class m140801_095737_discharge_element extends OEMigration
{
	public function up()
	{
		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = :cn",array(":cn" => "OphTrOperationnote"))->queryRow();

		$this->update('element_type',array('active' => 0),"event_type_id = {$et['id']} and (`default`=0 or required=0) and parent_element_type_id is null");

		$this->insert('element_type',array(
			'event_type_id' => $et['id'],
			'name' => 'Patient discharge',
			'class_name' => 'Element_OphTrOperationnote_PatientDischarge',
			'display_order' => 70,
			'default' => 0,
			'required' => 0,
			'active' => 0,
		));

		$this->createTable('et_ophtroperationnote_patientdischarge', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'tolerated_procedure' => 'tinyint(1) unsigned not null',
				'ocular_stable' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtroperationnote_patientdischarge_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophtroperationnote_patientdischarge_cui_fk` (`created_user_id`)',
				'KEY `et_ophtroperationnote_patientdischarge_ev_fk` (`event_id`)',
				'CONSTRAINT `et_ophtroperationnote_patientdischarge_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_patientdischarge_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_patientdischarge_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('et_ophtroperationnote_patientdischarge');
	}

	public function down()
	{
		$this->dropTable('et_ophtroperationnote_patientdischarge_version');
		$this->dropTable('et_ophtroperationnote_patientdischarge');

		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = :cn",array(":cn" => "OphTrOperationnote"))->queryRow();

		$this->delete('element_type',"event_type_id = {$et['id']} and class_name = 'Element_OphTrOperationnote_PatientDischarge'");
	}
}
