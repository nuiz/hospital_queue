<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 6/5/14
 * Time: 10:16 AM
 */
namespace Main;

class DB {
    private static $queEM = null;

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
                'password' => '111111',
                'dbname'   => 'que',
                'charset'  => 'utf8'
            ), $config);
        }
        return self::$queEM;
    }
}