<?php
use yii\helpers\Html;
?>

<div class="item">
    <div class="well">
        <a href="<?= Html::encode($model->author_link)?>" target="_blank">
            <h5 class="well-title">
                <?= Html::img($model->author_image_url, ['class' => 'avatar']) ?>
                <?= Html::encode($model->author_name) ?>
            </h5>
        </a>

        <a href="<?= Html::encode($model->image_link)?>" target="_blank">
             <?= Html::img($model->image_url, ['class' => 'post-img']) ?>
        </a>

        <div><p class="well-text"><?= Html::encode($model->description) ?></p></div>

        <div class="well-footer">
            <span class="pull-left"><?= Html::encode($model->getRepin()) ?></span>
            <span class="pull-right"><?= Html::encode($model->getDate()) ?></span>
        </div>

    </div>
</div>