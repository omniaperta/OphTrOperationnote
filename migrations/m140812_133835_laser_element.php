<?php

class m140812_133835_laser_element extends OEMigration
{
	public function up()
	{
		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = 'OphTrOperationnote'")->queryRow();
		$pl = $this->dbConnection->createCommand()->select("*")->from("element_type")->where("event_type_id = {$et['id']} and class_name = 'Element_OphTrOperationnote_ProcedureList'")->queryRow();

		$this->insert('element_type',array(
			'name' => 'Laser',
			'class_name' => 'Element_OphTrOperationnote_Laser',
			'event_type_id' => $et['id'],
			'display_order' => 20,
			'default' => 0,
			'parent_element_type_id' => $pl['id'],
			'required' => 0,
			'active' => 0,
		));

		$this->createTable('ophtroperationnote_laser_lens', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_laser_lens_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_laser_lens_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_laser_lens_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_laser_lens_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_laser_lens');

		$this->createTable('ophtroperationnote_laser_duration', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_laser_duration_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_laser_duration_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_laser_duration_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_laser_duration_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_laser_duration');

		$this->createTable('ophtroperationnote_laser_spot_size', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_laser_spot_size_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_laser_spot_size_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_laser_spot_size_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_laser_spot_size_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_laser_spot_size');

		$this->createTable('ophtroperationnote_laser_pattern', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_laser_pattern_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_laser_pattern_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_laser_pattern_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_laser_pattern_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_laser_pattern');															 

		$this->createTable('et_ophtroperationnote_laser', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'antseg' => 'text not null',
				'postpole' => 'text not null',
				'fundus' => 'text not null',
				'lens_id' => 'int(10) unsigned not null',
				'lens_other' => 'varchar(64) not null',
				'duration_id' => 'int(10) unsigned not null',
				'power' => 'int(2) null',
				'shots' => 'int(2) null',
				'spot_size_id' => 'int(10) unsigned not null',
				'pattern_id' => 'int(10) unsigned not null',
				'yag_pulses' => 'int(2) null',
				'yag_power' => 'int(2) null',
				'yag_energy' => 'int(2) null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtroperationnote_laser_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophtroperationnote_laser_cui_fk` (`created_user_id`)',
				'KEY `et_ophtroperationnote_laser_ev_fk` (`event_id`)',
				'KEY `et_ophtroperationnote_laser_li_fk` (`lens_id`)',
				'KEY `et_ophtroperationnote_laser_di_fk` (`duration_id`)',
				'KEY `et_ophtroperationnote_laser_ss_fk` (`spot_size_id`)',
				'KEY `et_ophtroperationnote_laser_pi_fk` (`pattern_id`)',
				'CONSTRAINT `et_ophtroperationnote_laser_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_laser_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_laser_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_laser_li_fk` FOREIGN KEY (`lens_id`) REFERENCES `ophtroperationnote_laser_lens` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_laser_di_fk` FOREIGN KEY (`duration_id`) REFERENCES `ophtroperationnote_laser_duration` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_laser_ss_fk` FOREIGN KEY (`spot_size_id`) REFERENCES `ophtroperationnote_laser_spot_size` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_laser_pi_fk` FOREIGN KEY (`pattern_id`) REFERENCES `ophtroperationnote_laser_pattern` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('et_ophtroperationnote_laser');

		$this->initialiseData(dirname(__FILE__));
	}

	public function down()
	{
		$this->dropTable('et_ophtroperationnote_laser_version');
		$this->dropTable('et_ophtroperationnote_laser');

		$this->dropTable('ophtroperationnote_laser_pattern_version');
		$this->dropTable('ophtroperationnote_laser_pattern');

		$this->dropTable('ophtroperationnote_laser_spot_size_version');
		$this->dropTable('ophtroperationnote_laser_spot_size');

		$this->dropTable('ophtroperationnote_laser_duration_version');
		$this->dropTable('ophtroperationnote_laser_duration');

		$this->dropTable('ophtroperationnote_laser_lens_version');
		$this->dropTable('ophtroperationnote_laser_lens');

		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = 'OphTrOperationnote'")->queryRow();

		$el = $this->dbConnection->createCommand()->select("*")->from("element_type")->where("event_type_id = {$et['id']} and class_name = 'Element_OphTrOperationnote_Laser'")->queryRow();

		$this->delete('ophtroperationnote_procedure_element',"element_type_id = {$el['id']}");

		$this->delete('element_type',"event_type_id = {$et['id']} and class_name = 'Element_OphTrOperationnote_Laser'");
	}
}
