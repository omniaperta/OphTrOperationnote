<?php

class m140303_161331_transactions extends CDbMigration
{
	public $tables = array('et_ophtroperationnote_anaesthetic','et_ophtroperationnote_buckle','et_ophtroperationnote_cataract','et_ophtroperationnote_comments','et_ophtroperationnote_genericprocedure','et_ophtroperationnote_membrane_peel','et_ophtroperationnote_personnel','et_ophtroperationnote_postop_drugs','et_ophtroperationnote_preparation','et_ophtroperationnote_procedurelist','et_ophtroperationnote_surgeon','et_ophtroperationnote_tamponade','et_ophtroperationnote_vitrectomy','ophtroperationnote_anaesthetic_anaesthetic_agent','ophtroperationnote_anaesthetic_anaesthetic_complication','ophtroperationnote_anaesthetic_anaesthetic_complications','ophtroperationnote_buckle_drainage_type','ophtroperationnote_cataract_complication','ophtroperationnote_cataract_complications','ophtroperationnote_cataract_incision_site','ophtroperationnote_cataract_incision_type','ophtroperationnote_cataract_iol_position','ophtroperationnote_cataract_iol_type','ophtroperationnote_cataract_operative_device','ophtroperationnote_gas_percentage','ophtroperationnote_gas_type','ophtroperationnote_gas_volume','ophtroperationnote_gauge','ophtroperationnote_postop_drug','ophtroperationnote_postop_drugs_drug','ophtroperationnote_postop_site_subspecialty_drug','ophtroperationnote_preparation_intraocular_solution','ophtroperationnote_preparation_skin_preparation','ophtroperationnote_procedure_element','ophtroperationnote_procedurelist_procedure_assignment','ophtroperationnote_site_subspecialty_postop_instructions');

	public function up()
	{
		foreach ($this->tables as $table) {
			$this->addColumn($table,'hash','varchar(40) not null');
			$this->addColumn($table,'transaction_id','int(10) unsigned null');
			$this->createIndex($table.'_tid',$table,'transaction_id');
			$this->addForeignKey($table.'_tid',$table,'transaction_id','transaction','id');
			$this->addColumn($table,'conflicted','tinyint(1) unsigned not null');

			$this->addColumn($table.'_version','hash','varchar(40) not null');
			$this->addColumn($table.'_version','transaction_id','int(10) unsigned null');
			$this->addColumn($table.'_version','deleted_transaction_id','int(10) unsigned null');
			$this->createIndex($table.'_vtid',$table.'_version','transaction_id');
			$this->addForeignKey($table.'_vtid',$table.'_version','transaction_id','transaction','id');
			$this->createIndex($table.'_dtid',$table.'_version','deleted_transaction_id');
			$this->addForeignKey($table.'_dtid',$table.'_version','deleted_transaction_id','transaction','id');
			$this->addColumn($table.'_version','conflicted','tinyint(1) unsigned not null');
		}
	}

	public function down()
	{
		foreach ($this->tables as $table) {
			$this->dropColumn($table,'hash');
			$this->dropForeignKey($table.'_tid',$table);
			$this->dropIndex($table.'_tid',$table);
			$this->dropColumn($table,'transaction_id');
			$this->dropColumn($table,'conflicted');

			$this->dropColumn($table.'_version','hash');
			$this->dropForeignKey($table.'_vtid',$table.'_version');
			$this->dropIndex($table.'_vtid',$table.'_version');
			$this->dropColumn($table.'_version','transaction_id');
			$this->dropForeignKey($table.'_dtid',$table.'_version');
			$this->dropIndex($table.'_dtid',$table.'_version');
			$this->dropColumn($table.'_version','deleted_transaction_id');
			$this->dropColumn($table.'_version','conflicted');
		}
	}
}
