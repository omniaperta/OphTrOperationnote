<?php

class m140721_122030_complications_element extends OEMigration
{
	public function up()
	{
		$et = $this->dbConnection->createCommand()->select("id")->from("event_type")->where("class_name = :class_name",array(":class_name" => "OphTrOperationnote"))->queryRow();

		$this->insert('element_type',array('name' => 'Complications', 'class_name' => 'Element_OphTrOperationnote_Complications', 'event_type_id' => $et['id'], 'display_order' => 35, 'default' => 1, 'required' => 1));

		$this->createTable('et_ophtroperationnote_complications', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'comments' => 'varchar(4096) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtroperationnote_complications_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophtroperationnote_complications_cui_fk` (`created_user_id`)',
				'KEY `et_ophtroperationnote_complications_ev_fk` (`event_id`)',
				'CONSTRAINT `et_ophtroperationnote_complications_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_complications_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_complications_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->createTable('ophtroperationnote_complication_type', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) NOT NULL',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_complication_type_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_complication_type_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_complication_type_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_complication_type_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->createTable('ophtroperationnote_complication', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'type_id' => 'int(10) unsigned NOT NULL',
				'name' => 'varchar(128) NOT NULL',
				'display_order' => 'tinyint(1) unsigned not null',
				'active' => 'tinyint(1) unsigned not null default 1',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_complication_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_complication_cui_fk` (`created_user_id`)',
				'KEY `ophtroperationnote_complication_typ_fk` (`type_id`)',
				'CONSTRAINT `ophtroperationnote_complication_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_complication_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_complication_typ_fk` FOREIGN KEY (`type_id`) REFERENCES `ophtroperationnote_complication_type` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->createTable('ophtroperationnote_complication_assignment', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned NOT NULL',
				'complication_id' => 'int(10) unsigned NOT NULL',
				'other' => 'varchar(255) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_complication_assn_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_complication_assn_cui_fk` (`created_user_id`)',
				'KEY `ophtroperationnote_complication_assn_ele_fk` (`element_id`)',
				'KEY `ophtroperationnote_complication_assn_com_fk` (`complication_id`)',
				'CONSTRAINT `ophtroperationnote_complication_assn_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_complication_assn_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_complication_assn_ele_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophtroperationnote_complications` (`id`)',
				'CONSTRAINT `ophtroperationnote_complication_assn_com_fk` FOREIGN KEY (`complication_id`) REFERENCES `ophtroperationnote_complication` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('et_ophtroperationnote_complications');
		$this->versionExistingTable('ophtroperationnote_complication_type');
		$this->versionExistingTable('ophtroperationnote_complication');
		$this->versionExistingTable('ophtroperationnote_complication_assignment');

		$this->initialiseData(dirname(__FILE__));

		$complications = array();

		foreach ($this->dbConnection->createCommand()->select("*")->from("ophtroperationnote_complication")->queryAll() as $c) {
			$complications[$c['type_id']][$c['name']] = $c['id'];
		}

		foreach ($this->dbConnection->createCommand()->select("*")->from("event")->where("event_type_id = :event_type_id",array(":event_type_id" => $et['id']))->queryAll() as $event) {
			$this->insert('et_ophtroperationnote_complications',array(
				'created_user_id' => $event['created_user_id'],
				'created_date' => $event['created_date'],
				'last_modified_user_id' => $event['last_modified_user_id'],
				'last_modified_date' => $event['last_modified_date'],
				'event_id' => $event['id'],
			));

			$element_id = $this->dbConnection->createCommand()->select("max(id)")->from("et_ophtroperationnote_complications")->queryScalar();

			if ($an = $this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_anaesthetic")->where("event_id = :event_id",array(":event_id" => $event['id']))->queryRow()) {
				foreach ($this->dbConnection->createCommand()
					->select("ophtroperationnote_anaesthetic_anaesthetic_complications.name, ophtroperationnote_anaesthetic_anaesthetic_complication.*")
					->from("ophtroperationnote_anaesthetic_anaesthetic_complication")
					->join("ophtroperationnote_anaesthetic_anaesthetic_complications","ophtroperationnote_anaesthetic_anaesthetic_complications.id = ophtroperationnote_anaesthetic_anaesthetic_complication.anaesthetic_complication_id")
					->where("et_ophtroperationnote_anaesthetic_id = {$an['id']}")
					->order("ophtroperationnote_anaesthetic_anaesthetic_complication.id asc")
					->queryAll() as $ac) {

					$this->insert("ophtroperationnote_complication_assignment",array(
						"element_id" => $element_id,
						"complication_id" => $complications[1][$ac['name']],
						"created_user_id" => $ac['created_user_id'],
						"created_date" => $ac['created_date'],
						"last_modified_user_id" => $ac['last_modified_user_id'],
						"last_modified_date" => $ac['last_modified_date'],
					));

					$id = $this->dbConnection->createCommand()->select("max(id)")->from("ophtroperationnote_complication_assignment")->queryScalar();

					foreach ($this->dbConnection->createCommand()
						->select("ophtroperationnote_anaesthetic_anaesthetic_complications.name, ophtroperationnote_anaesthetic_anaesthetic_complication_version.*")
						->from("ophtroperationnote_anaesthetic_anaesthetic_complication_version")
						->join("ophtroperationnote_anaesthetic_anaesthetic_complications","ophtroperationnote_anaesthetic_anaesthetic_complications.id = ophtroperationnote_anaesthetic_anaesthetic_complication_version.anaesthetic_complication_id")
						->where("ophtroperationnote_anaesthetic_anaesthetic_complication_version.id = {$ac['id']}")
						->order("version_id asc")
						->queryAll() as $acv) {

						$this->insert("ophtroperationnote_complication_assignment_version",array(
							"id" => $id,
							"element_id" => $element_id,
							"complication_id" => $complications[1][$acv['name']],
							"created_user_id" => $acv['created_user_id'],
							"created_date" => $acv['created_date'],
							"last_modified_user_id" => $acv['last_modified_user_id'],
							"last_modified_date" => $acv['last_modified_date'],
							"version_date" => $acv['version_date'],
						));
					}
				}
			}

			if ($cat = $this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_cataract")->where("event_id = :event_id",array(":event_id" => $event['id']))->queryRow()) {
				foreach ($this->dbConnection->createCommand()
					->select("ophtroperationnote_cataract_complications.name, ophtroperationnote_cataract_complication.*")
					->from("ophtroperationnote_cataract_complication")
					->join("ophtroperationnote_cataract_complications","ophtroperationnote_cataract_complications.id = ophtroperationnote_cataract_complication.complication_id")
					->where("cataract_id = {$cat['id']}")
					->order("ophtroperationnote_cataract_complication.id asc")
					->queryAll() as $ac) {

					$this->insert("ophtroperationnote_complication_assignment",array(
						"element_id" => $element_id,
						"complication_id" => $complications[2][$ac['name']],
						"created_user_id" => $ac['created_user_id'],
						"created_date" => $ac['created_date'],
						"last_modified_user_id" => $ac['last_modified_user_id'],
						"last_modified_date" => $ac['last_modified_date'],
					));

					$id = $this->dbConnection->createCommand()->select("max(id)")->from("ophtroperationnote_complication_assignment")->queryScalar();

					foreach ($this->dbConnection->createCommand()
						->select("ophtroperationnote_cataract_complications.name, ophtroperationnote_cataract_complication_version.*")
						->from("ophtroperationnote_cataract_complication_version")
						->join("ophtroperationnote_cataract_complications","ophtroperationnote_cataract_complications.id = ophtroperationnote_cataract_complication_version.complication_id")
						->where("ophtroperationnote_cataract_complication_version.id = {$ac['id']}")
						->order("ophtroperationnote_cataract_complication_version.version_id asc")
						->queryAll() as $acv) {

						$this->insert("ophtroperationnote_complication_assignment_version",array(
							"id" => $id,
							"element_id" => $element_id,
							"complication_id" => $complications[2][$acv['name']],
							"created_user_id" => $acv['created_user_id'],
							"created_date" => $acv['created_date'],
							"last_modified_user_id" => $acv['last_modified_user_id'],
							"last_modified_date" => $acv['last_modified_date'],
							"version_date" => $acv['version_date'],
						));
					}
				}

				if ($cat['complication_notes']) {
					$this->update('et_ophtroperationnote_complications',array('comments' => $cat['complication_notes']),"id = $element_id");
				}
			}

			if ($tra = $this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_trabeculectomy")->where("event_id = :event_id",array(":event_id" => $event['id']))->queryRow()) {
				foreach ($this->dbConnection->createCommand()
					->select("ophtroperationnote_trabeculectomy_complication.name, ophtroperationnote_trabeculectomy_complications.*")
					->from("ophtroperationnote_trabeculectomy_complications")
					->join("ophtroperationnote_trabeculectomy_complication","ophtroperationnote_trabeculectomy_complication.id = ophtroperationnote_trabeculectomy_complications.complication_id")
					->where("element_id = {$tra['id']}")
					->order("ophtroperationnote_trabeculectomy_complications.id asc")
					->queryAll() as $ac) {
		
					$this->insert("ophtroperationnote_complication_assignment",array(
						"element_id" => $element_id,
						"complication_id" => $complications[4][$ac['name']],
						"other" => $ac['name'] == 'Other' ? $tra['complication_other'] : '',
						"created_user_id" => $ac['created_user_id'],
						"created_date" => $ac['created_date'],
						"last_modified_user_id" => $ac['last_modified_user_id'],
						"last_modified_date" => $ac['last_modified_date'],
					));

					$id = $this->dbConnection->createCommand()->select("max(id)")->from("ophtroperationnote_complication_assignment")->queryScalar();

					foreach ($this->dbConnection->createCommand()
						->select("ophtroperationnote_trabeculectomy_complication.name, ophtroperationnote_trabeculectomy_complications_version.*")
						->from("ophtroperationnote_trabeculectomy_complications_version")
						->join("ophtroperationnote_trabeculectomy_complication","ophtroperationnote_trabeculectomy_complication.id = ophtroperationnote_trabeculectomy_complications_version.complication_id")
						->where("ophtroperationnote_trabeculectomy_complications_version.id = {$ac['id']}")
						->order("ophtroperationnote_trabeculectomy_complications_version.version_id asc")
						->queryAll() as $acv) {
					
						$this->insert("ophtroperationnote_complication_assignment_version",array(
							"id" => $id,
							"element_id" => $element_id,
							"complication_id" => $complications[4][$acv['name']],
							"created_user_id" => $acv['created_user_id'],
							"created_date" => $acv['created_date'],
							"last_modified_user_id" => $acv['last_modified_user_id'],
							"last_modified_date" => $acv['last_modified_date'],
							"version_date" => $acv['version_date'],
						));
					}
				}
			}

			if ($tra = $this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_trabectome")->where("event_id = :event_id",array(":event_id" => $event['id']))->queryRow()) {
				foreach ($this->dbConnection->createCommand()
					->select("ophtroperationnote_trabectome_complication.name, ophtroperationnote_trabectome_comp_ass.*")
					->from("ophtroperationnote_trabectome_comp_ass")
					->join("ophtroperationnote_trabectome_complication","ophtroperationnote_trabectome_complication.id = ophtroperationnote_trabectome_comp_ass.complication_id")
					->where("element_id = {$tra['id']}")
					->order("ophtroperationnote_trabectome_comp_ass.id asc")
					->queryAll() as $ac) {

					$this->insert("ophtroperationnote_complication_assignment",array(
						"element_id" => $element_id,
						"complication_id" => $complications[3][$ac['name']],
						"other" => $ac['name'] == 'Other' ? $tra['complication_other'] : '',
						"created_user_id" => $ac['created_user_id'],
						"created_date" => $ac['created_date'],
						"last_modified_user_id" => $ac['last_modified_user_id'],
						"last_modified_date" => $ac['last_modified_date'],
					));

					$id = $this->dbConnection->createCommand()->select("max(id)")->from("ophtroperationnote_complication_assignment")->queryScalar();

					foreach ($this->dbConnection->createCommand()
						->select("ophtroperationnote_trabectome_complication.name, ophtroperationnote_trabectome_comp_ass_version.*")
						->from("ophtroperationnote_trabectome_comp_ass_version")
						->join("ophtroperationnote_trabectome_complication","ophtroperationnote_trabectome_complication.id = ophtroperationnote_trabectome_comp_ass_version.complication_id")
						->where("ophtroperationnote_trabectome_comp_ass_version.id = {$ac['id']}")
						->order("ophtroperationnote_trabectome_comp_ass_version.version_id asc")
						->queryAll() as $acv) {

						$this->insert("ophtroperationnote_complication_assignment_version",array(
							"id" => $id,
							"element_id" => $element_id,
							"complication_id" => $complications[3][$acv['name']],
							"created_user_id" => $acv['created_user_id'],
							"created_date" => $acv['created_date'],
							"last_modified_user_id" => $acv['last_modified_user_id'],
							"last_modified_date" => $acv['last_modified_date'],
							"version_date" => $acv['version_date'],
						));
					}
				}
			}
		}

		$this->dropTable('ophtroperationnote_anaesthetic_anaesthetic_complication_version');
		$this->dropTable('ophtroperationnote_anaesthetic_anaesthetic_complication');
		$this->dropTable('ophtroperationnote_anaesthetic_anaesthetic_complications_version');
		$this->dropTable('ophtroperationnote_anaesthetic_anaesthetic_complications');
		$this->dropTable('ophtroperationnote_cataract_complication_version');
		$this->dropTable('ophtroperationnote_cataract_complication');
		$this->dropTable('ophtroperationnote_cataract_complications_version');
		$this->dropTable('ophtroperationnote_cataract_complications');
		$this->dropTable('ophtroperationnote_trabeculectomy_complications_version');
		$this->dropTable('ophtroperationnote_trabeculectomy_complications');
		$this->dropTable('ophtroperationnote_trabeculectomy_complication_version');
		$this->dropTable('ophtroperationnote_trabeculectomy_complication');
		$this->dropTable('ophtroperationnote_trabectome_comp_ass_version');
		$this->dropTable('ophtroperationnote_trabectome_comp_ass');
		$this->dropTable('ophtroperationnote_trabectome_complication_version');
		$this->dropTable('ophtroperationnote_trabectome_complication');

		$this->dropColumn('et_ophtroperationnote_cataract','complication_notes');
		$this->dropColumn('et_ophtroperationnote_cataract_version','complication_notes');
		$this->dropColumn('et_ophtroperationnote_trabeculectomy','complication_other');
		$this->dropColumn('et_ophtroperationnote_trabeculectomy_version','complication_other');
		$this->dropColumn('et_ophtroperationnote_trabectome','complication_other');
		$this->dropColumn('et_ophtroperationnote_trabectome_version','complication_other');
	}

	public function down()
	{
		$this->addColumn('et_ophtroperationnote_trabectome_version','complication_other','text');
		$this->addColumn('et_ophtroperationnote_trabectome','complication_other','text');
		$this->addColumn('et_ophtroperationnote_trabeculectomy','complication_other','varchar(255) NULL');
		$this->addColumn('et_ophtroperationnote_trabeculectomy_version','complication_other','varchar(255) NULL');
		$this->addColumn('et_ophtroperationnote_cataract','complication_notes','varchar(4096) NULL');
		$this->addColumn('et_ophtroperationnote_cataract_version','complication_notes','varchar(4096) NULL');

		$this->execute("CREATE TABLE `ophtroperationnote_trabectome_complication` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`active` tinyint(1) NOT NULL DEFAULT '1',
	`other` tinyint(1) NOT NULL DEFAULT '0',
	`display_order` int(11) NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `ophtroperationnote_trabectome_complication_lmui_fk` (`last_modified_user_id`),
	KEY `ophtroperationnote_trabectome_complication_cui_fk` (`created_user_id`),
	CONSTRAINT `ophtroperationnote_trabectome_complication_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `ophtroperationnote_trabectome_complication_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->versionExistingTable('ophtroperationnote_trabectome_complication');

		$this->execute("CREATE TABLE `ophtroperationnote_trabectome_comp_ass` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`element_id` int(11) NOT NULL,
	`complication_id` int(11) NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `ophtroperationnote_trabectome_comp_ass_lmui_fk` (`last_modified_user_id`),
	KEY `ophtroperationnote_trabectome_comp_ass_cui_fk` (`created_user_id`),
	KEY `ophtroperationnote_trabectome_comp_ass_elui_fk` (`element_id`),
	KEY `ophtroperationnote_trabectome_comp_ass_cmpui_fk` (`complication_id`),
	CONSTRAINT `ophtroperationnote_trabectome_comp_ass_cmpui_fk` FOREIGN KEY (`complication_id`) REFERENCES `ophtroperationnote_trabectome_complication` (`id`),
	CONSTRAINT `ophtroperationnote_trabectome_comp_ass_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `ophtroperationnote_trabectome_comp_ass_elui_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophtroperationnote_trabectome` (`id`),
	CONSTRAINT `ophtroperationnote_trabectome_comp_ass_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->versionExistingTable('ophtroperationnote_trabectome_comp_ass');

		$this->execute("CREATE TABLE `ophtroperationnote_trabeculectomy_complication` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`display_order` tinyint(1) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `ophtroperationnote_trabeculectomy_complication_lmui_fk` (`last_modified_user_id`),
	KEY `ophtroperationnote_trabeculectomy_complication_cui_fk` (`created_user_id`),
	CONSTRAINT `ophtroperationnote_trabeculectomy_complication_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `ophtroperationnote_trabeculectomy_complication_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->versionExistingTable('ophtroperationnote_trabeculectomy_complication');

		$this->execute("CREATE TABLE `ophtroperationnote_trabeculectomy_complications` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`element_id` int(11) NOT NULL,
	`complication_id` int(11) NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `ophtroperationnote_trabeculectomy_complications_element_id_fk` (`element_id`),
	KEY `ophtroperationnote_trabeculectomy_complications_difficulty_id_fk` (`complication_id`),
	KEY `ophtroperationnote_trabeculectomy_complications_lmui_fk` (`last_modified_user_id`),
	KEY `ophtroperationnote_trabeculectomy_complications_cui_fk` (`created_user_id`),
	CONSTRAINT `ophtroperationnote_trabeculectomy_complications_element_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophtroperationnote_trabeculectomy` (`id`),
	CONSTRAINT `ophtroperationnote_trabeculectomy_complications_difficulty_id_fk` FOREIGN KEY (`complication_id`) REFERENCES `ophtroperationnote_trabeculectomy_complication` (`id`),
	CONSTRAINT `ophtroperationnote_trabeculectomy_complications_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `ophtroperationnote_trabeculectomy_complications_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->versionExistingTable('ophtroperationnote_trabeculectomy_complications');

		$this->execute("CREATE TABLE `ophtroperationnote_cataract_complications` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
	`display_order` tinyint(3) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`active` tinyint(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`),
	KEY `ophtroperationnote_cc_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `ophtroperationnote_cc_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `ophtroperationnote_cc_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `ophtroperationnote_cc_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->versionExistingTable('ophtroperationnote_cataract_complications');

		$this->execute("CREATE TABLE `ophtroperationnote_cataract_complication` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`cataract_id` int(10) unsigned NOT NULL,
	`complication_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `ophtroperationnote_cc2_cataract_id_fk` (`cataract_id`),
	KEY `ophtroperationnote_cc2_complication_id_fk` (`complication_id`),
	KEY `ophtroperationnote_cc2_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `ophtroperationnote_cc2_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `ophtroperationnote_cc2_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `ophtroperationnote_cc2_cataract_id_fk` FOREIGN KEY (`cataract_id`) REFERENCES `et_ophtroperationnote_cataract` (`id`),
	CONSTRAINT `ophtroperationnote_cc2_complication_id_fk` FOREIGN KEY (`complication_id`) REFERENCES `ophtroperationnote_cataract_complications` (`id`),
	CONSTRAINT `ophtroperationnote_cc2_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->versionExistingTable('ophtroperationnote_cataract_complication');

		$this->execute("CREATE TABLE `ophtroperationnote_anaesthetic_anaesthetic_complications` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
	`display_order` tinyint(3) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`active` tinyint(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`),
	KEY `ophtroperationnote_anaesthetic_ac_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `ophtroperationnote_anaesthetic_ac_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `ophtroperationnote_anaesthetic_ac_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `ophtroperationnote_anaesthetic_ac_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->versionExistingTable('ophtroperationnote_anaesthetic_anaesthetic_complications');

		$this->execute("CREATE TABLE `ophtroperationnote_anaesthetic_anaesthetic_complication` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`et_ophtroperationnote_anaesthetic_id` int(10) unsigned NOT NULL,
	`anaesthetic_complication_id` int(10) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `ophtroperationnote_pac_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `ophtroperationnote_pac_created_user_id_fk` (`created_user_id`),
	KEY `ophtroperationnote_anaesthetic_ac_anaesthetic_id_fk` (`et_ophtroperationnote_anaesthetic_id`),
	KEY `ophtroperationnote_anaesthetic_aca_complication_id_fk` (`anaesthetic_complication_id`),
	CONSTRAINT `ophtroperationnote_anaesthetic_aca_complication_id_fk` FOREIGN KEY (`anaesthetic_complication_id`) REFERENCES `ophtroperationnote_anaesthetic_anaesthetic_complications` (`id`),
	CONSTRAINT `ophtroperationnote_anaesthetic_ac_anaesthetic_id_fk` FOREIGN KEY (`et_ophtroperationnote_anaesthetic_id`) REFERENCES `et_ophtroperationnote_anaesthetic` (`id`),
	CONSTRAINT `ophtroperationnote_pac_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `ophtroperationnote_pac_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->versionExistingTable('ophtroperationnote_anaesthetic_anaesthetic_complication');

		$ana_complications = array();
		foreach (array('Eyelid haemorrage/bruising','Conjunctivital chemosis','Retro bulbar / peribulbar haemorrage','Globe/optic nerve penetration','Inadequate akinesia','Patient pain - Mild','Patient pain - Moderate','Patient pain - Severe','Systemic problems','Operation cancelled due to complication') as $i => $complication) {
			$this->insert('ophtroperationnote_anaesthetic_anaesthetic_complications',array('id'=>$i+1,'name'=>$complication,'display_order'=>(($i+1)*10),'active'=>1));

			$ana_complications[$complication] = $i+1;
		}

		$cat_complications = array();
		foreach (array('Anterior Capsular tear','Choroidal haem','Corneal odema','Decentered IOL','Dropped nucleus','Hyphaema','IOL exchange','IOL into vitreous','Iris prolapse','Iris trauma','Op cancelled','Other IOL problem','PC rupture','Vitreous loss','Wound burn','Zonular dialysis','Zonular rupture') as $i => $complication) {
			$this->insert('ophtroperationnote_cataract_complications',array('id'=>$i+1,'name'=>$complication,'display_order'=>(($i+1)*10),'active'=>1));

			$cat_complications[$complication] = $i+1;
		}

		$tra_complications = array();
		foreach (array('Conjunctival tear','Haemorrhage','Endothelial damage','Iris damage','Lens damage','Vitreous loss','Other') as $i => $complication) {
			$this->insert('ophtroperationnote_trabeculectomy_complication',array('id'=>$i+1,'name'=>$complication,'display_order'=>(($i+1)*10)));

			$tra_complications[$complication] = $i+1;
		}

		$tra2_complications = array();
		foreach (array('Haemorrhage','Endothelial damage','Iris damage','Lens damage','Other') as $i => $complication) {
			$this->insert('ophtroperationnote_trabectome_complication',array('id'=>$i+1,'name'=>$complication,'display_order'=>(($i+1)*10),'active'=>1));

			$tra2_complications[$complication] = $i+1;
		}

		$et = $this->dbConnection->createCommand()->select("id")->from("event_type")->where("class_name = :class_name",array(":class_name" => "OphTrOperationnote"))->queryRow();

		foreach ($this->dbConnection->createCommand()->select("*")->from("event")->where("event_type_id = :event_type_id",array(":event_type_id" => $et['id']))->queryAll() as $event) {
			$element = $this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_complications")->where('event_id = :event_id',array(':event_id' => $event['id']))->queryRow();

			if ($an = $this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_anaesthetic")->where("event_id = :event_id",array(":event_id" => $event['id']))->queryRow()) {
				foreach ($this->dbConnection->createCommand()
					->select("ophtroperationnote_complication.name, ophtroperationnote_complication_assignment.*")
					->from("ophtroperationnote_complication_assignment")
					->join("ophtroperationnote_complication","ophtroperationnote_complication_assignment.complication_id = ophtroperationnote_complication.id")
					->where("type_id = 1 and element_id = {$element['id']}")
					->queryAll() as $c) {

					$this->insert('ophtroperationnote_anaesthetic_anaesthetic_complication',array('et_ophtroperationnote_anaesthetic_id' => $an['id'], 'anaesthetic_complication_id' => $ana_complications[$c['name']]));

					$id = $this->dbConnection->createCommand()->select("max(id)")->from("ophtroperationnote_anaesthetic_anaesthetic_complication")->queryScalar();

					foreach ($this->dbConnection->createCommand()
						->select("ophtroperationnote_complication.name, ophtroperationnote_complication_assignment_version.*")
						->from("ophtroperationnote_complication_assignment_version")
						->join("ophtroperationnote_complication","ophtroperationnote_complication.id = ophtroperationnote_complication_assignment_version.complication_id")
						->where("ophtroperationnote_complication_assignment_version.id = {$c['id']}")
						->order("version_id asc")
						->queryAll() as $acv) {

						$this->insert("ophtroperationnote_anaesthetic_anaesthetic_complication_version",array(
							"id" => $id,
							"et_ophtroperationnote_anaesthetic_id" => $an['id'],
							"anaesthetic_complication_id" => $ana_complications[$acv['name']],
							"created_user_id" => $acv['created_user_id'],
							"created_date" => $acv['created_date'],
							"last_modified_user_id" => $acv['last_modified_user_id'],
							"last_modified_date" => $acv['last_modified_date'],
							"version_date" => $acv['version_date'],
						));
					}
				}
			}

			if ($cat = $this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_cataract")->where("event_id = :event_id",array(":event_id" => $event['id']))->queryRow()) {
				foreach ($this->dbConnection->createCommand()
					->select("ophtroperationnote_complication.name, ophtroperationnote_complication_assignment.*")
					->from("ophtroperationnote_complication_assignment")
					->join("ophtroperationnote_complication","ophtroperationnote_complication_assignment.complication_id = ophtroperationnote_complication.id")
					->where("type_id = 2 and element_id = {$element['id']}")
					->queryAll() as $c) {

					$this->insert('ophtroperationnote_cataract_complication',array('cataract_id' => $cat['id'], 'complication_id' => $cat_complications[$c['name']]));

					$id = $this->dbConnection->createCommand()->select("max(id)")->from("ophtroperationnote_cataract_complication")->queryScalar();

					foreach ($this->dbConnection->createCommand()
						->select("ophtroperationnote_complication.name, ophtroperationnote_complication_assignment_version.*")
						->from("ophtroperationnote_complication_assignment_version")
						->join("ophtroperationnote_complication","ophtroperationnote_complication.id = ophtroperationnote_complication_assignment_version.complication_id")
						->where("ophtroperationnote_complication_assignment_version.id = {$c['id']}")
						->order("version_id asc")
						->queryAll() as $acv) {

						$this->insert("ophtroperationnote_cataract_complication_version",array(
							"id" => $id,
							"cataract_id" => $cat['id'],
							"complication_id" => $cat_complications[$acv['name']],
							"created_user_id" => $acv['created_user_id'],
							"created_date" => $acv['created_date'],
							"last_modified_user_id" => $acv['last_modified_user_id'],
							"last_modified_date" => $acv['last_modified_date'],
							"version_date" => $acv['version_date'],
						));
					}
				}

				$this->update('et_ophtroperationnote_cataract',array('complication_notes' => $element['comments']),"id = {$cat['id']}");
			}

			if ($tra = $this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_trabeculectomy")->where("event_id = :event_id",array(":event_id" => $event['id']))->queryRow()) {
				foreach ($this->dbConnection->createCommand()
					->select("ophtroperationnote_complication.name, ophtroperationnote_complication_assignment.*")
					->from("ophtroperationnote_complication_assignment")
					->join("ophtroperationnote_complication","ophtroperationnote_complication_assignment.complication_id = ophtroperationnote_complication.id")
					->where("type_id = 4 and element_id = {$element['id']}")
					->queryAll() as $c) {

					$this->insert('ophtroperationnote_trabeculectomy_complications',array('element_id' => $tra['id'], 'complication_id' => $tra_complications[$c['name']]));

					if ($c['other']) {
						$this->update('et_ophtroperationnote_trabeculectomy',array('complication_other' => $c['other']),"id = {$tra['id']}");
					}

					$id = $this->dbConnection->createCommand()->select("max(id)")->from("ophtroperationnote_trabeculectomy_complications")->queryScalar();

					foreach ($this->dbConnection->createCommand()
						->select("ophtroperationnote_complication.name, ophtroperationnote_complication_assignment_version.*")
						->from("ophtroperationnote_complication_assignment_version")
						->join("ophtroperationnote_complication","ophtroperationnote_complication.id = ophtroperationnote_complication_assignment_version.complication_id")
						->where("ophtroperationnote_complication_assignment_version.id = {$c['id']}")
						->order("version_id asc")
						->queryAll() as $acv) {

						$this->insert("ophtroperationnote_trabeculectomy_complications_version",array(
							"id" => $id,
							"element_id" => $tra['id'],
							"complication_id" => $tra_complications[$acv['name']],
							"created_user_id" => $acv['created_user_id'],
							"created_date" => $acv['created_date'],
							"last_modified_user_id" => $acv['last_modified_user_id'],
							"last_modified_date" => $acv['last_modified_date'],
							"version_date" => $acv['version_date'],
						));
					}
				}
			}

			if ($tra = $this->dbConnection->createCommand()->select("*")->from("et_ophtroperationnote_trabectome")->where("event_id = :event_id",array(":event_id" => $event['id']))->queryRow()) {
				foreach ($this->dbConnection->createCommand()
					->select("ophtroperationnote_complication.name, ophtroperationnote_complication_assignment.*")
					->from("ophtroperationnote_complication_assignment")
					->join("ophtroperationnote_complication","ophtroperationnote_complication_assignment.complication_id = ophtroperationnote_complication.id")
					->where("type_id = 3 and element_id = {$element['id']}")
					->queryAll() as $c) {

					$this->insert('ophtroperationnote_trabectome_comp_ass',array('element_id' => $tra['id'], 'complication_id' => $tra2_complications[$c['name']]));

					if ($c['other']) {
						$this->update('et_ophtroperationnote_trabectome',array('complication_other' => $c['other']),"id = {$tra['id']}");
					}

					$id = $this->dbConnection->createCommand()->select("max(id)")->from("ophtroperationnote_trabectome_comp_ass")->queryScalar();
			
					foreach ($this->dbConnection->createCommand()
						->select("ophtroperationnote_complication.name, ophtroperationnote_complication_assignment_version.*")
						->from("ophtroperationnote_complication_assignment_version")
						->join("ophtroperationnote_complication","ophtroperationnote_complication.id = ophtroperationnote_complication_assignment_version.complication_id")
						->where("ophtroperationnote_complication_assignment_version.id = {$c['id']}")
						->order("version_id asc")
						->queryAll() as $acv) {
					
						$this->insert("ophtroperationnote_trabectome_comp_ass_version",array(
							"id" => $id,
							"element_id" => $tra['id'],
							"complication_id" => $tra2_complications[$acv['name']],
							"created_user_id" => $acv['created_user_id'],
							"created_date" => $acv['created_date'],
							"last_modified_user_id" => $acv['last_modified_user_id'],
							"last_modified_date" => $acv['last_modified_date'],
							"version_date" => $acv['version_date'],
						));
					}
				}
			}
		}

		$this->dropTable('ophtroperationnote_complication_assignment_version');
		$this->dropTable('ophtroperationnote_complication_assignment');
		$this->dropTable('ophtroperationnote_complication_version');
		$this->dropTable('ophtroperationnote_complication');
		$this->dropTable('ophtroperationnote_complication_type_version');
		$this->dropTable('ophtroperationnote_complication_type');
		$this->dropTable('et_ophtroperationnote_complications_version');
		$this->dropTable('et_ophtroperationnote_complications');

		$this->delete('element_type', "class_name = 'Element_OphTrOperationnote_Complications'");
	}
}
