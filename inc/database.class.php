<?php
	include "constants.inc.php";
	class Database
	{
		private static $_instance = null;
		public static function getInstance()
		{
			if (!self::$_instance)
			{
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		private function __clone(){}
		private $_connection = null;
		private function __construct()
		{
			$this->_connection = mysql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD);
			if ($this->_connection)
			{
				mysql_select_db(DB_NAME);
			}
		}
		
		function query($sql)
		{
			$result = mysql_query($sql);
			return $result;
		}
	}
?>