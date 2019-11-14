<?php
	
	class DataBase {

		private static $db = null;
	  	private $mysqli;

		public static function getDB() {
		   if (self::$db == null) self::$db = new DataBase();
		   return self::$db;
		}
  
		private function __construct() {
		   $this->mysqli = new mysqli("localhost", "root", "", "country_multilingual");
		   $this->mysqli->query("SET lc_time_names = 'ru_RU'");
		   $this->mysqli->query("SET NAMES 'utf8'");
		}

		public function select($query) {
		   $result_set = $this->mysqli->query($query);
		   if (!$result_set) return false;
		   return $this->setToArray($result_set);
		}

		private function setToArray($result_set) {
		   while (($row = $result_set->fetch_assoc()) != false) {
	            $data['items'][] = [[
	                "id" => $row['country_numeric_code'],
	                "lang" => $row['lang'],
	                "name" => $row['country_name'],
	                "lang_name" => $row['lang_name'],
	                "country_alpha2_code" => $row['country_alpha2_code'],
	                "country_alpha3_code" => $row['country_alpha3_code']],
	                "data" => ["status" => 200, "code" => 0, "message" => "OK"
	            ]];
		    }
		    return json_encode($data);
		}

		public function __destruct() {
		  if ($this->mysqli) $this->mysqli->close();
		}
    }

   $db = DataBase::getDB(); // Создаём объект базы данных
   abs( (int)$country_numeric_code = 1 );
   $query = "SELECT * FROM `country_multilingual` WHERE `country_numeric_code` = $country_numeric_code";
   $table = $db->select($query);
   echo $table;
   die;