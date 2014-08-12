<?php

class WeatherController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'list', 'city'),
				'users'=>array('*'),
			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
			//array('deny',  // deny all users
			//	'users'=>array('*'),
			//),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Weather;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Weather']))
		{
			$model->attributes=$_POST['Weather'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Weather']))
		{
			$model->attributes=$_POST['Weather'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex(array $args)
	{
        header('Content-Type: application/json');
        $weather = Weather::model()->findAll();
        $json = JSON::encode($weather);
        echo $json;
	}

    public function actionFind($city=null, $lat=null, $lon=null, $lon_top=null, $lat_top=null, $lon_bottom=null, $lat_bottom=null)
    {
        header('Content-Type: application/json');
        if(isset($city)) {
            $weather = Yii::app()->db->createCommand()
                ->select('date_forecast, temp, humidity, pressure, wind_speed, wind_deg, longitude, latitude')
                ->from('weather w, weatherstation ws, city c')
                ->where('c.id = ws.city_id and ws.id = w.station_id and c.name_en = :city')
                ->bindParam(':city', $city, PDO::PARAM_STR)
                ->queryAll();
        }

        if(isset($lat) && isset($lon)){
            $weather_sql = Yii::app()->db->createCommand()
                ->select('name_ru, date_forecast, temp, humidity, pressure, wind_speed, wind_deg, longitude, latitude')
                ->from('weather w, weatherstation ws, city c')
                ->where('c.id = ws.city_id and ws.id = w.station_id and ws.latitude = :lat and ws.longitude = :lon');
            $weather_sql->bindParam(':lat', $lat, PDO::PARAM_STR);
            $weather_sql->bindParam(':lon', $lon, PDO::PARAM_STR);
            $weather = $weather_sql->queryAll();
        }

        if(isset($lon_top) && isset($lat_top) && isset($lon_bottom) && isset($lat_bottom)){
            $weather = array();
            $allWeather = Weather::model()->findAll();

            foreach($allWeather as $val){
                if($lon_top > $val->station->longitude && $lat_top > $val->station->latitude and
                $lon_bottom > $val->station->longitude && $lat_bottom > $val->station->latitude){
                    $weather[] = $val;
                }
            }
        }

        $json = JSON::encode($weather);
        echo $json;
    }



    public function actionList()
    {
        $dataProvider=new CActiveDataProvider('Weather');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Weather('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Weather']))
			$model->attributes=$_GET['Weather'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Weather the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Weather::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Weather $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='weather-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionError(){
        throw new CHttpException(404,'Запись не найдена');
    }
}
