<?php
namespace Application\Controller;

class BlogController extends \Application\Base\Controller
{
    public function __construct(){
        parent::__construct();
        
        $this->pushTitle('Блог');
    }
    
    public function indexAction()
    {
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        $ret = array();
        $page = $this->p_int('page', 1);
        $ret['blogItems'] = $this->load('Blog')->getAll($page);
        $ret['paginator'] = $this->load('Blog')->getPaginator($page);
        
        return $this->view($ret);
    }

    public function postAction()
    {
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        $post = $this->p_int('id');
        $ret = array('post' => $this->load('Blog')->getOnePost($post));

        return $this->view($ret);

    }
}
