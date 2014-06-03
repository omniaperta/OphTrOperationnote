<?php

class m140205_235959_table_versioning extends OEMigration
{
	public function up()
	{
		$this->addColumn('ophtroperationnote_anaesthetic_anaesthetic_complications', 'active', 'boolean not null default true');
		$this->addColumn('ophtroperationnote_buckle_drainage_type', 'active', 'boolean not null default true');
		$this->addColumn('ophtroperationnote_cataract_complications', 'active', 'boolean not null default true');
		$this->addColumn('ophtroperationnote_cataract_incision_site', 'active', 'boolean not null default true');
		$this->addColumn('ophtroperationnote_cataract_incision_type', 'active', 'boolean not null default true');
		$this->addColumn('ophtroperationnote_cataract_iol_position', 'active', 'boolean not null default true');
		$this->addColumn('ophtroperationnote_cataract_iol_type', 'active', 'boolean not null default true');
		$this->addColumn('ophtroperationnote_gas_type', 'active', 'boolean not null default true');
		$this->addColumn('ophtroperationnote_gas_volume', 'active', 'boolean not null default true');
		$this->addColumn('ophtroperationnote_gauge', 'active', 'boolean not null default true');
		$this->addColumn('ophtroperationnote_preparation_intraocular_solution', 'active', 'boolean not null default true');
		$this->addColumn('ophtroperationnote_preparation_skin_preparation', 'active', 'boolean not null default true');

		$this->addColumn('ophtroperationnote_postop_drug', 'active', 'boolean not null default true');
		$this->update('ophtroperationnote_postop_drug', array('active' => new CDbExpression('not(deleted)')));
		$this->dropColumn('ophtroperationnote_postop_drug', 'deleted');
	}

	public function down()
	{
		$this->addColumn('ophtroperationnote_postop_drug', 'deleted', "tinyint(1) unsigned NOT NULL DEFAULT '0'");
		$this->update('ophtroperationnote_postop_drug', array('deleted' => new CDbExpression('not(active)')));
		$this->dropColumn('ophtroperationnote_postop_drug', 'active');

		$this->dropColumn('ophtroperationnote_anaesthetic_anaesthetic_complications','active');
		$this->dropColumn('ophtroperationnote_buckle_drainage_type','active');
		$this->dropColumn('ophtroperationnote_cataract_complications','active');
		$this->dropColumn('ophtroperationnote_cataract_incision_site','active');
		$this->dropColumn('ophtroperationnote_cataract_incision_type','active');
		$this->dropColumn('ophtroperationnote_cataract_iol_position','active');
		$this->dropColumn('ophtroperationnote_cataract_iol_type','active');
		$this->dropColumn('ophtroperationnote_gas_type','active');
		$this->dropColumn('ophtroperationnote_gas_volume','active');
		$this->dropColumn('ophtroperationnote_gauge','active');
		$this->dropColumn('ophtroperationnote_preparation_intraocular_solution','active');
		$this->dropColumn('ophtroperationnote_preparation_skin_preparation','active');
	}
}
