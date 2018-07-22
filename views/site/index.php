<?php

/* @var $this yii\web\View */

use Yii;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;

$this->title = 'Beachinsoft Demo app';
?>
<div class="site-index">

    <div class="row">
        <?= $this->render('_searchForm', ['model' => $form]) ?>
    </div>

    <div class="body-content">
        <div id="postContainer" class="row masonry">
            <?= ListView::widget([
                'dataProvider' => $postProvider,
                'layout' => '{items}', // removed {summary} and {pager} as not yet needed
                'itemView' => '_post',
            ]) ?>
        </div>
    

    </div>
</div>
