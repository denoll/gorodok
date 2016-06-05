<?php

namespace common\models\banners;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\banners\BannerUserAccount;

/**
 * AccountSearch represents the model behind the search form about `common\models\banners\BannerUserAccount`.
 */
class AccountSearch extends BannerUserAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','id_user','id_advert','id_item'], 'integer'],
            [['pay_in', 'pay_out'], 'number'],
            [['invoice', 'date', 'description', 'service'], 'safe'],
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
    public function search($params, $in_out)
    {

        if($in_out == 'in'){
            $query = BannerUserAccount::find()->with('user')->andWhere(['IS NOT','pay_in', NULL])->orderBy('id DESC');
        }else{
            $query = BannerUserAccount::find()->with('user')->andWhere(['IS NOT','pay_out', NULL])->orderBy('id DESC');
        }

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
            'id_advert' => $this->id_advert,
            'id_item' => $this->id_item,
            'pay_in' => $this->pay_in,
            'pay_out' => $this->pay_out,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'service', $this->service]);

        return $dataProvider;
    }
}
