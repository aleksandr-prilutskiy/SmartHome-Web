<?php
$month = date("m");
$year = date("Y");     
$months  = array('Январь','Февраль','Март','Апрель','Май','Июнь','Июль',
                 'Август','Сентябрь','Октябрь','Ноябрь','Декабрь');
$headings = array('Пн','Вт','Ср','Чт','Пт','Сб','Вс');
?>
            <div class="box col-lg-4 col-md-5 col-sm-12 col-xs-12">
                <div class="box-inner">
                    <div class="box-header well" data-original-title="">
                        <h2>Календарь</h2>
                    </div>
                    <div class="box-content">
<?php
echo '<div class="center animated rubberBand calendar"><h3>'.$months[(int)$month - 1].' '.$year.'</h3></div>';
echo '<table cellpadding="0" cellspacing="0" class="table table-striped">';
echo '<tr class="b-calendar__row">';
for($head_day = 0; $head_day <= 6; $head_day++) {
    echo '<th class="';
    if ($head_day != 0) { // выделяем выходные дни
        if (($head_day % 5 == 0) || ($head_day % 6 == 0)) { echo ' red'; }
    }
    echo '"><div class="center">'.$headings[$head_day].'</div></th>';
}
echo '</tr>';
$running_day = date('w', mktime(0,0,0,$month,1,$year)); // выставляем начало недели на понедельник
$running_day = $running_day - 1;
if ($running_day == -1) $running_day = 6;
$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
$day_counter = 0;
$days_in_this_week = 1;
$dates_array = array();
echo '<tr>'; // первая строка календаря
for ($x = 0; $x < $running_day; $x++) { // вывод пустых ячеек
    echo '<td></td>';
    $days_in_this_week++;
}
for ($list_day = 1; $list_day <= $days_in_month; $list_day++) { // запись чисел в первую строку
    echo '<td class="';
    if ($running_day != 0) { // выделяем выходные дни
        if (($running_day % 5 == 0) || ($running_day % 6 == 0)) echo ' red';
    }
    echo '"><div class="calendar center';
    if ($list_day == (int)date("d")) echo ' bg-primary';
    echo '">';
    if ($list_day == (int)date("d")) echo '<strong>'.$list_day.'</strong>';
    else echo $list_day;
    echo '</div></td>';
    if ($running_day == 6) { // последний днь недели
        echo '</tr>';
        if (($day_counter + 1) != $days_in_month) echo '<tr>';
        $running_day = -1;
        $days_in_this_week = 0;
    }
    $days_in_this_week++; 
    $running_day++; 
    $day_counter++;
}
if ($days_in_this_week < 8) { // выводим пустые ячейки в конце последней недели
    for($x = 1; $x <= (8 - $days_in_this_week); $x++) echo '<td> </td>';
}
echo '</tr></table>';
?>
                    </div>
                </div>
            </div>              
                        
<style type="text/css">
.calendar {
    font-family: Crystal, 'Arial';
    font-size: 18px;
}

.calendar h3 {
    font-family: Marmelad-Regular, 'Times New Roman';
    font-size: 26px;
}
</style>
