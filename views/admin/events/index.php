<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Журнал событий';
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
    'emptyText' => 'Журнал событий пуст',
    'rowOptions' => function ($model, $key, $index, $grid) {
        if ($model->status == -1)  return ['style' => 'color:red'];
        elseif ($model->status == 0)  return ['style' => 'font-weight:bold'];
    },
    'columns' => [
        ['attribute'=>'updated',
         'label'=>'Время',
         'enableSorting' => false,
         'format'=>['date', 'dd.MM HH:mm:ss'],
        ],
        ['attribute'=>'type',
         'header'=>'Тип',
         'format'=>'text',
         'enableSorting' => false,
         'value' => function($model) {
            return ($model->type == 0) ? 'Интерфейс' : (
                ($model->type == 1) ? 'Расписание' : (
                ($model->type == 2) ? 'Сценарий' : '?'));
         }
        ],
        ['attribute'=>'cmdstr',
         'enableSorting' => false,
         'headerOptions' => ['width' => '100%'],
         'header'=>'Команда',
         'format'=>'text',
        ],
        ['attribute'=>'username',
         'label'=>'Пользователь',
         'enableSorting' => false,
         'headerOptions' => ['class' => 'hidden-md hidden-sm hidden-xs'],
         'contentOptions' => ['class' => 'hidden-md hidden-sm hidden-xs'],
         'format'=>'text',
        ],
        ['attribute'=>'status',
         'label'=>'Состояние',
         'format'=>'text',
         'enableSorting' => false,
         'value' => function($model) {
            return ($model->status == 0) ? 'Не обработано' : (
                ($model->status > 0) ? 'Обработано' : 'Пропущено');
         }
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
        <h4>Очистить журнал событий?</h4>
      </div>
      <div class="modal-body">Вы действительно хотите удалить все записи из журнала событий?</div>
      <div class="modal-footer">
          <a href="#" class="btn btn-danger" data-dismiss="modal" onclick="location='?r=events/clean'" id="button_yes">Да</a>
          <a href="#" class="btn btn-default" data-dismiss="modal">Нет</a>
      </div>
    </div>
  </div>
</div>
