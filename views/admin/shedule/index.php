<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'События по рассписанию';
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
            <div class="raw text-right">
                <button class="btn btn-primary" onclick="location='?r=admshedule/add'">Добавить</button>
            </div>
            <div class="raw">
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'tableOptions' => ['class' => 'table table-condensed'],
    'emptyText' => 'Событий по рассписанию нет',
    'columns' => [
        ['class' => 'yii\grid\ActionColumn',
         'template' => '{menu}',
         'buttons' => [
            'menu' => function ($url, $model) {
                $result = '<div class="btn-group"><button data-toggle="dropdown"><i class="fas fa-bars"></i></button>'.
                    '<ul class="dropdown-menu pull-right" role="menu">';
                if ($model->enable == 0) $result .= '<li><a href="?r=admshedule/enable&id='.$model->id.'"><i class="fa fa-check"></i>&nbsp;Разрешить</a></li>';
                else $result .= '<li><a href="?r=admshedule/disable&id='.$model->id.'"><i class="fas fa-ban"></i>&nbsp;Запретить</a></li>';
                $result .= '<li><a href="?r=admshedule/update&id='.$model->id.'"><i class="fa fa-pencil-alt"></i>&nbsp;Редактировать</a></li>'.
                    '<li><a href="?r=admshedule/copy&id='.$model->id.'"><i class="far fa-clone"></i>&nbsp;Создать копию</a></li>'.
                    '<li><a href="#" onclick="ModalBoxConfirmDelete(\''.$model->description.'\','.$model->id.')">'.
                        '<i class="far fa-trash-alt"></i>&nbsp;Удалить</a></li>';
                if ($model->id > $GLOBALS["min_id"]) $result .= '<li><a href="?r=admshedule/up&id='.$model->id.'"><i class="fa fa-arrow-circle-up"></i>&nbsp;Переместить вверх</a></li>';
                if ($model->id < $GLOBALS["max_id"]) $result .= '<li><a href="?r=admshedule/down&id='.$model->id.'"><i class="fa fa-arrow-circle-down"></i>&nbsp;Переместить вниз</a></li>';
                $result .= '</ul></div>';
                return $result;
            },
         ],
        ],
        ['format' => 'raw',
         'value' => function($model){
            if ($model->enable == 1) return '<img src="images\icons\enable.png" width="16" hight="16">';
            return '<img src="images\icons\disable.png" width="16" hight="16">';
         },
        ],                    
        ['attribute'=>'next_time',
         'label'=>'Время',
         'headerOptions' => ['class' => 'hidden-sm hidden-xs'],
         'contentOptions' => ['class' => 'hidden-sm hidden-xs'],
         'enableSorting' => false,
         'format'=>['date', 'dd.MM HH:mm'],
        ],
        ['attribute'=>'mode',
         'label'=>'Повторение',
         'enableSorting' => false,
         'format'=>'text',
         'value' => function($model) {
            if ($model->mode == 0) return 'Один раз';
            if ($model->mode == 1) return 'Каждые '.$model->period.' сек.';
            if ($model->mode == 2) return 'Каждый час';
            if ($model->mode == 3) return 'Ежедневно';
            if ($model->mode == 4) return 'Еженедельно';
            if ($model->mode == 5) return 'Ежемесячно';
            if ($model->mode == 6) return 'Ежегодно';
            return 'Ошибка';
         },
        ],
        ['attribute'=>'cmdstr',
         'header'=>'Команда',
         'enableSorting' => false,
         'format'=>'text',
        ],
        ['attribute'=>'description',
         'label'=>'Описание',
         'headerOptions' => ['width' => '100%', 'class' => 'hidden-md hidden-sm hidden-xs'],
         'contentOptions' => ['class' => 'hidden-md hidden-sm hidden-xs'],
         'enableSorting' => false,
         'format'=>'text',
        ],
    ],
]);
?>
            </div>
        </div>
    </div>
</div>
<div id="ModalConfirmDelete" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Удалить событие по рассписанию?</h4>
      </div>
      <div class="modal-body" id="confirm_text"></div>
      <div class="modal-footer">
          <a href="#" class="btn btn-default" data-dismiss="modal">Нет</a>
          <a href="#" class="btn btn-danger" data-dismiss="modal" onclick="" id="button_yes">Да</a>
      </div>
    </div>
  </div>
</div>
<script>
function ModalBoxConfirmDelete(text,id){
 var modal = $(this);
 document.getElementById("confirm_text").innerHTML = 'Вы действительно хотите удалить событие по рассписанию "' + text + '"?';
 document.getElementById("button_yes").setAttribute('onclick', 'location=\'?r=admshedule/delete&id=' + id + '\'');
 $("#ModalConfirmDelete").modal('show');
}
</script>
