<?php

class m130215_084137_additional_cataract_complications extends CDbMigration
{
	public function up()
	{
		$this->insert('et_ophtroperationnote_cataract_complications',array('name'=>'Conversion to ECCE','display_order'=>15));
		$this->insert('et_ophtroperationnote_cataract_complications',array('name'=>'Suprachoroidal haemorrhage','display_order'=>115));
	}

	public function down()
	{
		$this->delete('et_ophtroperationnote_cataract_complications',"name = 'Conversion to ECCE' or name = 'Suprachoroidal haemorrhage'");
	}
}
