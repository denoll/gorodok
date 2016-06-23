<?php

namespace app\modules\profile\controllers;

use common\models\users\Company;
use Yii;
use common\models\users\User;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\filters\AccessControl;
use common\widgets\Arrays;
/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index','company', 'change-login', 'change-avatar', 'change-email', 'change-fio', 'change-tel', 'change-password'],
				'rules' => [
					[
						'actions' => ['index','company', 'change-login', 'change-avatar', 'change-email', 'change-fio', 'change-tel', 'change-password'],
						'allow' => true,
						'roles' => ['@'],
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

	/**
	 * Displays a single User model.
	 * @return mixed
	 */
	public function actionIndex()
	{
		return $this->render('index', [
			'model' => $user = self::findUser(),
		]);
	}

	public function actionCompany()
	{
		$user = Yii::$app->user->getIdentity();
		if (User::isCompany()) {
			$model = Company::findOne($user->id);
			$post = \Yii::$app->request->post();
			if ($model->load($post) && $model->save()) {
				\Yii::$app->session->setFlash('success', 'Данные успешно сохранены.');
			}
			return $this->render('company', [
				'model' => $model,
			]);
		} else {
			Yii::$app->session->setFlash('danger', '<strong>Вы зарегистрированы как частное лицо, и не можете заходить на эту страницу.</strong>');
			return $this->redirect(Url::home());
		}
	}

	public function actionChangeLogin()
	{
		$user = self::findUser();
		$pst = \Yii::$app->request->post();
		$post = $pst['User'];
		if ($user->load($pst)) {

			if ($user->validate()) {
				$user->username = strip_tags($post['username']);
				$user->save();
				Yii::$app->session->setFlash('success', 'Ваши данные успешно изменены.');
			} else {
				// данные не корректны: $errors - массив содержащий сообщения об ошибках
				Yii::$app->session->setFlash('danger', 'Данные не изменены. <pre>' . $this->errors($user->errors) . '</pre>');
			}
			return $this->redirect('index');
		} else {
			return $this->renderAjax('change-login', [
				'user' => $user,
			]);
		}
	}

	public function actionChangeAvatar()
	{
		$model = self::findUser();
		$post = \Yii::$app->request->post();
		if ($model->load($post)) {
			try{
				$_image = \yii\web\UploadedFile::getInstance($model, 'image');
				if ($model->validate()) {

					// open image
					$image = Image::getImagine()->open($_image->tempName);

					// rendering information about crop of ONE option
					$cropInfo = Json::decode($post['User']['crop_info'])[0];
					if((int)$cropInfo['dw'] == 0 || (int)$cropInfo['dh'] == 0){
						$cropInfo['dw'] = Arrays::IMG_SIZE_WIDTH; //new width image
						$cropInfo['dh'] = Arrays::IMG_SIZE_HEIGHT; //new height image
					}else{
						$cropInfo['dw'] = (int)$cropInfo['dw']; //new width image
						$cropInfo['dh'] = (int)$cropInfo['dh']; //new height image
					}
					$cropInfo['x'] = abs($cropInfo['x']); //begin position of frame crop by X
					$cropInfo['y'] = abs($cropInfo['y']); //begin position of frame crop by Y

					//delete old images
					$oldImages = FileHelper::findFiles(Yii::getAlias('@frt_dir/img/avatars/'), [
						'only' => [
							$model->id . '.*',
							'thumb_' . $model->id . '.*',
						],
					]);
					for ($i = 0; $i != count($oldImages); $i++) {
						@unlink($oldImages[$i]);
					}
					//avatar image name
					$imgName = $model->id . '.' . $_image->getExtension();

					//saving thumbnail
					$newSizeThumb = new Box($cropInfo['dw'], $cropInfo['dh']);
					$cropSizeThumb = new Box(Arrays::IMG_SIZE_WIDTH, Arrays::IMG_SIZE_HEIGHT); //frame size of crop
					$cropPointThumb = new Point($cropInfo['x'], $cropInfo['y']);
					$pathThumbImage = Yii::getAlias('@frt_dir/img/avatars/') . $imgName;

					$image->resize($newSizeThumb)
						->crop($cropPointThumb, $cropSizeThumb)
						->save($pathThumbImage, ['quality' => 100]);

					//save in database
					$model = User::findOne($model->id);
					$model->avatar = $imgName;
				}
				if ($model->save()) {
					Yii::$app->session->setFlash('success', 'Новый аватар успешно установлен.');
				} else {
					Yii::$app->session->setFlash('danger', 'Аватар не изменен.');
				}
			}catch ( Exception $ex){
				Yii::$app->session->setFlash('danger', 'Аватар не установлен (Вы не нажали кнопку "Вырезать").');
			}

			return $this->redirect('index');
		} else {
			return $this->render('change-avatar', [
				'model' => $model,
			]);
		}
	}

	public function actionChangeEmail()
	{
		$user = self::findUser();
		$pst = \Yii::$app->request->post();
		$post = $pst['User'];
		if ($user->load($pst)) {
			if ($user->validate()) {
				$user->email = $post['email'];
				$user->save();
				Yii::$app->session->setFlash('success', 'Новый email успешно установлен.');
			} else {
				// данные не корректны: $errors - массив содержащий сообщения об ошибках
				Yii::$app->session->setFlash('danger', 'Данные не изменены. <pre>' . $this->errors($user->errors) . '</pre>');
			}
			return $this->redirect('index');
		} else {
			return $this->renderAjax('change-email', [
				'user' => $user,
			]);
		}
	}

	public function actionChangeFio()
	{
		$user = self::findUser();
		$pst = \Yii::$app->request->post();
		$post = $pst['User'];
		if ($user->load($pst)) {
			if ($user->validate()) {
				$user->name = strip_tags($post['username']);
				$user->save();
				Yii::$app->session->setFlash('success', 'Фамилия Имя Отчество успешно установлены.');
			} else {
				// данные не корректны: $user->errors - массив содержащий сообщения об ошибках
				Yii::$app->session->setFlash('danger', 'Данные не изменены. <pre>' . $this->errors($user->errors) . '</pre>');
			}
			return $this->redirect('index');
		} else {
			return $this->renderAjax('change-fio', [
				'user' => $user,
			]);
		}
	}

	public function actionChangeTel()
	{
		$user = self::findUser();
		$pst = \Yii::$app->request->post();
		$post = $pst['User'];
		if ($user->load($pst)) {
			if ($user->validate()) {
				$user->tel = $post['tel'];
				$user->save();
				Yii::$app->session->setFlash('success', 'Новый телефон успешно установлен.');
			} else {
				// данные не корректны: $errors - массив содержащий сообщения об ошибках
				Yii::$app->session->setFlash('danger', 'Данные не изменены. <pre>' . $this->errors($user->errors) . '</pre>');
			}
			return $this->redirect('index');
		} else {
			return $this->renderAjax('change-tel', [
				'user' => $user,
			]);
		}
	}

	public function actionChangePassword()
	{
		$user = self::findUser();
		$pst = \Yii::$app->request->post();
		$post = $pst['User'];
		if ($user->load($pst)) {
			if ($user->validate()) {
				if(trim($post['old_password']) != '') {
					if (!$user->validatePassword($post['old_password'])) {
						Yii::$app->session->setFlash('danger', 'Вы ввели неверный старый пароль.');
					} else {
						if (trim($post['password']) != '') {
							if ($user->setNewPassword($post['password']) && $user->save()) {
								Yii::$app->session->setFlash('success', 'Новый пароль успешно установлен.');
							} else {
								Yii::$app->session->setFlash('danger', 'Новый пароль не установлен.');
							}
						} else {
							Yii::$app->session->setFlash('danger', 'Вы не указали новый пароль.');
						}
					}
				}else {
					Yii::$app->session->setFlash('danger', 'Вы не указали старый пароль.');
				}
			} else {
				// данные не корректны: $errors - массив содержащий сообщения об ошибках
				Yii::$app->session->setFlash('danger', 'Данные не изменены. <pre>' . $this->errors($user->errors) . '</pre>');
			}
			return $this->redirect('index');
		} else {
			return $this->renderAjax('change-password', [
				'user' => $user,
			]);
		}
	}

	private function errors($_errors){
		$err = '<ul>';
		foreach($_errors as $error){
			$err .= '<li>';
			$err .= '<ul>';
			foreach($error as $e){
				$err .= '<li>';
				$err .= $e;
				$err .= '</li>';
			}
			$err .= '</ul>';
			$err .= '</li>';
		}
		$err .= '</ul>';
		return $err;
	}

	private static function findUser()
	{
		return \common\models\users\User::findOne(Yii::$app->user->identity->getId());
	}
}
