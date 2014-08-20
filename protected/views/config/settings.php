<?php
/* @var $this WeatherController */
/* @var $isFlush CActiveDataProvider */

$this->menu=array(
    array('label'=>'Управление базой данных погоды', 'url'=>array('admin')),
	array('label'=>'Создать информацию по погоде', 'url'=>array('create')),
);
?>

<h1>Настройки сервера</h1>
<table>
<tr>
    <td>Очистка кэша</td>
    <td><?php echo CHtml::Button('Очистить',array(
            'submit' => array('config/clearCache'),
        ));
        if(isset($_GET['isFlush']))
            echo " ".$_GET['isFlush'];

        ?></td>
</tr>
</table>