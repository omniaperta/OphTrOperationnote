<?php

class m140722_155204_injection_procedure_element extends OEMigration
{
	public function up()
	{
		$et = $this->dbConnection->createCommand()->select("id")->from("event_type")->where("class_name = :class_name",array(":class_name" => "OphTrOperationnote"))->queryRow();
		$pl = $this->dbConnection->createCommand()->select("id")->from("element_type")->where("event_type_id = :eti and class_name = :class_name",array(":eti" => $et['id'],":class_name" => "Element_OphTrOperationnote_ProcedureList"))->queryRow();

		$this->insert('element_type',array('name' => 'Injection', 'class_name' => 'Element_OphTrOperationnote_Injection', 'event_type_id' => $et['id'], 'display_order' => 20, 'default' => 0, 'parent_element_type_id' => $pl['id'], 'required' => 0));

		$this->createTable('ophtroperationnote_lens_status', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(255) not null',
				'default_distance' => 'decimal(2,1) NOT NULL',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_lens_status_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_lens_status_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_lens_status_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_lens_status_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_lens_status');

		$this->createTable('et_ophtroperationnote_injection', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eyedraw' => 'text not null',
				'lens_status_id' => 'int(10) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtroperationnote_injection_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophtroperationnote_injection_cui_fk` (`created_user_id`)',
				'KEY `et_ophtroperationnote_injection_ev_fk` (`event_id`)',
				'KEY `et_ophtroperationnote_injection_ls_fk` (`lens_status_id`)',
				'CONSTRAINT `et_ophtroperationnote_injection_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_injection_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_injection_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_injection_ls_fk` FOREIGN KEY (`lens_status_id`) REFERENCES `ophtroperationnote_lens_status` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('et_ophtroperationnote_injection');

		$this->initialiseData(dirname(__FILE__));
	}

	public function down()
	{
		$this->dropTable('et_ophtroperationnote_injection_version');
		$this->dropTable('et_ophtroperationnote_injection');
		$this->dropTable('ophtroperationnote_lens_status_version');
		$this->dropTable('ophtroperationnote_lens_status');

		$et = $this->dbConnection->createCommand()->select("id")->from("event_type")->where("class_name = :class_name",array(":class_name" => "OphTrOperationnote"))->queryRow();

		foreach ($this->dbConnection->createCommand()->select("id")->from("element_type")->where("event_type_id = {$et['id']} and class_name = 'Element_OphTrOperationnote_Injection'")->queryAll() as $et) {
			$this->delete('ophtroperationnote_procedure_element',"element_type_id = {$et['id']}");
			$this->delete('element_type',"id = {$et['id']}");
		}
	}
}
