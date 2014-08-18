<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 18.08.2014
 * Time: 22:47
 */

class ConfigController extends Controller {

    /**
     * Определяет правила контроля доступа.
     * Этот метод используется фильтром 'AccessControl'.
     * @return массив правил контроля доступа.
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('settings', 'ClearCache'),
                'users'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }


    /**
     * Перенаправляет на страницу настроек
     */
    public function actionSettings(){
        $this->render('settings');
    }

    /**
     * Очищает кэш
     */
    public function actionClearCache(){
        if(Yii::app()->cache->flush()){
            $is = 'кэш очищен';
        }
        $this->redirect(array('config/settings', 'isFlush' => $is));
    }

} 