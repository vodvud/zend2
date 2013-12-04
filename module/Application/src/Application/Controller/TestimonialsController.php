<?php
namespace Application\Controller;

use Zend\Debug\Debug;

class TestimonialsController extends \Application\Base\Controller
{
    public function __construct(){
        parent::__construct();
        
        $this->pushTitle('Отзывы');
    }

    public function indexAction()
    {
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        $page = $this->p_int('page', 1);
        $ret = array(
            'commentItems' => $this->load('Testimonials')->getAll($page),
            'paginator' => $this->load('Testimonials')->getPaginator($page)
        );

        return $this->view($ret, null, 'application/testimonials/index.phtml');
    }

    public function addAction(){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        $this->isAjax();

        $params = array(
            'name' => $this->p_string('name'),
            'email' => $this->p_string('email'),
            'comment' => $this->p_string('comment')
        );

        $car_params = array(
            'car_id' => $this->p_int('car_id'),
            'cat_url' => $this->p_string('cat_url'),
            'rate' => $this->p_int('rate')
        );

        $ret = array('status' => false);
        $check = $this->check($params);
        if($check['status'] == true){
            $ret['status'] = $this->load('Testimonials')->add($params, $car_params);
        }
        
        return $this->json($ret);
    }

    public function listAction(){
        $this->log(__CLASS__.'\\'.__FUNCTION__);

        return $this->indexAction();
    }

    public function allAction(){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        $ret = array(            
            'commentItems' => $this->load('Testimonials')->getAll(),
            'paginator' => null
        );

        return $this->view($ret, null, 'application/testimonials/index.phtml');
    }
    
    public function validatorAction(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        $this->isAjax();
        
        $params = array(
            'name' => $this->p_string('name'),
            'email' => $this->p_string('email'),
            'comment' => $this->p_string('comment')
        );
        
        $ret = $this->check($params);
        
        return $this->json($ret);
    }
    
    /**
     * @param array $params
     * @return array
     */
    private function check($params = array()){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $error = array();
        
        $validItem = $this->load('Validator')->validStringLength($params['name'], 2, 150);
        if($validItem == false){
            $error['name'] = $validItem;
        }
        
        $validItem = $this->load('Validator')->validStringLength($params['email'], 5, 200);
        if($validItem == false){
            $error['email'] = $validItem;
        }else{
            $validItem = $this->load('Validator')->validEmail($params['email']);
            if($validItem == false){
                $error['email'] = $validItem;
            }
        }
        
        $validItem = $this->load('Validator')->validStringLength($params['comment'], 10, 1000);
        if($validItem == false){
            $error['comment'] = $validItem;
        }
        
        $ret = array(
            'status' => (sizeof($error) > 0 ? false : true),
            'error' => $error
        );
        
        return $ret;
    }
}