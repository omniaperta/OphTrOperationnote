<?php

class m140822_105603_element_changes extends CDbMigration
{
	public function up()
	{
		$this->update('element_type',array('name' => 'Minor procedure WHO time-out'),"class_name = 'Element_OphTrOperationnote_TimeOut'");
		$this->update('element_type',array('name' => 'Minor procedure patient discharge'),"class_name = 'Element_OphTrOperationnote_PatientDischarge'");
	}

	public function down()
	{
		$this->update('element_type',array('name' => 'WHO time-out'),"class_name = 'Element_OphTrOperationnote_TimeOut'");
		$this->update('element_type',array('name' => 'Patient discharge'),"class_name = 'Element_OphTrOperationnote_PatientDischarge'");
	}
}
