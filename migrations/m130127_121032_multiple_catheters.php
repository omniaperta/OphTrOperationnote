<?php

class m130127_121032_multiple_catheters extends CDbMigration
{
	public function up()
	{
		$this->createTable('ophtroperationnote_coronary_catheter', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned NOT NULL',
				'side_id' => 'int(10) unsigned NOT NULL',
				'access_id' => 'int(10) unsigned NOT NULL',
				'vein_artery_id' => 'int(10) unsigned NOT NULL',
				'type_id' => 'int(10) unsigned NOT NULL',
				'catheter_id' => 'int(10) unsigned NOT NULL',
				'success' => 'tinyint(1) unsigned NOT NULL',
				'display_order' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_corcar_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_corcar_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_corcar_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_corcar_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->dropColumn('et_ophtroperationnote_coronary_catheterisation','side_id');
		$this->dropColumn('et_ophtroperationnote_coronary_catheterisation','access_id');
		$this->dropColumn('et_ophtroperationnote_coronary_catheterisation','vein_artery_id');
		$this->dropColumn('et_ophtroperationnote_coronary_catheterisation','type_id');
		$this->dropColumn('et_ophtroperationnote_coronary_catheterisation','catheter_id');
	}

	public function down()
	{
		$this->dropTable('ophtroperationnote_coronary_catheter');

		$this->addColumn('et_ophtroperationnote_coronary_catheterisation','side_id','int(10) unsigned NOT NULL');
		$this->addColumn('et_ophtroperationnote_coronary_catheterisation','access_id','int(10) unsigned NOT NULL');
		$this->addColumn('et_ophtroperationnote_coronary_catheterisation','vein_artery_id','int(10) unsigned NOT NULL');
		$this->addColumn('et_ophtroperationnote_coronary_catheterisation','type_id','int(10) unsigned NOT NULL');
		$this->addColumn('et_ophtroperationnote_coronary_catheterisation','catheter_id','int(10) unsigned NOT NULL');
	}
}
