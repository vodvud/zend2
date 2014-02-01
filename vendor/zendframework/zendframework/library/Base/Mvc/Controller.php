<?php
namespace Base\Mvc;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Filter\HtmlEntities;
use Base\Log;
use Base\Url\EasyUrl;
use Base\Storage;
use Base\Url\RequestParams;
use Base\Mvc\ModelsLoader;

/**
 * Base Controller
 */
class Controller extends AbstractActionController 
{        
    /**
     * Access only ajax or denied
     */
    public final function isAjax(){
        if(!$this->getRequest()->isXmlHttpRequest()){
            die('Access denied!');
        }   
    }
    
    /**
     * save log
     * @param str $str __CLASS__.'\\'.__FUNCTION__
     */
    public final function log($str){        
        Log::save($str);
    }
    
    /**
     * get storage
     * @return \Base\Storage
     */
    public final function storage(){
        return new Storage();
    }

    /**
     * View Constructor
     *
     * @param  null|array|Traversable $variables
     * @param  string $template
     */
    public final function view($variables = null, $template = null){  
        if($this->storage()->headTitle !== null){
            // add title
            if(is_array($this->storage()->headTitle)){
                foreach($this->storage()->headTitle as $title){
                    $this->headTitle($title);
                }
            }else{
                $this->headTitle($this->storage()->headTitle);
            }
            
            $this->storage()->headTitle = null;
        }
        
        if($this->storage()->viewVars !== null){
            // add vars
            if($variables === null){
                $variables = $this->storage()->viewVars;
            }else{
                $variables = array_merge($variables, $this->storage()->viewVars);
            }
            
            $this->storage()->viewVars = null;
        }
        
        $viewModel = new ViewModel($variables);
        
        if($template !== null){
            $viewModel->setTemplate($template);
        }
        
        return $viewModel;
    }
    
     /**
     * Json Constructor
     *
     * @param  null|array|Traversable $variables
     */
    public final function json($variables = null){
        return new JsonModel($variables);
    }
    
    /**
     * 
     * @param str $param
     * @param str $default
     * @return mixed
     */
    public final function getParams($param = null, $default = ''){
        $request = RequestParams::explode($this->params('get_http_request_string', ''));
        $query = $this->getRequest()->getQuery()->toArray();
        $post = $this->getRequest()->getPost()->toArray();
        $getParams = array();

        //merge params
        $getParams = $request + $query + $post;
        
        if($param === null){
            return $getParams;
        }else{
            return isset($getParams[$param]) ? $getParams[$param] : $default;
        }
    }
    
    /**
     * 
     * @param str $param
     * @param str $default
     * @return mixed
     */
    public final function getFiles($param = null){
        $getFiles = $_FILES;
        
        if($param === null){
            return $getFiles;
        }else{
            return isset($getFiles[$param]) ? $getFiles[$param] : null;
        }
    }
    
    /**
     * 
     * @param str $param
     * @param int $default
     * @return int
     */
    public final function p_int($param = null, $default = 0){
        $default = (int)$default;
        
        if($param === null){
            return $default;
        }else{
            return (int)$this->getParams($param, $default);
        }
    }
    
    /**
     * 
     * @param str $param
     * @param float $default
     * @param bool|int $decimals
     * @return float
     */
    public final function p_float($param = null, $default = 0, $decimals = null){
        $default = (float)str_replace(',', '.', $default);
        
        if($param === null){
            $ret = $default;
        }else{
            $val = $this->getParams($param, $default);
            $ret =  (float)str_replace(',', '.', $val);
        }

        if($decimals !== null){
            $ret = number_format($ret, $decimals, '.', '');
        }

        return $ret;
    }
    
    /**
     * 
     * @param str $param
     * @param float $default
     * @return string
     */
    public final function p_float_string($param = null, $default = 0){
        $default = (string)str_replace(',', '.', $default);
        
        if($param === null){
            return $default;
        }else{
            $val = $this->p_string($param, $default);
            return (string)str_replace(',', '.', $val);
        }
    }
    
    /**
     * 
     * @param str $param
     * @param str $default
     * @param bool $strip
     * @return str
     */
    public final function p_string($param = null, $default = '', $strip = true){
        $default = (string)$default;
        
        if($param === null){
            return $default;
        }else{
            $val = (string)$this->getParams($param, $default);
            
            if($strip){
                $htmlEntities = new HtmlEntities();
                $val = $htmlEntities->filter($val);
            }
            
            return $val;
        }
    }
    
