<?php
namespace Application\Controller;

class IndexController extends \Application\Base\Controller
{
    public function __construct(){
        parent::__construct();

        $this->pushTitle('Главная');
    }

    public function indexAction(){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        $ret = array(
            
        );
        
        return $this->view($ret);
    }
}
