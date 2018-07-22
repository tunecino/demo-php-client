<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\httpclient\Client;
use yii\data\ArrayDataProvider;
use app\models\Post;

class BeachinsoftApi extends Component
{
    public $baseUrl = 'http://api3.beachinsoft.com';
    public $collectionUri = '?r=api/search';
    public $key = '';
    public $engine = 1;
    public $limit = 10;

    private $_httpClient;

    public function getHttpClient()
    {
        if (!is_object($this->_httpClient)) {
            $this->_httpClient = Yii::createObject([
                'class' => Client::class,
                'baseUrl' => $this->baseUrl,
            ]);
        }
        return $this->_httpClient;
    }

    public function getData(string $keywords = '', int $offset = 0)
    {
        $params = [
            'engine' => $this->engine,
            'api_key' => $this->key,
            'limit' => $this->limit,
            'offset' => $offset,
        ];
        
        if ($keywords) {
            $params['keywords'] = $keywords;
        }

        $response = $this->getHttpClient()->get($this->collectionUri, $params)->send();
        $data = isset($response->data['result']['results']) ? $response->data['result']['results'] : null;

        if ($response->isOk !== true || $data === null) {
            /**
             * 503 SERVICE UNAVAILABLE looks appropriate for this case: https://httpstatuses.com/503
             * TODO: Create and replace later by a Yii2 503 SERVICE UNAVAILABLE error class extending yii\web\HttpException
             */
            throw new \Exception('Unable to get data. The service is temporarily unavailable', 503);
        }

        /**
         * TODO?: While the following is simple, it could be done in a Yii way by introducing a new helper 
         * method similar to \yii\helpersArrayHelper::toArray() but doing the exact inverse by loading 
         * data into their respective object instances.
         */
        $dataObj = [];
        foreach($data as $item) {
            $post = new Post;
            $post->attributes = $item;
            $dataObj[] = $post;
        }

        return Yii::createObject([
            'class' => ArrayDataProvider::class,
            'allModels' => $dataObj,
            /**
             * An intern sort could optionally be introduced here.
             */
            'pagination' => [
                'pageSize' => $this->limit,
            ],
        ]);
    }
}