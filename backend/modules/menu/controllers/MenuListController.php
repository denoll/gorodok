<?php

namespace app\modules\menu\controllers;

use Yii;
use common\models\Menu;
use common\models\MenuList;
use app\modules\menu\models\MenuListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\menu\helpers\MenuFunc;

/**
 * MenuListController implements the CRUD actions for MenuList model.
 */
class MenuListController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all MenuList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function mapTree($data) {
		$tree = array();
		if(empty($data)) return null;
		foreach ($data as $id=>&$node) {
			if (!$node['parent']) {
				$tree[$id] = &$node;
			}
			else {
				$data[$node['parent']]['children'][$id] = &$node;
			}
		}
		return $tree;
	}
    /**
     * Displays a single MenuList model.
     * @param string $id
     * @return mixed
     */
    public function actionItems($id)
    {
	    $model_list = MenuList::findOne($id);
		$model = Menu::find()->asArray()->where(['id_menu'=>$id])->all();
	    foreach($model as $item){
		    $data[$item['id']] = $item;
	    }
		$menu = $this->mapTree($data);
	    $post = Yii::$app->request->post('items');
	    if($post){
			$post = json_decode($post,true);
			$_items = new MenuFunc();
		    $new_order = $_items->menu_to_db($post);

		    return $this->render('items', [
			    'model_list'=>$model_list,
			    'model' => $model,
			    'menu' => $menu,
			    'post' => $post,
			    'new_order' => $new_order,
		    ]);
	    }else{
		    return $this->render('items', [
			    'model_list'=>$model_list,
			    'model' => $model,
			    'menu' => $menu,
		    ]);
	    }


    }

	public function actionItemCreate($id){
		$menuList = MenuList::findOne($id);
		$model = new Menu();
		$post = $model->load(Yii::$app->request->post());
		if ($post && $model->save()) {
			return $this->redirect(['items','id'=>$model->id_menu]);
		} else {
			return $this->renderAjax('item-create', [
				'model' => $model,
				'menuList' => $menuList,
			]);
		}
	}

	public function actionItemEdit($id){
		$model = Menu::findOne(['id'=>$id]);
		$post = $model->load(Yii::$app->request->post());
		if ($post && $model->save()) {
			return $this->redirect(['items','id'=>$model->id_menu]);
		} else {
			return $this->renderAjax('item-edit', [
				'model' => $model,
			]);
		}
	}

	public function actionOrderChange(){

	}

    /**
     * Creates a new MenuList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MenuList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MenuList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MenuList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MenuList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MenuList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
