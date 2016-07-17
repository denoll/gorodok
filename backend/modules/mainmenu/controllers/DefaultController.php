<?php

	namespace app\modules\mainmenu\controllers;

	use common\helpers\Arrays;
	use common\models\Article;
	use common\models\ArticleCategory;
	use common\models\Menu;
	use common\models\News;
	use common\models\NewsCategory;
	use common\models\Page;
	use common\models\pr_acces\PrAcces;
	use common\models\pr_spar\PrSpar;
	use common\models\product\Product;
	use common\models\product\ProductCat;
	use common\models\training\Training;
	use Yii;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;
	use yii\helpers\ArrayHelper;
	use yii\filters\AccessControl;
	use common\models\MainMenu;
	use common\models\Extensions;
	use yii\data\ActiveDataProvider;

	class DefaultController extends Controller
	{

		public function behaviors()
		{
			return [
				'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						[
							'actions' => ['item', 'index', 'element', 'menu', 'select', 'select-ext', 'select-item'],
							'allow' => true,
							'roles' => ['admin'],
						],
					],
				],
				'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'select-items' => ['post'],
					],
				],
			];
		}

		/**
		 * Lists all News categories.
		 * @return mixed
		 */
		public function actionIndex()
		{
			$dataProvider = new ActiveDataProvider([
				'query' => MainMenu::find(),
			]);

			return $this->render('index', [
				'dataProvider' => $dataProvider,
			]);
		}

		public function actionSelectExt()
		{
			$id = \Yii::$app->request->post('id');
			$ext = Arrays::getExtension($id);
			$items['ext'] = $ext;
			if($ext['ext_name']=='site'){
				$items['items'] =  $this->selectSite();
			}
			if($ext['ext_name']=='training'){
				$items['items'] =  $this->selectTrainings($ext['type']);
			}
			if($ext['ext_name']=='faq'){
				$items['items'] =  $this->selectFaq();
			}
			if($ext['ext_name']=='forum'){
				$items['items'] =  $this->selectForum();
			}
			if($ext['ext_name']=='page'){
				$items['items'] =  $this->selectPages();
			}
			if($ext['ext_name']=='article'){
				$items['items'] =  $this->selectArticles($ext['type']);
			}
			if($ext['ext_name']=='news'){
				$items['items'] =  $this->selectNews($ext['type']);
			}
			if($ext['ext_name']=='product'){
				$items['items'] =  $this->selectProducts($ext['type']);
			}
			if($ext['ext_name']=='acces'){
				$items['items'] =  $this->selectAcces($ext['type']);
			}
			if($ext['ext_name']=='spar'){
				$items['items'] =  $this->selectSpar($ext['type']);
			}
			echo json_encode($items);
		}

		public function actionSelectItem()
		{
			$item_id = \Yii::$app->request->post('item_id');
			$ext_id = \Yii::$app->request->post('ext_id');
			$ext = Arrays::getExtension($ext_id);
			$items['ext'] = $ext;
			if($ext['ext_name']=='site'){
				$items['items'] =  $this->selectSite(false);
			}
			if($ext['ext_name']=='training'){
				$items['items'] =  $this->selectTrainings($ext['type'],$item_id);
			}
			if($ext['ext_name']=='faq'){
				$items['items'] =  $this->selectFaq(false);
			}
			if($ext['ext_name']=='forum'){
				$items['items'] =  $this->selectForum(false);
			}
			if($ext['ext_name']=='page'){
				$items['items'] =  $this->selectPages(false);
			}
			if($ext['ext_name']=='article'){
				$items['items'] =  $this->selectArticles($ext['type'],$item_id);
			}
			if($ext['ext_name']=='news'){
				$items['items'] =  $this->selectNews($ext['type'],$item_id);
			}
			if($ext['ext_name']=='product'){
				$items['items'] =  $this->selectProducts($ext['type'],$item_id);
			}
			if($ext['ext_name']=='acces'){
				$items['items'] =  $this->selectAcces($ext['type'],$item_id);
			}
			if($ext['ext_name']=='spar'){
				$items['items'] =  $this->selectSpar($ext['type'],$item_id);
			}

			echo json_encode($items);
		}

		private function selectSite($all = true)
		{
			if($all){
				return null;
			}else{
				return null;
			}
		}
		private function selectTrainings($type, $item = false)
		{
			if(!$item){
				if($type == 'main'){
					$items = null;
				}elseif($type == 'category'){
					$items = Menu::getChildrenNodesBySlug(Menu::MENU_PRODUCTS)->asArray()->all();
				}elseif($type == 'view'){
					$items = Training::find()->select('id,name,slug,status')->where(['status'=>1])->asArray()->all();
				}else return null;
				return $items;
			}else{
				if($type == 'main'){
					$items = null;
				}elseif($type == 'category'){
					$items = Menu::find()->where(['id'=>$item])->asArray()->one();
				}elseif($type == 'view'){
					$items = Training::find()->select('id,name,slug,status')->where(['status'=>1,'id'=>$item])->asArray()->one();
				}else return null;
				return $items;
			}
		}
		private function selectFaq($all = true)
		{
			if($all){
				return null;
			}else{
				return null;
			}
		}
		private function selectForum($all = true)
		{
			if($all){
				return null;
			}else{
				return null;
			}
		}
		private function selectPages($all = true)
		{
			if($all){
				return Page::find()->select('id , slug , status , title as name')->where(['status'=>1])->asArray()->all();
			}else{
				return Page::find()->select('id , slug , status , title as name')->where(['status'=>1])->asArray()->one();
			}
		}

		private function selectArticles($type, $item = false)
		{
			if(!$item){
				if($type == 'main'){
					$items = null;
				}elseif($type == 'category'){
					$items = ArticleCategory::find()->select('id,title as name,slug,status')->where(['status'=>1])->asArray()->all();
				}elseif($type == 'view'){
					$items = Article::find()->select('id,title as name,slug,status')->where(['status'=>1])->asArray()->all();
				}else return null;
				return $items;
			}else{
				if($type == 'main'){
					$items = null;
				}elseif($type == 'category'){
					$items = ArticleCategory::find()->select('id,title as name,slug,status')->where(['id'=>$item])->asArray()->one();
				}elseif($type == 'view'){
					$items = Article::find()->select('id,title as name,slug,status')->where(['status'=>1,'id'=>$item])->asArray()->one();
				}else return null;
				return $items;
			}
		}

		private function selectNews($type, $item = false)
		{
			if(!$item){
				if($type == 'main'){
					$items = null;
				}elseif($type == 'category'){
					$items = NewsCategory::find()->select('id,title as name,slug,status')->where(['status'=>1])->asArray()->all();
				}elseif($type == 'view'){
					$items = News::find()->select('id,title as name,slug,status')->where(['status'=>1])->asArray()->all();
				}else return null;
				return $items;
			}else{
				if($type == 'main'){
					$items = null;
				}elseif($type == 'category'){
					$items = NewsCategory::find()->select('id,title as name,slug,status')->where(['id'=>$item])->asArray()->one();
				}elseif($type == 'view'){
					$items = News::find()->select('id,title as name,slug,status')->where(['status'=>1,'id'=>$item])->asArray()->one();
				}else return null;
				return $items;
			}
		}

		private function selectProducts($type, $item = false)
		{
			if(!$item){
				if($type == 'main'){
					$items = null;
				}elseif($type == 'category'){
					$items = Menu::getChildrenNodesBySlug(Menu::MENU_PRODUCTS)->asArray()->all();
				}elseif($type == 'view'){
					$items = Product::find()->select(['id','name','slug','status'])->where(['status'=>1])->asArray()->all();
				}else return null;
				return $items;
			}else{
				if($type == 'main'){
					$items = null;
				}elseif($type == 'category'){
					$items = Menu::find()->where(['id'=>$item])->asArray()->one();
				}elseif($type == 'view'){
					$items = Product::find()->select(['id','name','slug','status'])->where(['status'=>1,'id'=>$item])->asArray()->one();
				}else return null;
				return $items;
			}
		}

		private function selectAcces($type, $item = false)
		{
			if(!$item){
				if($type == 'main'){
					$items = null;
				}elseif($type == 'category'){
					$items = Menu::getChildrenNodesBySlug(Menu::MENU_ACCESSORIES)->asArray()->all();
				}elseif($type == 'view'){
					$items = PrAcces::find()->select(['id','name','slug','status'])->where(['status'=>1])->asArray()->all();
				}else return null;
				return $items;
			}else{
				if($type == 'main'){
					$items = null;
				}elseif($type == 'category'){
					$items = Menu::find()->where(['id'=>$item])->asArray()->one();
				}elseif($type == 'view'){
					$items = PrAcces::find()->select(['id','name','slug','status'])->where(['status'=>1,'id'=>$item])->asArray()->one();
				}else return null;
				return $items;
			}
		}

		private function selectSpar($type, $item = false)
		{
			if(!$item){
				if($type == 'main'){
					$items = null;
				}elseif($type == 'category'){
					$items = Menu::getChildrenNodesBySlug(Menu::MENU_SPARES)->asArray()->all();
				}elseif($type == 'view'){
					$items = PrSpar::find()->select(['id','name','slug','status'])->where(['status'=>1])->asArray()->all();
				}else return null;
				return $items;
			}else{
				if($type == 'main'){
					$items = null;
				}elseif($type == 'category'){
					$items = Menu::find()->where(['id'=>$item])->asArray()->one();
				}elseif($type == 'view'){
					$items = PrSpar::find()->select(['id','name','slug','status'])->where(['status'=>1,'id'=>$item])->asArray()->one();
				}else return null;
				return $items;
			}
		}



		public function actionMenu(){
			return $this->render(
				'menu',[
					'menu'=> MainMenu::getMenuTree(),
				]
			);
		}
	}