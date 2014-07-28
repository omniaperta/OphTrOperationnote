<?php

class m140726_103159_trabectome_element_shouldnt_be_default extends CDbMigration
{
	public function up()
	{
		$this->update('element_type',array('default'=>0),"class_name = 'Element_OphTrOperationnote_Trabectome'");
	}

	public function down()
	{
		$this->update('element_type',array('default'=>1),"class_name = 'Element_OphTrOperationnote_Trabectome'");
	}
}
