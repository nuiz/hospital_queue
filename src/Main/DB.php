<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 6/5/14
 * Time: 10:16 AM
 */
namespace Main;

class DB {
    private static $queEM = null, $hosEM;

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public static function queEM()
    {
        if(is_null(self::$queEM)){
            $paths = array('src/Main/Entity/Que');
            $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, true);
            self::$queEM = \Doctrine\ORM\EntityManager::create(array(
                'driver'   => 'pdo_mysql',
                'user'     => 'root',
                'password' => '',
                'dbname'   => 'que',
                'charset'  => 'utf8',
                'driverOptions' => array(
                    1002=>'SET NAMES utf8'
                )
            ), $config);
        }
        return self::$queEM;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public static function hosEM()
    {
        if(is_null(self::$hosEM)){
            $paths = array('src/Main/Entity/Hos');
            $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, true);
//            self::$hosEM = \Doctrine\ORM\EntityManager::create(array(
//                'driver'   => 'pdo_mysql',
//                'host'     => '192.168.100.250',
//                'user'     => 'sa',
//                'password' => 'sa',
//                'dbname'   => 'ud12418',
//                'charset'  => 'utf8',
//                'driverOptions' => array(
//                    1002=>'SET NAMES utf8'
//                )
//            ), $config);
            self::$hosEM = \Doctrine\ORM\EntityManager::create(array(
                'driver'   => 'pdo_mysql',
                'user'     => 'root',
                'password' => '',
                'dbname'   => 'hos',
                'charset'  => 'utf8',
                'driverOptions' => array(
                    1002=>'SET NAMES utf8'
                )
            ), $config);

            self::$hosEM->createQuery();
        }
        return self::$hosEM;
    }
}