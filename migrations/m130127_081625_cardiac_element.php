<?php

class m130127_081625_cardiac_element extends CDbMigration
{
	public function up()
	{
		$event_type = $this->dbConnection->createCommand()->select('id')->from('event_type')->where('name=:name', array(':name'=>'Operation note'))->queryRow();

		$this->insert('element_type', array('name' => 'Coronary catheterisation', 'class_name' => 'ElementCoronarycatheterisation', 'event_type_id' => $event_type['id'], 'display_order' => 20, 'default' => 0));

		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id = :event_type_id and class_name=:class_name',array(':event_type_id' => $event_type['id'], ':class_name'=>'ElementCoronarycatheterisation'))->queryRow();

		$this->createTable('ophtroperationnote_coronary_access', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin NOT NULL',
				'display_order' => 'tinyint(1) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_calast_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_cacreated_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_cacreated_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_calast_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'		
		);

		$this->insert('ophtroperationnote_coronary_access',array('name'=>'Radial','display_order'=>1));
		$this->insert('ophtroperationnote_coronary_access',array('name'=>'Femoral','display_order'=>2));

		$this->createTable('ophtroperationnote_coronary_side', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin NOT NULL',
				'display_order' => 'tinyint(1) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_cs_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_cs_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_cs_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_cs_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->insert('ophtroperationnote_coronary_side',array('name'=>'Left','display_order'=>1));
		$this->insert('ophtroperationnote_coronary_side',array('name'=>'Right','display_order'=>2));

		$this->createTable('ophtroperationnote_coronary_vein_artery', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin NOT NULL',
				'display_order' => 'tinyint(1) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_va_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_va_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_va_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_va_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->insert('ophtroperationnote_coronary_vein_artery',array('name'=>'Vein','display_order'=>1));
		$this->insert('ophtroperationnote_coronary_vein_artery',array('name'=>'Artery','display_order'=>2));

		$this->createTable('ophtroperationnote_coronary_type', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin NOT NULL',
				'display_order' => 'tinyint(1) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_ctype_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_ctype_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_ctype_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_ctype_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->insert('ophtroperationnote_coronary_type',array('name'=>'Balloon pump','display_order'=>1));
		$this->insert('ophtroperationnote_coronary_type',array('name'=>'Temporary wire','display_order'=>2));
		$this->insert('ophtroperationnote_coronary_type',array('name'=>'Catheterisation','display_order'=>3));

		$this->createTable('ophtroperationnote_catheter', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin NOT NULL',
				'display_order' => 'tinyint(1) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_cath_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_cath_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_cath_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_cath_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->insert('ophtroperationnote_catheter',array('name'=>'JL 4','display_order'=>1));
		$this->insert('ophtroperationnote_catheter',array('name'=>'JR 4','display_order'=>2));
		$this->insert('ophtroperationnote_catheter',array('name'=>'JL 5','display_order'=>3));
		$this->insert('ophtroperationnote_catheter',array('name'=>'JR 5','display_order'=>4));
		$this->insert('ophtroperationnote_catheter',array('name'=>'JL 6','display_order'=>5));
		$this->insert('ophtroperationnote_catheter',array('name'=>'JR 6','display_order'=>6));
		$this->insert('ophtroperationnote_catheter',array('name'=>'Pigtail','display_order'=>7));

		$this->createTable('ophtroperationnote_coronary_stenosis_type', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin NOT NULL',
				'display_order' => 'tinyint(1) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtroperationnote_stent_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophtroperationnote_stent_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophtroperationnote_stent_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtroperationnote_stent_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->insert('ophtroperationnote_coronary_stenosis_type',array('name'=>'None','display_order'=>1));
		$this->insert('ophtroperationnote_coronary_stenosis_type',array('name'=>'Calcified','display_order'=>2));
		$this->insert('ophtroperationnote_coronary_stenosis_type',array('name'=>'Non-calcified','display_order'=>3));

		$this->createTable('et_ophtroperationnote_coronary_catheterisation', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'local_anaesthetic_time' => 'time NOT NULL',
				'access_id' => 'int(10) unsigned NOT NULL',
				'side_id' => 'int(10) unsigned NOT NULL',
				'vein_artery_id' => 'int(10) unsigned NOT NULL',
				'type_id' => 'int(10) unsigned NOT NULL',
				'edv' => 'int(10) unsigned NOT NULL',
				'pullback_gradiant' => 'int(10) unsigned NOT NULL',
				'dccv' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
				'dccv_notes' => 'varchar(1024) COLLATE utf8_bin NOT NULL',
				'completion_time' => 'time NOT NULL',
				'contrast_given' => 'int(10) unsigned NOT NULL',
				'xray_amount' => 'int(10) unsigned NOT NULL',
				'angeo_seal' => 'tinyint(1) unsigned NOT NULL',
				'tr_band' => 'tinyint(1) unsigned NOT NULL',
				'catheter_id' => 'int(10) unsigned NOT NULL',
				'eyedraw' => 'text COLLATE utf8_bin NOT NULL',
				'stenosis_type' => 'varchar(64) COLLATE utf8_bin NOT NULL',
				'stenosis_percent' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
				'eyedraw_report' => 'text COLLATE utf8_bin NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtroperationnote_cc9_event_id_fk` (`event_id`)',
				'KEY `et_ophtroperationnote_cc9_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophtroperationnote_cc9_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophtroperationnote_cc9_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_cc9_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtroperationnote_cc9_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		if (!$proc = Procedure::model()->find('snomed_code=? and term=?',array('41976001','Cardiac catheterisation'))) {
			$proc = new Procedure;
			$proc->term = 'Cardiac catheterisation';
			$proc->short_format = 'Catheter';
			$proc->default_duration = '40';
			$proc->snomed_code = '41976001';
			$proc->snomed_term = 'Cardiac catheterisation';
			$proc->save();
		}

		$a = new ProcedureListOperationElement;
		$a->procedure_id = $proc->id;
		$a->element_type_id = $element_type['id'];
		$a->save();
	}

	public function down()
	{
		$event_type = $this->dbConnection->createCommand()->select('id')->from('event_type')->where('name=:name', array(':name'=>'Operation note'))->queryRow();
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id = :event_type_id and class_name=:class_name',array(':event_type_id' => $event_type['id'], ':class_name'=>'ElementCoronarycatheterisation'))->queryRow();

		$this->delete('et_ophtroperationnote_procedure_element','element_type_id = '.$element_type['id']);

		$this->delete('element_type','id='.$element_type['id']);

		$this->dropTable('et_ophtroperationnote_coronary_catheterisation');
		$this->dropTable('ophtroperationnote_catheter');
		$this->dropTable('ophtroperationnote_coronary_type');
		$this->dropTable('ophtroperationnote_coronary_side');
		$this->dropTable('ophtroperationnote_coronary_vein_artery');
		$this->dropTable('ophtroperationnote_coronary_access');
		$this->dropTable('ophtroperationnote_coronary_stenosis_type');
	}
}
