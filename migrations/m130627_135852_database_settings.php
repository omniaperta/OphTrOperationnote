<?php

class m130627_135852_database_settings extends CDbMigration
{
	public function up()
	{
		$this->insert('config_key',array(
			'config_group_id' => 2,
			'module_name' => 'OphTrOperationnote',
			'name' => 'eyedraw_iol_classes',
			'label' => 'Eyedraw IOL classes',
			'config_type_id' => 6,
		));

		$config_key_id = Yii::app()->db->createCommand()->select("id")->from("config_key")->where("module_name = :module_name and name=:name",array(":module_name"=>'OphTrOperationnote',":name"=>"eyedraw_iol_classes"))->queryScalar();

		$this->insert('config',array(
			'config_key_id' => $config_key_id,
			'module_name' => 'OphTrOperationnote',
			'value' => serialize(array('PCIOL','ACIOL','ToricPCIOL')),
		));

		$config_key_id = Yii::app()->db->createCommand()->select("id")->from("config_key")->where("name=:name",array(":name"=>"admin_menu"))->queryScalar();

		$this->insert('config',array(
			'config_key_id' => $config_key_id,
			'module_name' => 'OphTrOperationnote',
			'value' => serialize(array(
				'Post-op drugs' => '/OphTrOperationnote/admin/viewPostOpDrugs',
			)),
		));
	}

	public function down()
	{
		$this->delete('config',"module_name = 'OphTrOperationnote'");
		$this->delete('config_key',"module_name = 'OphTrOperationnote'");
	}
}
