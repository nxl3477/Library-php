<?php

namespace app\models;

use yii\db\ActiveRecord;

class Library extends ActiveRecord
{

    public function rules()
    {
        return [
            [['id', 'price'], 'integer'],
            [['name', 'auther'], 'safe'],
        ];
    }

}