    /**
     * 
     * @param str $param
     * @param array $default
     * @return array
     */
    public final function p_array($param = null, $default = array()){
        $default = (array)$default;
        
        if($param === null){
            return $default;
        }else{
            return (array)$this->getParams($param, $default);
        }
    }
    
    /**
     * 
     * @param str $param
     * @param object $default
     * @return object
     */
    public final function p_object($param = null, $default = null){
        $default = (object)$default;
        
        if($param === null){
            return $default;
        }else{
            return (object)$this->getParams($param, $default);
        }
    }
    
    /**
     * 
     * @param str $param
     * @param str $default
     * @param array $array
     * @return str
     */
    public final function p_select($param = null, $default = '', $array = array()){        
        $val =$this->p_string($param, $default);

        if(in_array($val, $array)){
            return $val;
        }else{
            return $default;
        }
    }
    
    /**
     * Return controller, action, module etc. 
     * @param str|null $name (module|controller|action|request|query|actionFound)
     * @return array|str|null
     * 
     * @see \Base\Url\RouteNamesLoader
     */
    public final function routeNames($name = null){
        if($name === null){
            return $this->storage()->routeNames;
        }else{
            return isset($this->storage()->routeNames[$name]) ? $this->storage()->routeNames[$name] : null;
        }
    }
    
    /**
     * 
     * @param array $params
     * @param array $query
     * @param bool $reuseMatchedParams Whether to reuse matched parameters
     * @return str
     */
    public final function easyUrl($params = array(), $query = array(), $reuseMatchedParams = false){
        $data = EasyUrl::url((array)$params, (array)$query, (array)$this->routeNames(), (bool)$reuseMatchedParams);
        
        return EasyUrl::decode(
            $this->url()
                 ->fromRoute(
                         $data['defaultRouter'], 
                         $data['urlParams'], 
                         $data['urlQuery']
                 )
        );
    }
    
    /**
     * Add script
     * @param string $file
     */
    public final function addHeadScript($file = null){
        if($file !== null){
            if($this->storage()->addHeadScripts === null){
                $this->storage()->addHeadScripts = array();
            }
            
            $addHeadScripts = $this->storage()->addHeadScripts;
            if(!in_array($file, $addHeadScripts)){                
                array_push($addHeadScripts, $file);
                $this->storage()->addHeadScripts = $addHeadScripts;
            }
        }
    }
    
    /**
     * Add css
     * @param string $file
     */
    public final function addHeadLink($file = null){
        if($file !== null){
            if($this->storage()->addHeadLinks === null){
                $this->storage()->addHeadLinks = array();
            }
            
            $addHeadLinks = $this->storage()->addHeadLinks;
            if(!in_array($file, $addHeadLinks)){                
                array_push($addHeadLinks, $file);
                $this->storage()->addHeadLinks = $addHeadLinks;
            }
        }
    }
    
    /**
     * Set Title
     * @param str $title
     */
    public final function headTitle($title = null){
        if($title !== null){            
            $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');            
            $renderer->headTitle($title);
        }
    }
    
    /**
     * Push Title
     * @param str $title
     */
    public final function pushTitle($title = null){
        if($title !== null){ 
            if($this->storage()->headTitle === null){
                $this->storage()->headTitle = array();
            }
            $headTitle = $this->storage()->headTitle;
            array_unshift($headTitle, $title);
            
            $this->storage()->headTitle = $headTitle;
        }
    }
    
    /**
     * Push view vars
     * @param array $array array($param => $val)
     */
    public final function pushView($array = array()){
        $array = (array)$array;
        
        if($this->storage()->viewVars === null){
            $this->storage()->viewVars = $array;
        }else{            
            $vars = $this->storage()->viewVars;
            $this->storage()->viewVars = array_merge($vars, $array);
        }
    }
    
    /**
     * get view vars
     * @param str $key
     * @return array|null
     */
    public final function getView($key = null){   
        $ret = null;
        
        if($this->storage()->viewVars !== null){           
            $vars = $this->storage()->viewVars;
            if(isset($vars[$key])){
                $ret = $vars[$key];
            }
        }
        
        return $ret;
    }
    
    /**
     * Load models
     * @param str $model
     * @param str $module
     * @return object
     * @throws \Zend\Mvc\Exception\InvalidArgumentException
     */
    public final function load($model = null, $module = 'application') {
        return ModelsLoader::load($model, $module);
    }
    
    /**
     * Debuger
     * @param mixed $obj
     */
    public final function debug($obj){        
        \Zend\Debug\Debug::dump($obj);
    }
        
}