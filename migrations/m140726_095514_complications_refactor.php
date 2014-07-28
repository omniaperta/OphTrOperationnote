<?php

class m140726_095514_complications_refactor extends OEMigration
{
	public function up()
	{
		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = :class_name",array(":class_name" => "OphTrOperationnote"))->queryRow();

		$this->dropForeignKey('ophtroperationnote_complication_typ_fk','ophtroperationnote_complication');
		$this->renameColumn('ophtroperationnote_complication','type_id','element_type_id');
		$this->renameColumn('ophtroperationnote_complication_version','type_id','element_type_id');

		foreach ($this->dbConnection->createCommand()->select("*")->from("ophtroperationnote_complication_type")->queryAll() as $type) {
			$element_type = $this->dbConnection->createCommand()->select("*")->from("element_type")->where("event_type_id = {$et['id']} and name = '{$type['name']}'")->queryRow();
			$this->update('ophtroperationnote_complication',array('element_type_id' => $element_type['id']),"element_type_id = {$type['id']}");
			$this->update('ophtroperationnote_complication_version',array('element_type_id' => $element_type['id']),"element_type_id = {$type['id']}");
		}

		$this->addForeignKey('ophtroperationnote_complication_eti_fk','ophtroperationnote_complication','element_type_id','element_type','id');

		$this->dropTable('ophtroperationnote_complication_type_version');
		$this->dropTable('ophtroperationnote_complication_type');
	}

	public function down()
	{
		$this->execute("CREATE TABLE `ophtroperationnote_complication_type` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`display_order` tinyint(1) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`id`),
	KEY `ophtroperationnote_complication_type_lmui_fk` (`last_modified_user_id`),
	KEY `ophtroperationnote_complication_type_cui_fk` (`created_user_id`),
	CONSTRAINT `ophtroperationnote_complication_type_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `ophtroperationnote_complication_type_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->versionExistingTable('ophtroperationnote_complication_type');

		$this->dropForeignKey('ophtroperationnote_complication_eti_fk','ophtroperationnote_complication');
		$this->renameColumn('ophtroperationnote_complication','element_type_id','type_id');
		$this->renameColumn('ophtroperationnote_complication_version','element_type_id','type_id');

		$i=1;
		foreach ($this->dbConnection->createCommand()->select("*")->from("ophtroperationnote_complication")->order("id asc")->queryAll() as $complication) {
			$element_type = $this->dbConnection->createCommand()->select("*")->from("element_type")->where("id = :element_type_id",array(":element_type_id" => $complication['type_id']))->queryRow();

			while (!$type = $this->dbConnection->createCommand()->select("*")->from("ophtroperationnote_complication_type")->where("name = :name",array(":name" => $element_type['name']))->queryRow()) {
				$this->insert('ophtroperationnote_complication_type',array('id' => $i, 'name' => $element_type['name'],'display_order' => $i));
				$i++;
			}

			$this->update('ophtroperationnote_complication',array('type_id' => $type['id']),"id = {$complication['id']}");
		}

		$this->addForeignKey('ophtroperationnote_complication_typ_fk','ophtroperationnote_complication','type_id','ophtroperationnote_complication_type','id');
	}
}
