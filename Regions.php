<?php
namespace Regions;
/**
 * Серверная реализация подготовки данных для отображания на карте Яндекс.Регионы в разной окраске в зависимости от соответствующих значений в передаваемом массиве. Поддерживаются как отрицательные, так и положительные значения. Формат принимаемого массива: ключи - iso-код региона, значения - цифры. Примеры основаны на iso-кодах российских регионов.
 * 
 * @version 0.2
 * @link http://github.com/Zoviet/Regions
 * @author Zoviet (Alexandr Pavlov  / @Zoviet)
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright Alexandr Pavlov
 * @site http://opendata.org.ru/
 */

class Regions {
	
	/**
	* @var array Базовые цвета палитры для окраски карты
    */	
	public $colors = array(); 
	
	/**
	* @var string Версия этой библиотеки
    */
	public $version; 
	
	/**
	* @var array Массив iso-кодов российских регионов из папки iso. Там же другие варианты iso-кодов: sql, json, csv
    */
	public $iso = array(); 
	
	/**
	* @var array Ошибки исключений, выбрасываемых библиотекой
    */
	private $errors; 
	
	// Methods
    // ===================================================================================
			
	/**
    * Constructor
    */   
	public function __construct()
    {     
		$this->version = 'PHP Regions: Under development';
		
		require(__DIR__.'/iso/iso.php'); //подключаем массив iso-кодов российских регионов. Может быть заменен на выборку из БД.
		
		$this->errors = array(
            'ERR00' => 'Неподдерживаемый тип данных.',
            'ERR01' => 'Передан не массив.',
    		'ERR02' => 'Массив должен быть одномерным.',    		
    		'ERR03' => 'Ключами массива должны быть только iso-коды регионов',    		
        );        
        		
		$default_colors = array(
			'green'=>array(
				'color'=>'#00FF00', 
				'max'=> 'e5' 
				),
			'red'=>array(
				'color'=>'#FF0000',
				'max'=>'e5'
				)
		); 
						
		$this->set_defaults($default_colors); //Используем палитру по умолчанию 
	}
	
	  // assistive methods
    
    //===============================================================================================
    
    /**
    * Set defaults
    * 
    * @param array Принимает массив значений для цветов отрицательных и положительных чисел в формате массива {'green','red'}, каждый элемент которого - это массив из начального значения цвета в HEX (#XXXXXX) ('color') и максимального приращения по каждому из трех цветовых каналов (RGB) в HEX (например, 'E2') ('max'). Таким образом формируется диапазон окраски.   
    * 
    * @return NONE
    */	
	public function set_defaults($colours) 
	{
		$this->colors = $colours;	
	}						
			
	private function array_test($array) //Проверка размерности массива
	{
		$test = TRUE;
		foreach ($array as $value) {
			if (is_array($value)) {
				$test = FALSE;
			}
		}
		return $test;
	}
	
	function array_nulled(array $array) //обнуление значений массива с сохранением ключей
	{
		return array_map(function(){return 0;},$array);
	}
	
	function array_negative(array $array) //выделение из массива части с отрицательными значениями
	{
		return array_filter($array, function($var) {return (bool)(abs($var)!==$var);});
	}
	
	function array_positive(array $array) //выделение из массива части с положительными значениями
	{
		return array_filter($array, function($var) {return (bool)(abs($var)==$var);});
	}
	
	// main methods
    
    //===============================================================================================
    
      /**
    * test - Проверка исходного передаваемого массива и приведение его в соответствие с особенностями Яндекс Регионов. Массив должен быть в формате iso-код региона->значение. Особенность api Яндекс Регионов в том, что карты не всегда корректно работают, если передается неполный массив регионов. Поэтому, если массив не полный, мы его дополняем нулевыми значениями до полного "комплекта" регионов.
    */	    
    public function test($data) 
	{	
		static $series;	
		try {
			if (!is_array($data)) {		
				throw new \Exception($this->version.': '.$this->errors['ERR00'].':'.$this->errors['ERR01']);
			} else {			
				$recount = count($data,COUNT_RECURSIVE);				
				if (count($data)!==$recount or $this->array_test===FALSE) {
					throw new \Exception($this->version.': '.$this->errors['ERR00'].':'.$this->errors['ERR02']);
				} else {
					$keys = array_keys($data);
					$isos = array_column($this->iso,'iso');
					if (count(array_diff($keys,$isos))>0) {
						throw new \Exception($this->version.': '.$this->errors['ERR00'].':'.$this->errors['ERR03']);
					} else {
						$series = $this->fuller($data);
					}
				}						
			}
		} catch (\Exception $e) {
			echo $e->getMessage();
			error_log($e->getMessage(), 0);
			$series = FALSE;
		} 
		return $series;
	}
    
