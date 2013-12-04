<?php
namespace Base\Mvc;

class ModelsLoader
{
    private static $models = array();

    /**
     * Load models
     * @param str $model
     * @param str $module
     * @return object
     * @throws \Zend\Mvc\Exception\InvalidArgumentException
     */
    public static function load($model, $module) {
        if($model !== null){
            $module = ucfirst($module);
            $path = '\\'.$module.'\\Model\\'.$model;

            if(!isset(self::$models[$path])){                
                if(class_exists($path)){
                    self::$models[$path] = new $path();
                }else{
                    throw new \Zend\Mvc\Exception\InvalidArgumentException('Not found model '.$path);
                }
            }
                
            return self::$models[$path];
        }
        
        throw new \Zend\Mvc\Exception\InvalidArgumentException('Model name is null');
    }
}
