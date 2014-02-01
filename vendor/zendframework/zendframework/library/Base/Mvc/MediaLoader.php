<?php
namespace Base\Mvc;

use Zend\View\Helper\AbstractHelper;
use Base\Storage;

class MediaLoader extends AbstractHelper 
{
    private static $dir = 'medialoader';

    public function __invoke(){
        $view = $this->getView();
        $storage = new Storage();
        
        $params = (object)array(
            'basePath' => $view->basePath(),
            'routeNames' => $storage->routeNames,
            'css' => $view->headLink(),
            'js' => $view->headScript(),
            'addCSS' => $storage->addHeadLinks,
            'addJS' => $storage->addHeadScripts,
        );

        self::loadCSS($params);          
        self::loadJS($params); 

        $this->setView($view);
    }
	
	/**
	 * 
	 * @param object &$params
	 */
    private static function loadCSS(&$params){
        $moduleCSS = self::getModuleFileName($params->routeNames, 'css');
        if(self::checkFile($moduleCSS, $params->routeNames)){
            $params->css->appendStylesheet($params->basePath.$moduleCSS);  
        }
        $controllerCSS = self::getControllerFileName($params->routeNames, 'css');
        if(self::checkFile($controllerCSS, $params->routeNames)){
            $params->css->appendStylesheet($params->basePath.$controllerCSS);  
        }
        $actionCSS = self::getActionFileName($params->routeNames, 'css');
        if(self::checkFile($actionCSS, $params->routeNames)){
            $params->css->appendStylesheet($params->basePath.$actionCSS);  
        }
        
        if(is_array($params->addCSS)){
            foreach($params->addCSS as $addCSS){
                if(self::checkFile($addCSS, $params->routeNames)){
                    $params->css->appendStylesheet($params->basePath.$addCSS);
                }
            }
        }
    }
    
	/**
	 * 
	 * @param object &$params
	 */
    private static function loadJS(&$params){
        $moduleJS = self::getModuleFileName($params->routeNames, 'js');
        if(self::checkFile($moduleJS, $params->routeNames)){
            $params->js->appendFile($params->basePath.$moduleJS);  
        }
        $controllerJS = self::getControllerFileName($params->routeNames, 'js');
        if(self::checkFile($controllerJS, $params->routeNames)){
            $params->js->appendFile($params->basePath.$controllerJS);  
        }
        $actionJS = self::getActionFileName($params->routeNames, 'js');
        if(self::checkFile($actionJS, $params->routeNames)){
            $params->js->appendFile($params->basePath.$actionJS);  
        }
        
        if(is_array($params->addJS)){
            foreach($params->addJS as $addJS){
                if(self::checkFile($addJS, $params->routeNames)){
                    $params->js->appendFile($params->basePath.$addJS);
                }
            }
        }
    }

    /**
     * 
     * @param array $routeNames
     * @param str $ext
     * @return str
     */
    private static function getModuleFileName($routeNames, $ext) {
        return '/'.$ext.'/'.self::$dir.'/'.$routeNames['module'].'.'.$ext;
    }

    /**
     * 
     * @param array $routeNames
     * @param str $ext
     * @return str
     */
    private static function getControllerFileName($routeNames, $ext) {
        return '/'.$ext.'/'.self::$dir.'/'.$routeNames['module'].'/'.$routeNames['controller'].'.'.$ext;
    }

    /**
     * 
     * @param array $routeNames
     * @param str $ext
     * @return str
     */
    private static function getActionFileName($routeNames, $ext) {
        return '/'.$ext.'/'.self::$dir.'/'.$routeNames['module'].'/'.$routeNames['controller'].'/'.$routeNames['action'].'.'.$ext;
    }

    /**
     *
     * @param string $fileName
     * @param array $routeNames
     * @return bool
     */
    private static function checkFile($fileName, $routeNames) {
        $dir = dirname(PUBLIC_PATH.$fileName);
        $file = PUBLIC_PATH.$fileName;

        if(is_file($file) == false && $routeNames['actionFound'] == true && $routeNames['controller'] != 'image'){
            $url = $fileName;
            $url = str_replace('/css/'.self::$dir.'/', '', $url);
            $url = str_replace('.css', '', $url);
            $url = str_replace('/js/'.self::$dir.'/', '', $url);
            $url = str_replace('.js', '', $url);
            
            $exp = explode('/', $url);
            
            if(sizeof($exp) > 0){                
                $str = '/**'."\n"; 
                $str .= ' * Use to URL:'."\n"; 
                if(isset($exp[0])){
                    $list = '';
                    
                    /* module */
                    $module = ($exp[0] == 'application') ? '/' : '/'.$exp[0].'/';
                    $list = ' *  '.$module.'*'."\n";
                    
                    if(isset($exp[1])){
                        /* controller */
                        $list = ($exp[1] == 'index' ? ' *  '.$module."\n" : '').
                                ' *  '.$module.$exp[1]."\n".
                                ' *  '.$module.$exp[1].'/*'."\n";
                        
                        if(isset($exp[2])){
                            /* action */
                            $list = ' *  '.$module.$exp[1].'/'.$exp[2]."\n".
                                    ' *  '.$module.$exp[1].'/'.$exp[2].'/*'."\n";
                        }
                    }
                    
                    $str .= $list;
                }
                $str .= ' */'."\n\n"; 
                
                if(is_dir($dir) == false){
                    mkdir($dir, 0777, true);
                }
                file_put_contents($file, $str);
            }
            
        }
        
        return is_file($file);
    }
}