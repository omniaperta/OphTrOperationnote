<?php

class m140725_172733_injection_element_fields extends OEMigration
{
	public function up()
	{
		$this->createTable('ophtroperationnote_inject_antiseptic_drug', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_inject_antiseptic_drug_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_inject_antiseptic_drug_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_inject_antiseptic_drug_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_antiseptic_drug_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_inject_antiseptic_drug');

		$this->createTable('ophtroperationnote_inject_skin_drug', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_inject_skin_drug_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_inject_skin_drug_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_inject_skin_drug_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_skin_drug_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_inject_skin_drug');

		$this->createTable('ophtroperationnote_inject_treatment_drug', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_inject_treatment_drug_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_inject_treatment_drug_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_inject_treatment_drug_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_treatment_drug_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_inject_treatment_drug');

		$this->createTable('ophtroperationnote_inject_drop', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_inject_drop_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_inject_drop_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_inject_drop_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_drop_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_inject_drop');

		$this->createTable('ophtroperationnote_inject_iopl', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_inject_iopl_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_inject_iopl_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_inject_iopl_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_iopl_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_inject_iopl');

		$this->createTable('ophtroperationnote_inject_pre_iopl_assign', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned not null',
				'iopl_id' => 'int(10) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_inject_pre_iopl_assign_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_inject_pre_iopl_assign_cui_fk` (`created_user_id`)',
				'KEY `ophtroperationnote_inject_pre_iopl_assign_ele_fk` (`element_id`)',
				'KEY `ophtroperationnote_inject_pre_iopl_assign_iopl_fk` (`iopl_id`)',
				'CONSTRAINT `ophtroperationnote_inject_pre_iopl_assign_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_pre_iopl_assign_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_pre_iopl_assign_ele_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophtroperationnote_injection` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_pre_iopl_assign_iopl_fk` FOREIGN KEY (`iopl_id`) REFERENCES `ophtroperationnote_inject_iopl` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_inject_pre_iopl_assign');

		$this->createTable('ophtroperationnote_inject_post_iopl_assign', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned not null',
				'iopl_id' => 'int(10) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_inject_post_iopl_assign_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_inject_post_iopl_assign_cui_fk` (`created_user_id`)',
				'KEY `ophtroperationnote_inject_post_iopl_assign_ele_fk` (`element_id`)',
				'KEY `ophtroperationnote_inject_post_iopl_assign_iopl_fk` (`iopl_id`)',
				'CONSTRAINT `ophtroperationnote_inject_post_iopl_assign_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_post_iopl_assign_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_post_iopl_assign_ele_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophtroperationnote_injection` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_post_iopl_assign_iopl_fk` FOREIGN KEY (`iopl_id`) REFERENCES `ophtroperationnote_inject_iopl` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_inject_post_iopl_assign');

		$this->createTable('ophtroperationnote_inject_user', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'user_id' => 'int(10) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_inject_user_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_inject_user_cui_fk` (`created_user_id`)',
				'KEY `ophtroperationnote_inject_user_user_fk` (`user_id`)',
				'CONSTRAINT `ophtroperationnote_inject_user_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_user_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_inject_user_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_inject_user');

		$this->initialiseData(dirname(__FILE__));

		$this->addColumn('et_ophtroperationnote_injection','pre_antisept_drug_id','int(10) unsigned DEFAULT NULL');
		$this->addForeignKey('et_ophtroperationnote_injection_pad_id_fk','et_ophtroperationnote_injection','pre_antisept_drug_id','ophtroperationnote_inject_antiseptic_drug','id');
		$this->addColumn('et_ophtroperationnote_injection','pre_skin_drug_id','int(10) unsigned DEFAULT NULL');
		$this->addForeignKey('et_ophtroperationnote_injection_psd_id_fk','et_ophtroperationnote_injection','pre_skin_drug_id','ophtroperationnote_inject_skin_drug','id');
		$this->addColumn('et_ophtroperationnote_injection','pre_ioplowering_required','tinyint(1) DEFAULT NULL');
		$this->addColumn('et_ophtroperationnote_injection','drug_id','int(10) unsigned DEFAULT NULL');
		$this->addForeignKey('et_ophtroperationnote_injection_drug_id_fk','et_ophtroperationnote_injection','drug_id','ophtroperationnote_inject_treatment_drug','id');
		$this->addColumn('et_ophtroperationnote_injection','number','int(10) unsigned DEFAULT NULL');
		$this->addColumn('et_ophtroperationnote_injection','batch_number','varchar(255)');
		$this->addColumn('et_ophtroperationnote_injection','batch_expiry_date','date null');
		$this->addColumn('et_ophtroperationnote_injection','injection_given_by_id','int(10) unsigned DEFAULT NULL');
		$this->addForeignKey('et_ophtroperationnote_injection_igb_id_fk','et_ophtroperationnote_injection','injection_given_by_id','ophtroperationnote_inject_user','id');
		$this->addColumn('et_ophtroperationnote_injection','injection_time','time null');
		$this->addColumn('et_ophtroperationnote_injection','post_ioplowering_required','tinyint(1) null');

		$this->addColumn('et_ophtroperationnote_injection_version','pre_antisept_drug_id','int(10) unsigned DEFAULT NULL');
		$this->addColumn('et_ophtroperationnote_injection_version','pre_skin_drug_id','int(10) unsigned DEFAULT NULL');
		$this->addColumn('et_ophtroperationnote_injection_version','pre_ioplowering_required','tinyint(1) DEFAULT NULL');
		$this->addColumn('et_ophtroperationnote_injection_version','drug_id','int(10) unsigned DEFAULT NULL');
		$this->addColumn('et_ophtroperationnote_injection_version','number','int(10) unsigned DEFAULT NULL');
		$this->addColumn('et_ophtroperationnote_injection_version','batch_number','varchar(255)');
		$this->addColumn('et_ophtroperationnote_injection_version','batch_expiry_date','date null');
		$this->addColumn('et_ophtroperationnote_injection_version','injection_given_by_id','int(10) unsigned DEFAULT NULL');
		$this->addColumn('et_ophtroperationnote_injection_version','injection_time','time null');
		$this->addColumn('et_ophtroperationnote_injection_version','post_ioplowering_required','tinyint(1) null');

		$this->addColumn('et_ophtroperationnote_injection','finger_count','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtroperationnote_injection','iop_checked','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtroperationnote_injection','postinject_drops_id','int(10) unsigned null');
		$this->addForeignKey('et_ophtroperationnote_injection_pd_id_fk','et_ophtroperationnote_injection','postinject_drops_id','ophtroperationnote_inject_drop','id');

		$this->addColumn('et_ophtroperationnote_injection_version','finger_count','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtroperationnote_injection_version','iop_checked','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtroperationnote_injection_version','postinject_drops_id','int(10) unsigned null');
	}

	public function down()
	{
		$this->dropColumn('et_ophtroperationnote_injection_version','postinject_drops_id');
		$this->dropColumn('et_ophtroperationnote_injection_version','iop_checked');
		$this->dropColumn('et_ophtroperationnote_injection_version','finger_count');

		$this->dropForeignKey('et_ophtroperationnote_injection_pd_id_fk','et_ophtroperationnote_injection');
		$this->dropColumn('et_ophtroperationnote_injection','postinject_drops_id');
		$this->dropColumn('et_ophtroperationnote_injection','iop_checked');
		$this->dropColumn('et_ophtroperationnote_injection','finger_count');

		$this->dropColumn('et_ophtroperationnote_injection_version','pre_antisept_drug_id');
		$this->dropColumn('et_ophtroperationnote_injection_version','pre_skin_drug_id');
		$this->dropColumn('et_ophtroperationnote_injection_version','pre_ioplowering_required');
		$this->dropColumn('et_ophtroperationnote_injection_version','drug_id');
		$this->dropColumn('et_ophtroperationnote_injection_version','number');
		$this->dropColumn('et_ophtroperationnote_injection_version','batch_number');
		$this->dropColumn('et_ophtroperationnote_injection_version','batch_expiry_date');
		$this->dropColumn('et_ophtroperationnote_injection_version','injection_given_by_id');
		$this->dropColumn('et_ophtroperationnote_injection_version','injection_time');
		$this->dropColumn('et_ophtroperationnote_injection_version','post_ioplowering_required');

		$this->dropForeignKey('et_ophtroperationnote_injection_pad_id_fk','et_ophtroperationnote_injection');
		$this->dropColumn('et_ophtroperationnote_injection','pre_antisept_drug_id');
		$this->dropForeignKey('et_ophtroperationnote_injection_psd_id_fk','et_ophtroperationnote_injection');
		$this->dropColumn('et_ophtroperationnote_injection','pre_skin_drug_id');
		$this->dropColumn('et_ophtroperationnote_injection','pre_ioplowering_required');
		$this->dropForeignKey('et_ophtroperationnote_injection_drug_id_fk','et_ophtroperationnote_injection');
		$this->dropColumn('et_ophtroperationnote_injection','drug_id');
		$this->dropColumn('et_ophtroperationnote_injection','number');
		$this->dropColumn('et_ophtroperationnote_injection','batch_number');
		$this->dropColumn('et_ophtroperationnote_injection','batch_expiry_date');
		$this->dropForeignKey('et_ophtroperationnote_injection_igb_id_fk','et_ophtroperationnote_injection');
		$this->dropColumn('et_ophtroperationnote_injection','injection_given_by_id');
		$this->dropColumn('et_ophtroperationnote_injection','injection_time');
		$this->dropColumn('et_ophtroperationnote_injection','post_ioplowering_required');

		$this->dropTable('ophtroperationnote_inject_user_version');
		$this->dropTable('ophtroperationnote_inject_user');
		$this->dropTable('ophtroperationnote_inject_post_iopl_assign_version');
		$this->dropTable('ophtroperationnote_inject_post_iopl_assign');
		$this->dropTable('ophtroperationnote_inject_pre_iopl_assign_version');
		$this->dropTable('ophtroperationnote_inject_pre_iopl_assign');
		$this->dropTable('ophtroperationnote_inject_iopl_version');
		$this->dropTable('ophtroperationnote_inject_iopl');
		$this->dropTable('ophtroperationnote_inject_drop_version');
		$this->dropTable('ophtroperationnote_inject_drop');
		$this->dropTable('ophtroperationnote_inject_treatment_drug_version');
		$this->dropTable('ophtroperationnote_inject_treatment_drug');
		$this->dropTable('ophtroperationnote_inject_skin_drug_version');
		$this->dropTable('ophtroperationnote_inject_skin_drug');
		$this->dropTable('ophtroperationnote_inject_antiseptic_drug_version');
		$this->dropTable('ophtroperationnote_inject_antiseptic_drug');
	}
}
