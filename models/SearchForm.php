<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * SearchForm is the model behind the search input.
 */
class SearchForm extends Model
{
    public $query = '';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['query'], 'string'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'query' => 'Search by name',
        ];
    }

}
