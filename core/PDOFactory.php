<?php
namespace Core;

use Symfony\Component\Yaml\Yaml;

class PDOFactory
{
    /**
     * This methods return a PDO object representing a MySQL connexion.
     * 
     * @return PDO
     */
    public static function getMysqlConnexion()
    {
        $config = Yaml::parseFile(__DIR__.'/../config/database.yaml');

        $db = new \PDO(
            'mysql:host='.$config['host'].';
            dbname='.$config['name'].';charset=utf8',
            $config['user'],
            $config['password']
        );
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}
