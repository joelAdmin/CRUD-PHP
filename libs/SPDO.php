<?php
class SPDO extends PDO 
{
	private static $instance = null;

	public function __construct() 
	{
		$config = Config::singleton();
		parent::__construct('mysql:host=' . $config->get('dbhost') . ';dbname=' . $config->get('dbname'), $config->get('dbuser'), $config->get('dbpass'), array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
		//mysql_set_charset('utf8');
	}

	public static function singleton() 
	{
		if( self::$instance == null ) 
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	/*
	Public function __destruct()
	{
		$config = Config::singleton();
		parent::__destruct('mysql:host=' . $config->get('dbhost') . ';dbname=' . $config->get('dbname'), $config->get('dbuser'), $config->get('dbpass'));
    }*/
}
?>
