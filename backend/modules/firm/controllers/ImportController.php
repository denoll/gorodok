<?php

namespace app\modules\firm\controllers;

use Yii;
use common\models\firm\Firm;
use common\models\firm\FirmSearch;
use app\modules\firm\models\Import;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * SubscribersController implements the CRUD actions for MailingSubscribers model.
 */
class ImportController extends Controller
{
    public function behaviors()
    {
        return [
	        'access' => [
		        'class' => AccessControl::className(),
		        'rules' => [
			        [
				        'actions' => ['import-firm', 'import-xls', 'delete'],
				        'allow' => true,
				        'roles' => ['admin'],
			        ],
		        ],
	        ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

	public function actionImportXls(){ // импорт файла xls
		$model = new Import();

		if (Yii::$app->request->isPost) {
			$model->file = UploadedFile::getInstance($model, 'file');

			if ($model->file) {
				$model->validate();
				$model->file->saveAs(Yii::getAlias('@bac_dir/files/') .  'input.' . $model->file->extension);
				return $this->redirect(['import-firm']);
			}else{
				Yii::$app->session->setFlash('danger', '<span style="font-size: 1.3em;">Файл не загружен.</span> <p>Вы не выбрали файл</p>');
				return $this->redirect(['import-firm']);
			}
		}

		return $this->renderAjax('import-xls', ['model' => $model]);
	}

	public function actionImportFirm(){ // импорт записей из файла xls в базу


		$excel_file = Yii::getAlias('@bac_dir/files/') . "input.xls";
		if (file_exists($excel_file)) {
			$PHPExcel_file = \PHPExcel_IOFactory::load($excel_file);
			$sheetData = $PHPExcel_file->getActiveSheet()->toArray(null, true, true, true);
		} else {
			$sheetData = false;
		}

		$dir = Yii::getAlias('@bac_dir/files/');
		$import_files = FileHelper::findFiles($dir, [
			'only' => [
				'input.xls',
			],
		]);

		$post = Yii::$app->request->post();

		if ($post['col']) {
			$col['cat'] = $post['col']['cat'];
			$col['name'] = $post['col']['name'];
			$col['address'] = $post['col']['address'];
			$col['tel'] = $post['col']['tel'];
			$col['site'] = $post['col']['site'];
			$col['description'] = $post['col']['description'];
		}
		if($sheetData && $post['col']){
			$import = new Import();
			$result = $import->import($sheetData, $col);
		}
		return $this->render('import-firm', [
			'sheetData' => $sheetData,
			'col'=>$col,
		]);
	}

	public function actionDelete()
	{
		$model = new Firm();
		if($model->deleteAll()){
			return $this->redirect('import-firm');
		}
	}

	protected function checkData($data)
	{
		$data = trim($data);
		$data = strip_tags($data);
		if(!empty($data)){
			return $data;
		}else return null;
	}
}
