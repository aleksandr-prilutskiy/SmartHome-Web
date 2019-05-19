<?php
$this->title = 'SmartHomeWeb';
?>
<div class="site-index">
    <div class="body-content">
        <div class=" row">
<?php foreach ($widgets as $widget):
    if (($widget->widget == null) || ($widget->widget == '')) {
        echo '</div><div class="row">';        
    } else {
        echo $this->render('..\widgets\\'.$widget->widget.'\index');
    }
endforeach; ?>
            
<?php
//echo $this->render('..\widgets\music\index');
//echo $this->render('..\widgets\movies\index');
//echo $this->render('..\widgets\series\index');
//echo $this->render('..\widgets\photo\index');
//echo $this->render('..\widgets\microclimate\index');
//echo '</div><div class="row">';
//echo $this->render('..\widgets\calendar\index');
//$this->render('_weather', ['weather' => $weather])
?>
        </div>
    </div>
</div>
