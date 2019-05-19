<?php
use app\models\Weather_forecast;
$weather = Weather_forecast::find()
    ->where('period > DATE_SUB(NOW(), INTERVAL 3 HOUR)')
    ->orderBy('period ASC');
?>
            <div class="box col-lg-6 col-md-7 col-sm-12 col-xs-12">
                <div class="box-inner">
                    <div class="box-header well" data-original-title="">
                        <h2>Погода</h2>
                    </div>
                    <div class="box-content">
                        <table class="table table-striped">
                            <tbody>
<?php
$line = 0;
$day = 0;
$today = new DateTime();
$tomorrow = new DateTime();
$tomorrow->add(new DateInterval('P1D'));
foreach ($weather->all() as $item):
 $datetime = new DateTime($item->period);
 if (date_format($datetime, 'G') == '3') continue;
 if (date_format($datetime, 'd') != $day) { 
  if ($line++ > 1) break;
  if ($day != 0) echo '</tr>';
?>  
                                <tr>
                                    <td colspan="7" class="weather_date">
<?php
 if (date_format($datetime, 'j') == date_format($today, 'j')) echo 'Сегодня, ';
 if (date_format($datetime, 'j') == date_format($tomorrow, 'j')) echo 'Завтра, ';
 echo date_format($datetime, 'd').' ';
 switch (date_format($datetime, 'n')) {
  case '1':
   echo 'января';
   break;
  case '2':
   echo 'февраля';
   break;
  case '3':
   echo 'марта';
   break;
  case '4':
   echo 'аперля';
   break;
  case '5':
   echo 'мая';
   break;
  case '6':
   echo 'июня';
   break;
  case '7':
   echo 'июля';
   break;
  case '8':
   echo 'августа';
   break;
  case '9':
   echo 'сентября';
   break;
  case '10':
   echo 'октября';
   break;
  case '11':
   echo 'ноября';
   break;
  case '12':
   echo 'декабря';
   break;
 }
 echo ' '.date_format($datetime, 'Y').' года';
 switch (date_format($datetime, 'N')) {
  case '1':
   echo ', понедельник';
   break;
  case '2':
   echo ', втроник';
   break;
  case '3':
   echo ', среда';
   break;
  case '4':
   echo ', четверг';
   break;
  case '5':
   echo ', пятница';
   break;
  case '6':
   echo ', суббота';
   break;
  case '7':
   echo ', воскресенье';
   break;
 }
?>
                                    </td>
                                </tr>
                                <tr>
<?php for ($i = 0; $i < date_format($datetime, 'G'); $i = $i + 3)
    if ($i <> 3) {
        echo '<td';
        if ($i == 6) echo ' class="hidden-xs"';
        echo '></td>';
    }
$day = date_format($datetime, 'j'); } ?>
                                    <td<?php if (date_format($datetime, 'H') == '06') echo ' class="hidden-xs"'?>>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center"><img src="images/weather/<?= $item->symbol ?>.png" border="0"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center weather_temperature"><strong><?= round($item->temperature, 1) ?>°C</strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center weather_time"><?= date_format($datetime, 'H') ?>:00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
<?php endforeach;
if ($day != 0) echo '</tr>'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
<style type="text/css">
.weather_date {
    font-family: Marmelad-Regular, 'Times New Roman';
    font-size: 18px;
}
.weather_time {
    font-family: Crystal, 'Arial';
    font-size: 12px;
}
.weather_temperature {
    font-family: ZurichCalligraphic, 'Arial';
    font-size: 14px;
}
</style>