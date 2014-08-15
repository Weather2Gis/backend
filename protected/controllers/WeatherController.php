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
	public function actionIndex()
	{
        echo "<center><h2>Пример запросов</h2>" .
            "<p>Поиск по городу: <pre>/weather.php?r=weather/find&city=Moscow</pre></p>" .
            "<p>Поиск по координатам: <pre>/weather.php?r=weather/find&lat=55.753676&lon=37.619899</pre></p>" .
            "<p>Поиск в пределах прямоугольника: <pre>/weather.php?r=weather/find&lon_top=82.560544&lat_top=55.174534&lon_bottom=83.318972&lat_bottom=54.843024</pre></p></center>";
	}

    public function actionFind()
    {
		header('Content-Type: application/json');
		$pr = ["ya" => 1, "owm" => 2,]; //Провайдер
	
        $city = Yii::app()->request->getQuery('city');
        $lat = Yii::app()->request->getQuery('lat');
        $lon = Yii::app()->request->getQuery('lon');
        $lon_top = Yii::app()->request->getQuery('lon_top');
        $lat_top = Yii::app()->request->getQuery('lat_top');
        $lon_bottom = Yii::app()->request->getQuery('lon_bottom');
        $lat_bottom = Yii::app()->request->getQuery('lat_bottom');
		$provider = Yii::app()->request->getQuery('pr', "owm");
		$provider = strtr($provider, $pr);
		$today = date("Y-m-d");
        
        if(isset($city)) {
			$sql = "SELECT name_ru, date_forecast, temp, humidity, pressure, wind_speed, wd.description, longitude, latitude, p.name, pr.name
					FROM weather w, weatherstation ws, city c, precipitation p, provider pr, wind_deg wd
					WHERE c.id = ws.city_id and ws.id = w.station_id and p.id = precipitation_id and w.wind_deg = wd.id 
					and pr.id = provider_id and (c.name_en LIKE :city OR c.name_ru LIKE :city) and date_forecast = :today and provider_id = :provider and partofday = 2
					ORDER BY date_forecast";
			
			$city = mb_convert_case($city, MB_CASE_TITLE, "UTF-8");
			$weather = Yii::app()->db->createCommand($sql)
						->bindParam(':city', $city, PDO::PARAM_STR)
						->bindParam(':provider', $provider, PDO::PARAM_STR)
						->bindParam(':today', $today, PDO::PARAM_STR)
						->queryAll();
        }

        if(isset($lat) && isset($lon)){
			$sql = "SELECT name_ru, date_forecast, temp, humidity, pressure, wind_speed, wd.description, longitude, latitude, p.name, pr.name
					FROM weather w, weatherstation ws, city c, precipitation p, provider pr, wind_deg wd
					WHERE c.id = ws.city_id and ws.id = w.station_id and p.id = precipitation_id and w.wind_deg = wd.id 
					and ws.latitude = :lat and ws.longitude = :lon and date_forecast = :today 
					and provider_id = :provider and partofday = 2
					ORDER BY date_forecast";
			$weather = Yii::app()->db->createCommand($sql)
						->bindParam(':lat', $lat, PDO::PARAM_STR)
						->bindParam(':lon', $lon, PDO::PARAM_STR)
						->bindParam(':provider', $provider, PDO::PARAM_STR)
						->bindParam(':today', $today, PDO::PARAM_STR)
						->queryAll();
        }

        if(isset($lon_top) && isset($lat_top) && isset($lon_bottom) && isset($lat_bottom)){
			$sql = "SELECT name_ru, date_forecast, temp, humidity, pressure, wind_speed, wd.description, longitude, latitude, p.name, pr.name
                    FROM weatherstation ws
                    LEFT JOIN city c ON c.id = ws.city_id
                    LEFT JOIN weather w ON w.station_id = ws.id
                    LEFT JOIN provider pr ON w.provider_id = pr.id
                    LEFT JOIN wind_deg wd ON w.wind_deg = wd.id
                    LEFT JOIN precipitation p ON w.precipitation_id = p.id
                    WHERE ws.id IN (SELECT id FROM weatherstation WHERE longitude >= :lon_top AND longitude <= :lon_bottom AND latitude <= :lat_top AND latitude >= :lat_bottom) AND
                    date_forecast = :today AND partofday = 2 AND w.provider_id = :provider";
			$weather = Yii::app()->db->createCommand($sql)
					->bindParam(':provider', $provider, PDO::PARAM_STR)
					->bindParam(':today', $today, PDO::PARAM_STR)
					->bindParam(':lon_top', $lon_top, PDO::PARAM_STR)
					->bindParam(':lat_top', $lat_top, PDO::PARAM_STR)
					->bindParam(':lon_bottom', $lon_bottom, PDO::PARAM_STR)
					->bindParam(':lat_bottom', $lat_bottom, PDO::PARAM_STR)				
					->queryAll();
        }

        $json = JSON::encode($weather);
        printf("callback(%s)", $json);
    }
	
	public function actionForecast(){
		header('Content-Type: application/json');
		$pr = ["ya" => 1, "owm" => 2,]; //Провайдер
		$city = Yii::app()->request->getQuery('city');
        $lat = Yii::app()->request->getQuery('lat');
        $lon = Yii::app()->request->getQuery('lon');
		$provider = Yii::app()->request->getQuery('pr', "owm");
		$provider = strtr($provider, $pr);
		$today = date("Y-m-d");
		
		if(isset($city)) {
			$sql = "SELECT name_ru, date_forecast, partofday, temp, humidity, pressure, wind_speed, wind_deg, longitude, latitude, p.name, pr.name
					FROM weather w, weatherstation ws, city c, precipitation p, provider pr, wind_deg wd
					WHERE c.id = ws.city_id and ws.id = w.station_id and p.id = precipitation_id and w.wind_deg = wd.id 
					and pr.id = provider_id and c.name_en = :city and provider_id = :provider
					ORDER BY date_forecast";
			
			$city = mb_convert_case($city, MB_CASE_TITLE, "UTF-8");
			$weather = Yii::app()->db->createCommand($sql)
						->bindParam(':city', $city, PDO::PARAM_STR)
						->bindParam(':provider', $provider, PDO::PARAM_STR)
						->queryAll();
        }

        if(isset($lat) && isset($lon)){
            $weather_sql = Yii::app()->db->createCommand()
                ->select('name_ru, date_forecast, temp, humidity, pressure, wind_speed, wind_deg, longitude, latitude')
                ->from('weather w, weatherstation ws, city c')
                ->where('c.id = ws.city_id and ws.id = w.station_id and ws.latitude = :lat and ws.longitude = :lon and provider_id = :provider');
            $weather_sql->bindParam(':lat', $lat, PDO::PARAM_STR);
            $weather_sql->bindParam(':lon', $lon, PDO::PARAM_STR);
			$weather_sql->bindParam(':provider', $provider, PDO::PARAM_STR);
            $weather = $weather_sql->queryAll();
        }	

		$json = JSON::encode($weather);
        printf("callback(%s)", $json);		
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
