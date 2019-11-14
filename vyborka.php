<?php

	require_once('functions.php');
	
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
		   
		   $res = array();
		  
		   if($result_set->num_rows > 1) {
				while (($row = $result_set->fetch_assoc()) != false) {
			        $res[] = $row;
				}
			} else {
				$res = $result_set->fetch_row();
				return $res[0];
			} return $res;

		}

		public function setDateUsers($array)
		{

			if(!empty(is_array($array))) {
				$res = [];
				foreach ($array as $key => $value) {
					$res[] = $value['created_at'];
				} return $res;
			} return FALSE;

		}

		public function __destruct() {
		  if ($this->mysqli) $this->mysqli->close();
		}
    }

   $db = DataBase::getDB(); // Создаём объект базы данных
   $query = "SELECT COUNT(DISTINCT `user_id`) AS `user_id` FROM `logs`";
   $table = $db->select($query);
   echo 'Количество уникальный пользователей на сайте ' .$table;
   
   $query = "SELECT * FROM `logs`";
   $table = $db->select($query);

   echo '<br />Количество дней между двумя датами. ' .print_arr($db->setDateUsers($table));

   die;