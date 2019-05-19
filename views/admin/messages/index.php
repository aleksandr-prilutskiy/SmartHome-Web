<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Журнал cообщений';
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
            <div class="raw text-right">
                <button class="btn btn-danger" data-toggle="modal" data-target="#ModalConfirmClean">
                    <i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Очистить
                </button>
            </div>
            <div class="raw">
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'tableOptions' => ['class' => 'table table-condensed'],
    'emptyText' => 'Журнал cообщений пуст',
    'rowOptions' => function ($model, $key, $index, $grid) {
        if (($model->readed) || ($model->logfile == '')) {
            if ($model->error) return ['style' => 'color:red'];
        } else {
            if ($model->error) return ['style' => 'color:red; font-weight:bold'];
            else return ['style' => 'font-weight:bold'];
        }
    },
    'columns' => [
        ['attribute'=>'time',
         'label'=>'Время',
         'enableSorting' => false,
         'format'=>['date', 'dd.MM HH:mm:ss'],
        ],
        ['attribute'=>'creator',
         'label'=>'Приложение',
         'enableSorting' => false,
         'format'=>'text',
        ],
        ['attribute'=>'event',
         'label'=>'Состояние',
         'headerOptions' => ['class' => 'hidden-xs'],
         'contentOptions' => ['class' => 'hidden-xs'],
         'enableSorting' => false,
         'format'=>'text',
        ],
        ['attribute'=>'description',
         'label'=>'Описание',
         'headerOptions' => ['width' => '100%', 'class' => 'hidden-sm hidden-xs'],
         'contentOptions' => ['class' => 'hidden-sm hidden-xs'],
         'enableSorting' => false,
         'format'=>'text',
        ],
        ['class' => 'yii\grid\ActionColumn',
         'template' => '{view}',
         'buttons' => [
             'view' => function ($url,$model) {
                if ($model->logfile != '') {
                 return '<a class="btn btn-default btn-xs" href="'.$url.'">Просмотр</a>';
                } else { return ''; }
             }
         ],
         'urlCreator' => function($action, $model, $key, $index){
            if ($action == "view") return \yii\helpers\Url::to(['view','id'=>$model->id]);
         },
        ],
    ],
]); ?>
            </div>
        </div>
    </div>
</div>
<div id="ModalConfirmClean" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Очистить журнал cообщений?</h4>
      </div>
      <div class="modal-body">Вы действительно хотите удалить все записи из журнала cообщений?</div>
      <div class="modal-footer">
          <a href="#" class="btn btn-danger" data-dismiss="modal" onclick="location='?r=messages/clean'" id="button_yes">Да</a>
          <a href="#" class="btn btn-default" data-dismiss="modal">Нет</a>
      </div>
    </div>
  </div>
</div>
