<?php

/* @var $this yii\web\View */

use Yii;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Beachinsoft Demo app';
?>
<div class="site-index">

    <div class="row searchForm">
        <?= $this->render('_searchForm', ['model' => $form]) ?>
    </div>

    <div class="body-content">
        <div id="postContainer" class="row masonry">
            <?= ListView::widget([
                'id' => 'list-view-container',
                'dataProvider' => $postProvider,
                'layout' => '{items}', // removed {summary} and {pager} as not yet needed
                'itemView' => '_post',
            ]) ?>
        </div>
        
        <div class="text-center loader-container">
            <?= Html::submitButton('Load more', [
                'id' => 'loadBtn',
                'class' => 'btn btn-default btn-lg',
                'action' => Url::to(['site/load-next'], true)
            ]) ?>
            <p id="loader" style="display: none;">loading...</p>
        </div>

    </div>
</div>
