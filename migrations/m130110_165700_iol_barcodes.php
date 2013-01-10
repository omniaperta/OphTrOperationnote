<?php

class m130110_165700_iol_barcodes extends OEMigration {
	
	public function up() {
		$this->createTable('ophtroperationnote_cataract_iol', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'barcode' => 'varchar(255) NOT NULL',
				'type_id' => 'int(10) unsigned NOT NULL',
				'power' => 'varchar(5) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_cataract_iol_barcode_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_cataract_iol_barcode_cui_fk` (`created_user_id`)',
				'KEY `ophtroperationnote_cataract_iol_barcode_it_fk` (`type_id`)',
				'CONSTRAINT `ophtroperationnote_cataract_iol_barcode_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_cataract_iol_barcode_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_cataract_iol_barcode_it_fk` FOREIGN KEY (`type_id`) REFERENCES `et_ophtroperationnote_cataract_iol_type` (`id`)'
		),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down() {
		$this->dropTable('ophtroperationnote_cataract_iol');
	}
	
}
