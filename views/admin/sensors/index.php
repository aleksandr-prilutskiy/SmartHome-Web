<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Редактирование спиcка датчиков';
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
            <div class="raw text-right">
                <button class="btn btn-primary" onclick="location='?r=admsensors/add'">Добавить</button>
            </div>
            <div class="raw">
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'tableOptions' => ['class' => 'table table-condensed'],
    'emptyText' => 'Список датчиков пуст',
    'columns' => [
        ['class' => 'yii\grid\ActionColumn',
         'template' => '{menu}',
         'buttons' => [
            'menu' => function ($url, $model) {
                $result = '<div class="btn-group"><button data-toggle="dropdown"><i class="fas fa-bars"></i></button>'.
                    '<ul class="dropdown-menu pull-right" role="menu">'.
                    '<li><a href="?r=admsensors/update&id='.$model->id.'"><i class="fa fa-pencil-alt"></i>&nbsp;Редактировать</a></li>'.
                    '<li><a href="?r=admsensors/copy&id='.$model->id.'"><i class="far fa-clone"></i>&nbsp;Создать копию</a></li>'.
                    '<li><a href="#" onclick="ModalBoxConfirmDelete(\''.$model->topic.'\','.$model->id.')">'.
                        '<i class="far fa-trash-alt"></i>&nbsp;Удалить</a></li>';
                if ($model->id > $GLOBALS["min_id"]) $result .= '<li><a href="?r=admsensors/up&id='.$model->id.'"><i class="fa fa-arrow-circle-up"></i>&nbsp;Переместить вверх</a></li>';
                if ($model->id < $GLOBALS["max_id"]) $result .= '<li><a href="?r=admsensors/down&id='.$model->id.'"><i class="fa fa-arrow-circle-down"></i>&nbsp;Переместить вниз</a></li>';
                $result .= '</ul></div>';
                return $result;
            },
         ],
        ],
        ['attribute'=>'topic',
         'label'=>'Топик',
         'enableSorting' => false,
         'format'=>'text',
        ],
        ['format' => 'raw',
         'value' => function($model){ return $model->getIcon(16); },
        ],                    
        ['attribute'=>'description',
         'label'=>'Имя датчика',
         'headerOptions' => ['width' => '100%'],
         'enableSorting' => false,
         'format'=>'text',
        ],
    ],
]); ?>
            </div>
        </div>
    </div>
</div>
<div id="ModalConfirmDelete" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Удалить датчик?</h4>
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
 document.getElementById("confirm_text").innerHTML = 'Вы действительно хотите удалить датчик "' + text + '"?';
 document.getElementById("button_yes").setAttribute('onclick', 'location=\'?r=admsensors/delete&id=' + id + '\'');
 $("#ModalConfirmDelete").modal('show');
}
</script>
