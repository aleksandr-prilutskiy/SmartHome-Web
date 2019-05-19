<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Config;
$this->title = 'Выполнить';
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'showHeader'=> false,
    'tableOptions' => ['class' => 'table table-condensed'],
    'emptyText' => 'Список команд администратора пуст',
    'columns' => [
        ['class' => 'yii\grid\ActionColumn',
         'template' => '{run}',
         'buttons' => [
            'run' => function ($url, $model) {
                return '<button onclick="ModalConfirmRun(\''.$model->description.'\','.$model->id.')"><i class="far fa-play"></i></button>';
            },
         ],
        ],
        ['attribute'=>'description',
         'header'=>'Описание команды',
         'contentOptions' => ['width' => '100%'],
         'format'=>'text',
        ],
    ],
]);
?>
        </div>
    </div>
</div>
<div id="ModalConfirmRun" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Выполнить команду?</h4>
      </div>
      <div class="modal-body" id="confirm_text"></div>
      <div class="modal-footer">
          <a href="#" class="btn btn-default" data-dismiss="modal">Нет</a>
          <a href="#" class="btn btn-primary" data-dismiss="modal" onclick="" id="button_yes">Да</a>
      </div>
    </div>
  </div>
</div>
<script>
function ModalConfirmRun(text,id){
 var modal = $(this);
 document.getElementById("confirm_text").innerHTML = 'Подтвердите выполнение команды "' + text + '"?';
 document.getElementById("button_yes").setAttribute('onclick', 'location=\'?r=admin/execute&id=' + id + '\'');
 $("#ModalConfirmRun").modal('show');
}
</script>
