<?php

class m130403_105942_adjust_default_for_cataract_details extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('et_ophtroperationnote_cataract','report',"varchar(4096) COLLATE utf8_bin NOT NULL DEFAULT 'Povidone iodine\nContinuous Circular Capsulorrhexis\nHydrodissection\nPhakoemulsification of lens nucleus\nAspiration of soft lens matter\nViscoelastic removed\nHydration of wound'");
	}

	public function down()
	{
		$this->alterColumn('et_ophtroperationnote_cataract','report',"varchar(4096) COLLATE utf8_bin NOT NULL DEFAULT 'Continuous Circular Capsulorrhexis\nHydrodissection\nPhakoemulsification of lens nucleus\nAspiration of soft lens matter\nViscoelastic removed'");
	}
}
