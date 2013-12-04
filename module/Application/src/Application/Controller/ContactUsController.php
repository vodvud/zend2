<?php
namespace Application\Controller;

class ContactUsController extends \Application\Base\Controller
{
    public function __construct(){
        parent::__construct();
        
        $this->pushTitle('Контакты');
    }
    
    public function indexAction()
    {
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        $ret = array(
            'content' => $this->load('Pages', 'admin')->getOne(2)
        );
        
        return $this->view($ret);
    }
}
