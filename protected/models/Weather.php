<?php

/**
 * This is the model class for table "weather".
 *
 * The followings are the available columns in table 'weather':
 * @property integer $id
 * @property string $date_forecast
 * @property integer $partofday
 * @property integer $temp
 * @property integer $humidity
 * @property integer $pressure
 * @property double $wind_speed
 * @property integer $wind_deg
 * @property integer $station_id
 * @property integer $provider_id
 * @property string $precipitation
 *
 * The followings are the available model relations:
 * @property Weatherstation $station
 * @property WindDeg $windDeg
 * @property Provider $provider
 */
class Weather extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'weather';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_forecast, temp, humidity, pressure, wind_speed, wind_deg, station_id, provider_id, precipitation', 'required'),
			array('partofday, temp, humidity, pressure, wind_deg, station_id, provider_id', 'numerical', 'integerOnly'=>true),
			array('wind_speed', 'numerical'),
			array('precipitation', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date_forecast, partofday, temp, humidity, pressure, wind_speed, wind_deg, station_id, provider_id, precipitation', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'station' => array(self::BELONGS_TO, 'Weatherstation', 'station_id'),
			'windDeg' => array(self::BELONGS_TO, 'WindDeg', 'wind_deg'),
			'provider' => array(self::BELONGS_TO, 'Provider', 'provider_id'),
            'city'=>array(self::HAS_ONE,'City',array('city_id'=>'id'),'through'=>'station'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date_forecast' => 'Дата',
			'partofday' => 'Время суток',
			'temp' => 'Температура',
			'humidity' => 'Влажность',
			'pressure' => 'Давление',
			'wind_speed' => 'Скорость ветра',
			'wind_deg' => 'Направление ветра',
			'station_id' => 'Метеостация',
			'provider_id' => 'Провайдер',
			'precipitation' => 'Погода',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('date_forecast',$this->date_forecast,true);
		$criteria->compare('partofday',$this->partofday);
		$criteria->compare('temp',$this->temp);
		$criteria->compare('humidity',$this->humidity);
		$criteria->compare('pressure',$this->pressure);
		$criteria->compare('wind_speed',$this->wind_speed);
		$criteria->compare('wind_deg',$this->wind_deg);
		$criteria->compare('station_id',$this->station_id);
		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('precipitation',$this->precipitation,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
//
//    public function beforeSave()
//    {
//
//        if($this->isNewRecord) {
//            $c = new CDbCriteria();
//            $c->addCondition("date_forecast = :date_forecast");
//            $c->addCondition("provider_id = :provider_id");
//            $c->addCondition("partofday = :partofday");
//
//            $c->params[':date_forecast'] = $this->date_forecast;
//            $c->params[':provider_id'] = $this->provider_id;
//            $c->params[':partofday'] = $this->partofday;
//
//            if($model = Weather::model()->find($c)) {
//                $model->attributes = $this->attributes;
//                $model->save();
//                return false;
//            }
//        }
//
//        return true;
//
//    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Weather the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Ищет погоду по городу для текущей даты и указанного провайдера
     * @param $today дата для которой ищется погода
     * @param $city город для которого ищется погода
     * @param $provider провайдер для которого ищется погода
     * @return array массив с результатом поиска
     */
    public static function findByCity($today, $city, $provider){
        $criteria=new CDbCriteria;
        $criteria->alias = 'weather';
        $criteria->select = 'date_forecast,  ROUND(AVG(temp)) as temp, ROUND(AVG(humidity)) as humidity, ROUND(AVG(pressure)) as pressure, precipitation';
        $criteria->condition = "(`city`.`name_en` LIKE :city OR `city`.`name_ru` LIKE :city)
                                AND `weather`.`date_forecast` = :today AND `weather`.`provider_id` = :provider";
        $criteria->params = array(':city'=>$city, ':provider'=>$provider, ':today'=>$today);
        $criteria->with = array('station', 'windDeg', 'provider', 'city');
        if(!($model = Weather::model()->find($criteria))){
            throw new CHttpException(404,'Город не найден');
        }
        $result[] = [
            'city'=> mb_convert_case($model->city->name_ru, MB_CASE_TITLE , "UTF-8"),
            'date'=> $model['date_forecast'],
            'temp'=> $model['temp'],
            'humidity'=> $model['humidity'],
            'pressure'=> $model['pressure'],
            'latitude'=> $model->station->latitude,
            'longitude'=> $model->station->longitude,
            'precipitation'=> $model['precipitation'],
            'provider'=> $model->provider->name,
        ];

        return $result;
    }

    /**
     * Ищет погоду по координатам для текущей даты и указанного провайдера
     * @param $today дата для которой ищется погода
     * @param $lat широта
     * @param $lon долгота
     * @param $provider провайдер для которого ищется погода
     * @return array массив с результатом поиска
     */
    public static function findByCoordinates($today, $lat, $lon, $provider){
        $criteria=new CDbCriteria;
        $criteria->alias = 'weather';
        $criteria->select = 'date_forecast,  ROUND(AVG(temp)) as temp, ROUND(AVG(humidity)) as humidity, ROUND(AVG(pressure)) as pressure, precipitation';
        $criteria->condition = "station.latitude = :lat AND station.longitude = :lon
					                AND date_forecast = :today AND provider_id = :provider";
        $criteria->params = array(':lat'=>$lat, ':lon'=>$lon, ':provider'=>$provider, ':today'=>$today);
        $criteria->with = array('station', 'windDeg', 'provider', 'city');

        if(!($model = Weather::model()->find($criteria))){
            throw new CHttpException(404,'Город не найден');
        }

        $result[] = [
            'city'=> mb_convert_case($model->city->name_ru, MB_CASE_TITLE , "UTF-8"),
            'date'=> $model['date_forecast'],
            'temp'=> $model['temp'],
            'humidity'=> $model['humidity'],
            'pressure'=> $model['pressure'],
            'latitude'=> $model->station->latitude,
            'longitude'=> $model->station->longitude,
            'precipitation'=> $model['precipitation'],
            'provider'=> $model->provider->name,
        ];

        return $result;
    }

    /**
     * Ищет погоду в заданном диапазоне широт для текущей даты и указанного провайдера
     * @param $today дата для которой ищется погода
     * @param $lat_top широта левой верхней точки
     * @param $lon_top долгота левой верхней точки
     * @param $lat_bottom широта правой нижней точки
     * @param $lon_bottom долгота правой нижней точки
     * @param $provider провайдер для которого ищется погода
     * @return array
     */
    public static function findByRect($today, $lat_top, $lon_top, $lat_bottom, $lon_bottom, $provider){
        $criteria=new CDbCriteria;
        $criteria->alias = 'weather';
        $criteria->select = 'date_forecast,  ROUND(AVG(temp)) as temp, ROUND(AVG(humidity)) as humidity, ROUND(AVG(pressure)) as pressure, precipitation';
        $criteria->condition = "station.id IN (SELECT id FROM weatherstation
            WHERE Contains(GeomFromText('Polygon(($lat_top $lon_top, $lat_top $lon_bottom, $lat_bottom $lon_bottom,$lat_top $lon_bottom, $lat_top $lon_top))'), point))
            AND date_forecast = :today AND provider_id = :provider";
        $criteria->group = 'name_ru';
        $criteria->order = 'population DESC';
        $criteria->limit = '30';
        $criteria->params = array(':provider'=>$provider, ':today'=>$today);
        $criteria->with = array('station', 'windDeg', 'provider', 'city');

        if(!($models = Weather::model()->findAll($criteria))){
            throw new CHttpException(404,'Город не найден');
        }

        foreach($models as $model){
            $result[] = [
                'city'=> mb_convert_case($model->city->name_ru, MB_CASE_TITLE , "UTF-8"),
                'date'=> $model['date_forecast'],
                'temp'=> $model['temp'],
                'humidity'=> $model['humidity'],
                'pressure'=> $model['pressure'],
                'latitude'=> $model->station->latitude,
                'longitude'=> $model->station->longitude,
                'precipitation'=> $model['precipitation'],
                'provider'=> $model->provider->name,
            ];
        }

        return $result;
    }

    /**
     * Ищет погоду по городу на ближайшие дни от указанной даты и указанного провайдера
     * @param $today дата для которой ищется погода
     * @param $city город для которого ищется погода
     * @param $provider провайдер для которого ищется погода
     * @return array массив с результатом поиска
     */
    public static function findAllByCity($today, $city, $provider){
        $criteria=new CDbCriteria;
        $criteria->alias = 'weather';
        //$criteria->select = 'date_forecast, partofday, temp, humidity, pressure, precipitation';
        $criteria->condition = "(`city`.`name_en` LIKE :city OR `city`.`name_ru` LIKE :city)
                                AND `weather`.`date_forecast` >= :today AND `weather`.`provider_id` = :provider";
        $criteria->params = array(':city'=>$city, ':provider'=>$provider, ':today'=>$today);
        $criteria->order = 'date_forecast ASC, partofday ASC';
        $criteria->with = array('station', 'windDeg', 'provider', 'city');

        if(!($models = Weather::model()->findAll($criteria))){
            throw new CHttpException(404,'Город не найден');
        }

        foreach($models as $model){
            $result[] = [
                'city'=> mb_convert_case($model->city->name_ru, MB_CASE_TITLE , "UTF-8"),
                'date'=> $model['date_forecast'],
                'partofday'=> $model['partofday'],
                'temp'=> $model['temp'],
                'humidity'=> $model['humidity'],
                'pressure'=> $model['pressure'],
                'wind_speed'=> $model['wind_speed'],
                'wind_deg' => $model->windDeg->description,
                'latitude'=> $model->station->latitude,
                'longitude'=> $model->station->longitude,
                'precipitation'=> $model['precipitation'],
                'provider'=> $model->provider->name,
            ];
        }
        return $result;
    }

    /**
     * Ищет погоду по координатам на ближайшие дни от указанной даты и указанного провайдера
     * @param $today дата для которой ищется погода
     * @param $lat широта
     * @param $lon долгота
     * @param $provider провайдер для которого ищется погода
     * @return array массив с результатом поиска
     */
    public static function findAllByCoordinates($today, $lat, $lon, $provider){
        $criteria=new CDbCriteria;
        $criteria->alias = 'weather';
        //$criteria->select = 'date_forecast, partofday, temp, humidity, pressure, precipitation';
        $criteria->condition = "station.latitude = :lat AND station.longitude = :lon
					                AND date_forecast >= :today AND provider_id = :provider";
        $criteria->params = array(':lat'=>$lat, ':lon'=>$lon, ':provider'=>$provider, ':today'=>$today);
        $criteria->order = 'date_forecast, partofday';
        $criteria->with = array('station', 'windDeg', 'provider', 'city');

        if(!($models = Weather::model()->findAll($criteria))){
            throw new CHttpException(404,'Город не найден');
        }

        foreach($models as $model){
            $result[] = [
                'city'=> mb_convert_case($model->city->name_ru, MB_CASE_TITLE , "UTF-8"),
                'date'=> $model['date_forecast'],
                'partofday'=> $model['partofday'],
                'temp'=> $model['temp'],
                'humidity'=> $model['humidity'],
                'pressure'=> $model['pressure'],
                'wind_speed'=> $model['wind_speed'],
                'wind_deg' => $model->windDeg->description,
                'latitude'=> $model->station->latitude,
                'longitude'=> $model->station->longitude,
                'precipitation'=> $model['precipitation'],
                'provider'=> $model->provider->name,
            ];
        }
        return $result;
    }
}
