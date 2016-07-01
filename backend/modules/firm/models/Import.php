<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 10.09.2015
 * Time: 0:29
 */
namespace app\modules\firm\models;

use common\models\firm\Firm;
use common\models\firm\FirmCat;
use yii\base\Model;
use yii\web\UploadedFile;

class Import extends Model
{
	/**
	 * @var UploadedFile file attribute
	 */
	public $file;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['file'],
				'file',
				'extensions' => ['xls'],
				'mimeTypes' => ['application/vnd.ms-excel'],
			],
		];
	}

	public function import($sheetData, $col)
	{
		if ($sheetData && $col) {
			foreach ($sheetData as $i => $row){
				if($i == 1) continue;
				if(!$this->importRow($row, $col)) continue;
			}
		}
	}

	/**
	 * @param array|null $row
	 * @param array|null $col
	 * @return bool
	 */
	public function importRow($row, $col){
		$firm = Firm::findOne(['name'=>$row[$col['name']], 'address'=>$row[$col['address']]]);
		if(empty($firm)){
			$firm = new Firm();
			$firm->status = 1;
		}
		if(!empty($row[$col['cat']])){
			$firm->id_cat = (int)$this->getCategoryId($row[$col['cat']]);
		}
		if(!empty($row[$col['name']])){
			$firm->name = $this->checkData($row[$col['name']]);
		}
		if(!empty($row[$col['address']])){
			$firm->address = $this->checkData($row[$col['address']]);
		}
		if(!empty($row[$col['tel']])){
			$firm->tel = $this->checkData($row[$col['tel']]);
		}
		if(!empty($row[$col['site']])){
			$firm->site = $this->checkData($row[$col['site']]);
		}
		if(!empty($row[$col['description']])){
			$firm->description = $this->checkData($row[$col['description']]);
		}
		if($firm->save()){
			return true;
		}else return false;
	}


	/**
	 * @param string $category_name
	 * @return int category id
	 */
	public function getCategoryId($category_name)
	{
		$cat = FirmCat::findOne(['name'=>$category_name]);
		if(empty($cat)){
			$cat = new FirmCat();
			$cat->status = 1;
		}
		$cat->name = $category_name;
		$cat->save();
		return $cat->id;
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


/*try{
				Yii::$app->db->createCommand()
					->batchInsert('mailing_subscribers',
						['email', 'tel', 'name', 'status', 'mimetype', 'send_email', 'send_sms'],//'created_at',
						$new_subs
					)->execute();
				Yii::$app->session->setFlash('success', '<span style="font-size: 1.3em;">Все данные успешно загружены.</span>');
				if(count($import_files)>0) {
					for ($n = 0; $n != count($import_files); $n++) {
						@unlink($import_files[$n]);
					}
				}
				return $this->redirect('index');
			}catch(\yii\db\IntegrityException $e){
				$er_1 = $e->getName();
				$er_info = $e->errorInfo[2];
				Yii::$app->session->setFlash('danger', '<span style="font-size: 1.3em;">Данные не загружены.</span> <p>Есть дублирование подписчиков:</p>'.$er_info.'<br>'.$er_1);
			}*/