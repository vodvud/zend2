<?php
namespace Admin\Controller;

class BlogController extends \Admin\Base\Controller
{    
    public function indexAction(){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        $page = $this->p_int('page', 1);
        $ret = array(
            'blogList' => $this->load('Blog', 'admin')->getList($page),
            'paginator' => $this->load('Blog', 'admin')->getPaginator($page)
        );
        
        return $this->view($ret);
    }
    
    
    public function addAction(){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        if($this->p_int('add-form') === 1){
            $params = array(
                'title' => $this->p_string('title'),
                'description' => $this->p_string('description', '', false)
            );

            $img = $this->getFiles('img');
            
            $this->load('Blog', 'admin')->add($params, $img);
            
            return $this->redirect()->toUrl(
                $this->easyUrl(array('action'=>'index'))
            );                 
        }else{            
            $ret = array();

            return $this->view($ret);
        }
    }
    
    public function editAction(){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        if($this->p_int('edit-form') === 1){
            $params = array(
                'title' => $this->p_string('title'),
                'description' => $this->p_string('description', '', false)
            );
            
            $img = $this->getFiles('img');
            
            $this->load('Blog', 'admin')->edit($this->p_int('id'), $params, $img);
            
            return $this->redirect()->toUrl(
                $this->easyUrl(array('action'=>'index'))
            );                 
        }else{            
            $ret = array(
                'getEdit' => $this->load('Blog', 'admin')->getOne($this->p_int('id'))
            );

            return $this->view($ret);
        }
    } 
    
    public function removeAction(){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
            
        $this->load('Blog', 'admin')->remove($this->p_int('id'));

        return $this->redirect()->toUrl(
            $this->easyUrl(array('action'=>'index'))
        );                 
    }
    
    public function validatorAction(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        $this->isAjax();
        
        $params = array(
            'title' => $this->p_string('title'),
            'description' => $this->p_string('description', '', false)
        );
        
        $error = array();
        
        $validItem = $this->load('Validator')->validStringLength($params['title'], 2, 250);
        if($validItem == false){
            $error['title'] = $validItem;
        }
        
        $validItem = $this->load('Validator')->validStringLength($params['description'], 10, 20000);
        if($validItem == false){
            $error['description'] = $validItem;
        }
        
        $ret = array(
            'status' => (sizeof($error) > 0 ? false : true),
            'error' => $error
        );
        
        return $this->json($ret);
    }
}