     /**
    * datacolours - Заменяет значения массива на их цветовые эквиваленты из палитры, учитывает случаи наличия только отрицательных или положительных значений
    */	    
	private function datacolours($data,$color,$step) { 
		$currentcolor= ($step>0) ? hexdec($this->colors[$color]['max']) : 255-hexdec($this->colors[$color]['max']);		
		while ($ckey = key($data) !== null) { 
			$value = current($data); 
			$now=key($data);       
			$nextvalue = next($data);  					    																
			$currentcolor=($value!==$nextvalue) ? $currentcolor-$step : $currentcolor;						
			$hexcolor=(strlen(dechex(255-$currentcolor))>1) ? dechex(255-$currentcolor) : '0'.dechex(255-$currentcolor);
			$data[$now]= str_replace('00',$hexcolor,$this->colors[$color]['color']);						
		}
		return ($data); 
	}
	
	 /**
    * step - Расчет шага изменения градиента в зависимости от количества и разброса уникальных параметров в передаваемом массиве
    */	
	private function step($data,$color) { 		
			return intdiv(hexdec($this->colors[$color]['max']),count(array_unique($data)));	
	}
	
	 /**
    * fuller - Метод, заполняющий массив значений нулями для тех регионов, которых в нем изначально не было
    */	
	private function fuller($data) { 				
			$isos = array_column($this->iso,'iso'); 	
			$isos = $this->array_nulled(array_flip($isos));
			return array_merge($isos,$data);
	}
	
	 /**
    * colouring - метод, возвращающий массив цветов, соответсвующих значениям, - в json и нет
    * 
    * @param array Исходный массив   
    * @param bool Если TRUE, то возвращает json, по умолчанию (FALSE) - массив
    * 
    * @return Массив цветов или json
    */	
	public function colouring (array $data,bool $json=FALSE) { 	
		$data = $this->test($data);		
		asort($data);										
		$red = $this->array_negative($data); //выделяем отрицательные 				
		$green = (count($red)>0) ? $this->array_positive($data) : $this->array_positive(array_reverse($data));//и положительные части исходного массива								
		$redstep = $this->step($red,'red');//шаг обхода массива отрицательных значений
		$greenstep = $this->step($green,'green');//шаг обхода массива положительных значений						
		$greenstep = ($redstep!==0) ? 0-$greenstep : $greenstep; //инвертируем логику представления цветов для случая наличия и отрицательных и положительных значений				
		$colors = ($json===TRUE) ? json_encode(array_merge($this->datacolours($red,'red',$redstep), $this->datacolours($green,'green',$greenstep)),JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK) : array_merge($this->datacolours($red,'red',$redstep), $this->datacolours($green,'green',$greenstep));
		return $colors;
	}
	
	/**
    * gradient - Формирование шкалы градиента для легенды карты
    * 
    * @param array Массив цветов  
    * @param int Количество оттенков в шкале градиента
    * 
    * @return Массив цветов для отображения градиента в легенде
    */		
	public function gradient ($data,$max=15) { //метод, возвращающий шкалу значений (градиент значений) с шагом по умолчанию 15
		$data = (is_array($data)) ? $data : (array)json_decode($data); //работаем с массивами и в json и без
		$max = (count(array_unique($data))<$max) ? count(array_unique($data)) : $max;		
		foreach (array_chunk(array_unique($data), ceil(count(array_unique($data))/$max)) as $color) {		
			 $gradient[]=$color[0];
		}		
		return $gradient;
	}	
	
	/**
    * map - Объект данных для карты на основании исходного массива
    * 
    * @param array Исходный массив iso-код региона->значение   
    * 
    * @return object Возвращает объект: colors - массив цветов по регионам в json; gradient - массив цветов для отображения легенды карты; data - исходный массив, дополненный до всех регионов в json
    */	
	public function map($data) { //подготовка всех необходимых данных для вывода на карту	
		$colors = $this->colouring($data);				
		$this->mapdata=new \stdClass();
		$this->mapdata->colors = json_encode($colors);
		$this->mapdata->gradient = $this->gradient($colors);
		$this->mapdata->data = json_encode($data);
		return $this->mapdata;
	}
	
}
