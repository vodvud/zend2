<?php
namespace Base\Mvc;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Filter\HtmlEntities;
use Base\Url\EasyUrl;
use Base\Url\RequestParams;
use Base\Func;

/**
 * Base Controller
 */
class Controller extends AbstractActionController
{
    // Include default methods  (as of PHP 5.4.0)
    use Func\TraitDefault;
    
    /**
     * Access only ajax or denied
     */
    public final function isAjax(){
        if(!$this->getRequest()->isXmlHttpRequest()){
            die('Access denied!');
        }   
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
     * Get File
     * @param str $param
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
     * Get integer
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
     * Get float
     * @param str $param
     * @param float $default
     * @param int $decimals
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
     * Get float string
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
     * Get string
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
     * Get array
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
     * Get array and convert in object
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
     * Get select
     * @param str $param
     * @param str $default
     * @param array $array array with variants
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
     * URL Constructor
     * @param array $params
     * @param array $query
     * @param bool $reuseMatchedParams Whether to reuse matched parameters
     * @return str
     */
    public final function easyUrl($params = array(), $query = array(), $reuseMatchedParams = false){
        $data = EasyUrl::url((array)$params, (array)$query, (array)$this->routeNames(), (bool)$reuseMatchedParams);
        
        return $this->basePath().EasyUrl::decode(
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
     * @param string $file File source
     * @param bollean $append Add append or prepend on section medialoader
     */
    public final function addHeadScript($file = null, $append = true){
        if($file !== null){
            $addPriority = ($append === true) ? 'addHeadScripts_append' : 'addHeadScripts_prepend';
            
            if($this->storage()->$addPriority === null){
                $this->storage()->$addPriority = array();
            }
            
            $array = $this->storage()->$addPriority;
            if(!in_array($file, $array)){                
                array_push($array, $file);
                $this->storage()->$addPriority = $array;
            }
        }
    }
    
    /**
     * Add css
     * @param string $file File source
     * @param bollean $append Add append or prepend on section medialoader
     */
    public final function addHeadLink($file = null, $append = true){
        if($file !== null){
            $addPriority = ($append === true) ? 'addHeadLinks_append' : 'addHeadLinks_prepend';
            
            if($this->storage()->$addPriority === null){
                $this->storage()->$addPriority = array();
            }
            
            $array = $this->storage()->$addPriority;
            if(!in_array($file, $array)){                
                array_push($array, $file);
                $this->storage()->$addPriority = $array;
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
}