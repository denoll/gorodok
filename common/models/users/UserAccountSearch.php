<?php

namespace common\models\users;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\users\UserAccount;

/**
 * UserAccountSearch represents the model behind the search form about `common\models\users\UserAccount`.
 */
class UserAccountSearch extends UserAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user'], 'integer'],
            [['pay_in', 'pay_out', 'pay_in_with_percent', 'yandexPaymentId', 'invoiceId'], 'number'],
            [['invoice'], 'string', 'max' => 32],
            [['paymentType'], 'string', 'max' => 4],
            [['date', 'description', 'service'], 'safe'],
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
            $query = UserAccount::find()->with('idUser')->andWhere(['id_user'=>\Yii::$app->user->id])->andWhere('(pay_in > 0) AND (pay_in IS NOT NULL)')->orderBy('id DESC');
        }else{
            $query = UserAccount::find()->with('idUser')->andWhere(['id_user'=>\Yii::$app->user->id])->andWhere('(pay_out > 0) AND (pay_out IS NOT NULL)')->orderBy('id DESC');
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
            'paymentType' => $this->paymentType,
            'date' => $this->date,
        ]);

        $query
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'invoiceId', $this->invoiceId])
            ->andFilterWhere(['like', 'yandexPaymentId', $this->yandexPaymentId])
            ->andFilterWhere(['like', 'service', $this->service]);

        return $dataProvider;
    }
}
