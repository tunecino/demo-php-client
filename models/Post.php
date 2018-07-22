<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Post is a dump model to represent data entities as received from Beachinsoft API.
 */
class Post extends Model
{
    public $id;
    public $title;
    public $description;
    public $image_link;
    public $image_url;
    public $external_link;
    public $repin_count;
    public $comment_count;
    public $author_name;
    public $author_image_url;
    public $author_link;
    public $media_type;
    public $created_at;

 
     /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            /**
             * Just set everything as 'safe' for now to avoid bad assumptions about the API’s expected data structure.
             * TODO: Implement proper rules.
             */
            [['id', 'title', 'description', 'image_link', 'image_url', 'external_link', 'repin_count', 'comment_count', 'author_name', 'author_image_url', 'author_link', 'media_type', 'created_at'], 'safe'],
        ];
    }

    public function getRepin()
    {
        return $this->repin_count < 1000 ? $this->repin_count : round($this->repin_count/1000) . 'K' ;
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->created_at, 'long');
    }


}
