<?php

namespace common\models\auto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\auto\AutoItem;

/**
 * ItemSearch represents the model behind the search form about `common\models\auto\AutoItem`.
 */
class ItemSearch extends AutoItem
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'id_user', 'id_model', 'id_brand', 'id_modify', 'status', 'order', 'new', 'body', 'transmission', 'year', 'distance', 'power',
				'customs', 'stage', 'crash', 'door', 'motor', 'privod', 'climate_control',
				'wheel', 'wheel_power', 'wheel_drive', 'wheel_leather',
				'termal_glass', 'auto_cabin', 'sunroof', 'heat_front_seat', 'heat_rear_seat', 'heat_mirror', 'heat_rear_glass', 'heat_wheel',
				'power_front_seat', 'power_rear_seat', 'power_mirror', 'power_wheel', 'folding_mirror',
				'memory_front_seat', 'memory_rear_seat', 'memory_mirror', 'memory_wheel', 'auto_jockey',
				'sensor_rain', 'sensor_light', 'partkronic_rear', 'parktronic_front', 'blind_spot_control', 'camera_rear', 'cruise_control', 'computer',
				'signaling', 'central_locking', 'immobiliser', 'satelite',
				'airbags_front', 'airbags_knee', 'airbags_curtain', 'airbags_side_front', 'airbags_side_rear',
				'abs', 'traction', 'rate_stability', 'brakeforce', 'emergency_braking', 'block_diff', 'pedestrian_detect',
				'cd_system', 'mp3', 'radio', 'tv', 'video', 'wheel_manage', 'usb', 'aux', 'bluetooth', 'gps', 'audio_system', 'subwoofer',
				'headlight', 'headlight_fog', 'headlight_washers', 'adaptive_light',
				'bus', 'bus_winter_in', 'owners', 'service_book', 'dealer_serviced', 'garanty'], 'integer'],
			[['vin', 'description', 'created_at', 'updated_at', 'top_date', 'vip_date', 'mk', 'md', 'color'], 'safe'],
			[['price', 'volume'], 'number'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = AutoItem::find()->with(['user', 'autoImg', 'model', 'brand']);

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			'id' => $this->id,
			'id_user' => $this->id_user,
			'id_model' => $this->id_model,
			'id_brand' => $this->id_brand,
			'id_modify' => $this->id_modify,
			'status' => $this->status,
			'order' => $this->order,
			'price' => $this->price,
			'new' => $this->new,
			'body' => $this->body,
			'transmission' => $this->transmission,
			'year' => $this->year,
			'power' => $this->power,
			'volume' => $this->volume,
			'distance' => $this->distance,
			'color' => $this->color,
			'customs' => $this->customs,
			'stage' => $this->stage,
			'crash' => $this->crash,
			'door' => $this->door,
			'motor' => $this->motor,
			'privod' => $this->privod,
			'climate_control' => $this->climate_control,
			'wheel' => $this->wheel,
			'wheel_power' => $this->wheel_power,
			'wheel_drive' => $this->wheel_drive,
			'wheel_leather' => $this->wheel_leather,
			'termal_glass' => $this->termal_glass,
			'auto_cabin' => $this->auto_cabin,
			'sunroof' => $this->sunroof,
			'heat_front_seat' => $this->heat_front_seat,
			'heat_rear_seat' => $this->heat_rear_seat,
			'heat_mirror' => $this->heat_mirror,
			'heat_rear_glass' => $this->heat_rear_glass,
			'heat_wheel' => $this->heat_wheel,
			'power_front_seat' => $this->power_front_seat,
			'power_rear_seat' => $this->power_rear_seat,
			'power_mirror' => $this->power_mirror,
			'power_wheel' => $this->power_wheel,
			'folding_mirror' => $this->folding_mirror,
			'memory_front_seat' => $this->memory_front_seat,
			'memory_rear_seat' => $this->memory_rear_seat,
			'memory_mirror' => $this->memory_mirror,
			'memory_wheel' => $this->memory_wheel,
			'auto_jockey' => $this->auto_jockey,
			'sensor_rain' => $this->sensor_rain,
			'sensor_light' => $this->sensor_light,
			'partkronic_rear' => $this->partkronic_rear,
			'parktronic_front' => $this->parktronic_front,
			'blind_spot_control' => $this->blind_spot_control,
			'camera_rear' => $this->camera_rear,
			'cruise_control' => $this->cruise_control,
			'computer' => $this->computer,
			'signaling' => $this->signaling,
			'central_locking' => $this->central_locking,
			'immobiliser' => $this->immobiliser,
			'satelite' => $this->satelite,
			'airbags_front' => $this->airbags_front,
			'airbags_knee' => $this->airbags_knee,
			'airbags_curtain' => $this->airbags_curtain,
			'airbags_side_front' => $this->airbags_side_front,
			'airbags_side_rear' => $this->airbags_side_rear,
			'abs' => $this->abs,
			'traction' => $this->traction,
			'rate_stability' => $this->rate_stability,
			'brakeforce' => $this->brakeforce,
			'emergency_braking' => $this->emergency_braking,
			'block_diff' => $this->block_diff,
			'pedestrian_detect' => $this->pedestrian_detect,
			'cd_system' => $this->cd_system,
			'mp3' => $this->mp3,
			'radio' => $this->radio,
			'tv' => $this->tv,
			'video' => $this->video,
			'wheel_manage' => $this->wheel_manage,
			'usb' => $this->usb,
			'aux' => $this->aux,
			'bluetooth' => $this->bluetooth,
			'gps' => $this->gps,
			'audio_system' => $this->audio_system,
			'subwoofer' => $this->subwoofer,
			'headlight' => $this->headlight,
			'headlight_fog' => $this->headlight_fog,
			'headlight_washers' => $this->headlight_washers,
			'adaptive_light' => $this->adaptive_light,
			'bus' => $this->bus,
			'bus_winter_in' => $this->bus_winter_in,
			'owners' => $this->owners,
			'service_book' => $this->service_book,
			'dealer_serviced' => $this->dealer_serviced,
			'garanty' => $this->garanty,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'top_date' => $this->top_date,
			'vip_date' => $this->vip_date,
		]);

		$query->andFilterWhere(['like', 'vin', $this->vin])
			->andFilterWhere(['like', 'description', $this->description])
			->andFilterWhere(['like', 'mk', $this->mk])
			->andFilterWhere(['like', 'md', $this->md]);

		return $dataProvider;
	}
}
