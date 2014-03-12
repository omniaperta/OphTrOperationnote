<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

class AdminController extends ModuleAdminController
{
	public function actionViewPostOpDrugs()
	{
		$transaction = Yii::app()->db->beginTransaction('List','Post-op drugs');

		Audit::add('admin','list',null,null,array('module'=>'OphTrOperationnote','model'=>'OphTrOperationnote_PostopDrug'));

		$transaction->commit();

		$this->render('postopdrugs');
	}

	public function actionAddPostOpDrug()
	{
		$drug = new OphTrOperationnote_PostopDrug;

		if (!empty($_POST)) {
			$transaction = Yii::app()->db->beginTransaction('Create','Post-op drug');

			$drug->attributes = $_POST['OphTrOperationnote_PostopDrug'];

			if (!$drug->validate()) {
				$transaction->rollback();
				$errors = $drug->getErrors();
			} else {
				if (!$drug->save()) {
					$transaction->rollback();

					throw new Exception("Unable to save drug: ".print_r($drug->getErrors(),true));
				}
				Audit::add('admin-OphTrOperationnote_PostopDrug','add',$drug->id);

				$transaction->commit();

				$this->redirect('/OphTrOperationnote/admin/viewPostOpDrugs');
			}
		}

		$this->render('/admin/addpostopdrug',array(
			'drug' => $drug,
			'errors' => @$errors,
		));
	}

	public function actionEditPostOpDrug($id)
	{
		if (!$drug = OphTrOperationnote_PostopDrug::model()->findByPk($id)) {
			throw new Exception("Drug not found: $id");
		}

		if (!empty($_POST)) {
			$transaction = Yii::app()->db->beginTransaction('Update','Post-op drug');

			$drug->attributes = $_POST['OphTrOperationnote_PostopDrug'];

			if (!$drug->save()) {
				$transaction->rollback();

				throw new Exception("Unable to save drug: ".print_r($drug->getErrors(),true));
			} else {
				Audit::add('admin-OphTrOperationnote_PostopDrug','edit',$id);

				$transaction->commit();

				$this->redirect('/OphTrOperationnote/admin/viewPostOpDrugs');
			}
		}

		$transaction = Yii::app()->db->beginTransaction('View','Post-op drug');

		Audit::add('admin-OphTrOperationnote_PostopDrug','view',$id);

		$transaction->commit();

    $this->render('/admin/editpostopdrug',array(
      'drug' => $drug,
      'errors' => @$errors,
    ));
  }

	public function actionDeletePostOpDrugs()
	{
		$result = 1;

		if (!empty($_POST['drugs'])) {
			$transaction = Yii::app()->db->beginTransaction('Delete','Post-op drugs');

			foreach (OphTrOperationnote_PostopDrug::model()->findAllByPk(@$_POST['drugs']) as $drug) {
				if (!$drug->delete()) {
					$transaction->rollback();

					throw new Exception("Unable to delete post-op drug: ".print_r($drug->getErrors(),true));
				} else {
					Audit::add('admin','delete',$drug->id,null,array('module'=>'OphTrOperationnote','model'=>'OphTrOperationnote_PostopDrug'));
				}
			}

			$transaction->commit();
		}

		echo $result;
	}

	public function actionSortPostOpDrugs()
	{
		if (!empty($_POST['order'])) {
			$transaction = Yii::app()->db->beginTransaction('Sort','Post-op drugs');

			foreach ($_POST['order'] as $i => $id) {
				if ($drug = OphTrOperationnote_PostopDrug::model()->findByPk($id)) {
					$drug->display_order = $i+1;
					if (!$drug->save()) {
						$transaction->rollback();

						throw new Exception("Unable to save drug: ".print_r($drug->getErrors(),true));
					}
				}
			}

			$transaction->commit();
		}
	}
}
