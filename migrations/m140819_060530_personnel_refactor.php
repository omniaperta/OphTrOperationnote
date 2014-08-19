<?php

class m140819_060530_personnel_refactor extends OEMigration
{
	public function up()
	{
		$this->createTable('ophtroperationnote_personnel_role', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_personnel_role_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_personnel_role_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_personnel_role_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_personnel_role_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_personnel_role');

		$this->createTable('ophtroperationnote_personnel_item', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned not null',
				'role_id' => 'int(10) unsigned not null',
				'user_id' => 'int(10) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_personnel_item_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_personnel_item_cui_fk` (`created_user_id`)',
				'KEY `ophtroperationnote_personnel_item_ele_fk` (`element_id`)',
				'KEY `ophtroperationnote_personnel_item_rol_fk` (`role_id`)',
				'KEY `ophtroperationnote_personnel_item_uid_fk` (`user_id`)',
				'CONSTRAINT `ophtroperationnote_personnel_item_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_personnel_item_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_personnel_item_ele_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophtroperationnote_surgeon` (`id`)',
				'CONSTRAINT `ophtroperationnote_personnel_item_rol_fk` FOREIGN KEY (`role_id`) REFERENCES `ophtroperationnote_personnel_role` (`id`)',
				'CONSTRAINT `ophtroperationnote_personnel_item_uid_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophtroperationnote_personnel_item');

		$this->initialiseData(dirname(__FILE__));

		foreach ($this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_surgeon")->order("id asc")->queryAll() as $row) {
			foreach (array(
					'surgeon_id' => 1,
					'supervising_surgeon_id' => 2,
					'assistant_id' => 3,
				) as $field => $i) {
				if ($row[$field]) {
					$this->insert('ophtroperationnote_personnel_item',array(
						'element_id' => $row['id'],
						'role_id' => $i,
						'user_id' => $row[$field],
						'created_user_id' => $row['created_user_id'],
						'created_date' => $row['created_date'],
						'last_modified_user_id' => $row['last_modified_user_id'],
						'last_modified_date' => $row['last_modified_date'],
					));
				}

				foreach ($this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_surgeon_version")->where("id = :id",array(":id" => $row['id']))->order("version_id asc")->queryAll() as $v) {
					if ($v[$field]) {
						$this->insert('ophtroperationnote_personnel_item_version',array(
							'element_id' => $row['id'],
							'role_id' => $i,
							'user_id' => $v[$field],
							'created_user_id' => $v['created_user_id'],
							'created_date' => $v['created_date'],
							'last_modified_user_id' => $v['last_modified_user_id'],
							'last_modified_date' => $v['last_modified_date'],
							'id' => $v['id'],
							'version_date' => $v['version_date'],
						));
					}
				}
			}
		}

		$this->dropForeignKey('et_ophtroperationnote_sur_surgeon_id_fk','et_ophtroperationnote_surgeon');
		$this->dropColumn('et_ophtroperationnote_surgeon','surgeon_id');
		$this->dropColumn('et_ophtroperationnote_surgeon','assistant_id');
		$this->dropColumn('et_ophtroperationnote_surgeon','supervising_surgeon_id');

		$this->dropColumn('et_ophtroperationnote_surgeon_version','surgeon_id');
		$this->dropColumn('et_ophtroperationnote_surgeon_version','assistant_id');
		$this->dropColumn('et_ophtroperationnote_surgeon_version','supervising_surgeon_id');
	}

	public function down()
	{
		$this->addColumn('et_ophtroperationnote_surgeon','surgeon_id','int(10) unsigned not null');
		$this->addColumn('et_ophtroperationnote_surgeon','assistant_id','int(10) unsigned null');
		$this->addColumn('et_ophtroperationnote_surgeon','supervising_surgeon_id','int(10) unsigned null');

		$this->addColumn('et_ophtroperationnote_surgeon_version','surgeon_id','int(10) unsigned not null');
		$this->addColumn('et_ophtroperationnote_surgeon_version','assistant_id','int(10) unsigned null');
		$this->addColumn('et_ophtroperationnote_surgeon_version','supervising_surgeon_id','int(10) unsigned null');

		foreach ($this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_surgeon")->order("id asc")->queryAll() as $row) {
			foreach (array(
					'surgeon_id' => 1,
					'supervising_surgeon_id' => 2,
					'assistant_id' => 3,
				) as $field => $i) {
				if ($item = $this->dbConnection->createCommand()->select("*")->from("ophtroperationnote_personnel_item")->where("element_id = :ei and role_id = :ri",array(":ei" => $row['id'],"ri" => $i))->queryRow()) {
					$this->update('et_ophtroperationnote_surgeon',array($field => $item['user_id']),"id = {$row['id']}");
				}

				foreach ($this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_surgeon_version")->where("id = :id",array(":id" => $row['id']))->order("version_id asc")->queryAll() as $v) {
					if ($item = $this->dbConnection->createCommand()->select("*")->from("ophtroperationnote_personnel_item_version")->where("id = :id and version_date = :vd and role_id = :ri",array(":id" => $row['id'],":vd" => $v['version_date'],":ri" => $i))->queryRow()) {
						$this->update('et_ophtroperationnote_surgeon_version',array($field => $item['user_id']),"version_id = {$v['version_id']}");
					}
				}
			}
		}

		$this->addForeignKey('et_ophtroperationnote_sur_surgeon_id_fk','et_ophtroperationnote_surgeon','surgeon_id','user','id');

		$this->dropTable('ophtroperationnote_personnel_item_version');
		$this->dropTable('ophtroperationnote_personnel_item');
		
		$this->dropTable('ophtroperationnote_personnel_role_version');
		$this->dropTable('ophtroperationnote_personnel_role');
	}
}
