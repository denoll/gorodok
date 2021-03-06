<?php

namespace app\modules\schedule\controllers;

use common\models\schedule\Schedule;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\Api;

/**
 * Default controller for the `schedule` module
 */
class DefaultController extends Controller
{
	/**
	 * Renders the plain view for the module
	 * @return string
	 */
	public function actionPlane()
	{
		$schedule = new Schedule();
		$lat = Api::findOne([ 'key' => 'plane_lat' ]);
		$lon = Api::findOne([ 'key' => 'plane_lon' ]);
		$list = json_decode($schedule->setNearestStations('plane', $lat, $lon), true);
		Url::remember();
		return $this->render('plane', [
			'list' => $list,
			'copyright' => $schedule->copyright(),
		]);
	}

	/**
	 * Renders the train view for the module
	 * @return string
	 */
	public function actionTrain()
	{
		$schedule = new Schedule();
		$list = json_decode($schedule->setNearestStations('train'), true);
		Url::remember();
		return $this->render('train', [
			'list' => $list,
			'copyright' => $schedule->copyright(),
		]);
	}

	/**
	 * Renders the Suburban view for the module
	 * @return string
	 */
	public function actionSuburban()
	{
		$schedule = new Schedule();
		$list = json_decode($schedule->setNearestStations('train'), true);
		Url::remember();
		return $this->render('suburban', [
			'list' => $list,
			'copyright' => $schedule->copyright(),
		]);
	}

	/**
	 * Renders the Bus view for the module
	 * @return array
	 */
	public function actionBus()
	{
		$schedule = new Schedule();
		$list = json_decode($schedule->setNearestStations('bus'), true);
		Url::remember();
		return $this->render('bus', [
			'list' => $list,
			'copyright' => $schedule->copyright(),
		]);
	}

	/**
	 * Список станций следования
	 * @param $uid
	 * @param $date
	 * @return array
	 */
	public function actionTread($uid, $date)
	{
		$schedule = new Schedule();
		$list = json_decode($schedule->setTreadStations($uid, $date), true);
		return $this->render('tread', [
			'list' => $list,
			'copyright' => $schedule->copyright(),
		]);
	}
}
