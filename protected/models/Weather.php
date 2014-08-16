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
 * @property integer $precipitation_id
 * @property integer $station_id
 * @property integer $provider_id
 *
 * The followings are the available model relations:
 * @property Precipitation $precipitation
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
			array('date_forecast, temp, humidity, pressure, wind_speed, wind_deg, precipitation_id, station_id, provider_id', 'required'),
			array('partofday, temp, humidity, pressure, wind_deg, precipitation_id, station_id, provider_id', 'numerical', 'integerOnly'=>true),
			array('wind_speed', 'numerical'),
            array('wind_deg', 'in', 'range' => [1,2,3,4,5,6,7,8,9]),
			// @todo Please remove those attributes that should not be searched.
			array('id, date_forecast, partofday, temp, humidity, pressure, wind_speed, wind_deg, precipitation_id, station_id, provider_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'precipitation' => array(self::BELONGS_TO, 'Precipitation', 'precipitation_id'),
			'station' => array(self::BELONGS_TO, 'Weatherstation', 'station_id'),
			'windDeg' => array(self::BELONGS_TO, 'WindDeg', 'wind_deg'),
			'provider' => array(self::BELONGS_TO, 'Provider', 'provider_id'),
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
			'humidity' => 'Humidity',
			'pressure' => 'Pressure',
			'wind_speed' => 'Wind Speed',
			'wind_deg' => 'Wind Deg',
			'precipitation_id' => 'Precipitation',
			'station_id' => 'Station',
			'provider_id' => 'Provider',
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
//		$criteria->compare('date_forecast',$this->date_forecast,true);
//		$criteria->compare('partofday',$this->partofday);
//		$criteria->compare('temp',$this->temp);
//		$criteria->compare('humidity',$this->humidity);
//		$criteria->compare('pressure',$this->pressure);
//		$criteria->compare('wind_speed',$this->wind_speed);
//		$criteria->compare('wind_deg',$this->wind_deg);
//		$criteria->compare('precipitation_id',$this->precipitation_id);
//		$criteria->compare('station_id',$this->station_id);
//		$criteria->compare('provider_id',$this->provider_id);
//        $criteria->compare('city',$this->station->city->name_en);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

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

    public static function findByCity($city){

    }
}
