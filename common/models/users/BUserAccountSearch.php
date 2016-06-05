<?php

namespace common\models\users;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\users\UserAccount;

/**
 * BUserAccountSearch represents the model behind the search form about `common\models\users\UserAccount`.
 */
class BUserAccountSearch extends UserAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'yandexPaymentId', 'invoiceId'], 'integer'],
            [['pay_in', 'pay_out', 'pay_in_with_percent'], 'number'],
            [['invoice', 'date', 'description', 'service', 'paymentType'], 'safe'],
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
    public function search($params, $in_out = null)
    {
        if($in_out == 'in'){
            $query = UserAccount::find()->andWhere('pay_in > 0')->andWhere(['IS NOT','pay_in', NULL])->orderBy('id DESC');
        }else{
            $query = UserAccount::find()->andWhere('pay_out > 0')->andWhere(['IS NOT','pay_out', NULL])->orderBy('id DESC');
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
            'pay_in' => $this->pay_in,
            'pay_out' => $this->pay_out,
            'pay_in_with_percent' => $this->pay_in_with_percent,
            'date' => $this->date,
            'yandexPaymentId' => $this->yandexPaymentId,
            'invoiceId' => $this->invoiceId,
        ]);

        $query->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'service', $this->service])
            //->andFilterWhere(['like', 'idUser.username', $this->service])
            ->andFilterWhere(['like', 'paymentType', $this->paymentType]);

        return $dataProvider;
    }
}
