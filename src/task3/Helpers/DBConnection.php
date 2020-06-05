<?php

namespace Task3\Helpers;

use PDO;
use PDOException;

class DBConnection
{
    protected static $instance;

    protected function __construct() {}

    public static function getConnection() {

        if(empty(self::$instance)) {

            $dbConf = [
                "db_host" => "mysql",
                "db_port" => "3306",
                "db_user" => "test",
                "db_pass" => "test",
                "db_name" => "test",
                "db_charset" => "UTF-8"
            ];

            try {
                self::$instance = new PDO("mysql:host=".$dbConf['db_host'].';port='.$dbConf['db_port'].';dbname='.$dbConf['db_name'], $dbConf['db_user'], $dbConf['db_pass']);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
                self::$instance->query('SET NAMES utf8');
                self::$instance->query('SET CHARACTER SET utf8');

            } catch(PDOException $error) {
                echo $error->getMessage();
            }
        }

        return self::$instance;
    }
}