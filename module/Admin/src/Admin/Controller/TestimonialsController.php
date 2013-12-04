<?php
namespace Admin\Controller;

class TestimonialsController extends \Admin\Base\Controller
{    
    public function indexAction(){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        $page = $this->p_int('page', 1);
        $ret = array(
            'testimonialsList' => $this->load('Testimonials', 'admin')->getList($page),
            'paginator' => $this->load('Testimonials', 'admin')->getPaginator($page)
        );
        
        return $this->view($ret);
    }
    
    public function editAction(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        if($this->p_int('edit-form') === 1){
            $params = array(
                'name' => $this->p_string('name'),
                'email' => $this->p_string('email'),
                'comment' => $this->p_string('comment'),
                'is_verified' => $this->p_select('is_verified', 'n', array('y','n'))
            );
            
            $this->load('Testimonials', 'admin')->edit($this->p_int('id'), $params);
            
            return $this->redirect()->toUrl(
                $this->easyUrl(array('action'=>'index'))
            );                 
        }else{            
            $ret = array(
                'getEdit' => $this->load('Testimonials', 'admin')->getOne($this->p_int('id'))
            );

            return $this->view($ret);
        }

    }
    
    public function statusAction(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        $this->load('Testimonials', 'admin')->setStatus($this->p_int('id'));
        
        return $this->redirect()->toUrl(
            $this->easyUrl(array('action'=>'index'))
        );
    }
    
    public function removeAction(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        $this->load('Testimonials', 'admin')->remove($this->p_int('id'));
        
        return $this->redirect()->toUrl(
            $this->easyUrl(array('action'=>'index'))
        );
    } 
}
