<?php
use yii\helpers\Html;
use app\models\Network_sensors_types;
$this->title = 'Консруктор';
$this->params['breadcrumbs'][] = [
    'label' => 'Сеть',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => 'План помещений',
    'url' => '?r=foorplan/index',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];

?>
<div class="row" style="position:relative;" ondrop="drop(event)" ondragover="allowDrop(event)">
    <img src="images/~.gif" alt="" border="1" width="150" height="200">
        <img id="drag2" src="images/logo.jpg" draggable="true" ondragstart="drag(event)" width="32" height="32"
             style="position:absolute;left:10px;top:10px;">    
</div>
    

<script>
function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var obj = document.getElementById(data);
    obj.style.left = 300;
    obj.style.cursor = "pointer";
//    var c = obj.getBoundingClientRect()
//    alert('top:' + c.top + ' left: ' + c.left +'');
//    alert(obj.position);
//    ev.target.appendChild(document.getElementById(data));
}
</script>
