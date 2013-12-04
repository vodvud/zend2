<?php
namespace Profile\Controller;

class IndexController extends \Profile\Base\Controller
{  
    public function __construct(){
        parent::__construct();
        
        $this->pushTitle('Управление объявлениями');
    }
    
    public function indexAction(){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        $userId = $this->getUserId();

        $ret = array(
            
        );
        
        return $this->view($ret);
    }    
}
