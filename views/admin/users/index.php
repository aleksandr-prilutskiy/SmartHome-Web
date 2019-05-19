<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Список пользователей';
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
            <div class="raw text-right">
                <button class="btn btn-primary" onclick="location='?r=admusers/add'">Добавить</button>
            </div>
            <div class="raw">
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'showHeader'=> false,
    'tableOptions' => ['class' => 'table table-condensed'],
    'emptyText' => 'Список пользователей пуст',
    'columns' => [
        ['class' => 'yii\grid\ActionColumn',
         'template' => '{menu}',
         'buttons' => [
            'menu' => function ($url, $model) {
                $result = '<div class="btn-group"><button data-toggle="dropdown"><i class="fas fa-bars"></i></button>'.
                    '<ul class="dropdown-menu pull-right" role="menu">'.
                    '<li><a href="?r=admusers/update&id='.$model->id.'"><i class="fa fa-pencil-alt"></i>&nbsp;Редактировать</a></li>'.
                    '<li><a href="#" onclick="ModalBoxConfirmDelete(\''.$model->username.'\','.$model->id.')"><i class="far fa-trash-alt"></i>&nbsp;Удалить</a></li>';
                     '</ul></div>';
                return $result;
            },
         ],
        ],
        ['attribute'=>'username',
         'format'=>'text',
        ],
        ['attribute'=>'description',
         'headerOptions' => ['class' => 'hidden-xs'],
         'contentOptions' => ['width' => '100%', 'class' => 'hidden-xs'],
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
        <h4>Удалить пользователя?</h4>
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
 document.getElementById("confirm_text").innerHTML = 'Вы действительно хотите удалить пользователя "' + text + '"?';
 document.getElementById("button_yes").setAttribute('onclick', 'location=\'?r=admusers/delete&id=' + id + '\'');
 $("#ModalConfirmDelete").modal('show');
}
</script>
