<?php

class m140725_132122_who_timeout_element extends OEMigration
{
	public function up()
	{
		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = :class_name",array(":class_name" => "OphTrOperationnote"))->queryRow();

		$this->insert('element_type',array(
			'event_type_id' => $et['id'],
			'name' => 'WHO time-out',
			'class_name' => 'Element_OphTrOperationnote_TimeOut',
			'display_order' => 55,
			'default' => 0,
			'required' => 0,
		));

		$this->createTable('et_ophtroperationnote_timeout', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'who_timeout_completed' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtroperationnote_timeout_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophtroperationnote_timeout_cui_fk` (`created_user_id`)',
				'KEY `et_ophtroperationnote_timeout_ev_fk` (`event_id`)',
				'CONSTRAINT `et_ophtroperationnote_timeout_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_timeout_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_timeout_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('et_ophtroperationnote_timeout');
	}

	public function down()
	{
		$this->dropTable('et_ophtroperationnote_timeout_version');
		$this->dropTable('et_ophtroperationnote_timeout');

		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = :class_name",array(":class_name" => "OphTrOperationnote"))->queryRow();

		$this->delete('element_type',"event_type_id = {$et['id']} and class_name = 'Element_OphTrOperationnote_TimeOut'");
	}
}
