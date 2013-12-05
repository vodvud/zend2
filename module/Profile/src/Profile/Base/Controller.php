<?php
namespace Profile\Base;

use Zend\Session\Container as SessionContainer;
use Zend\Mvc\MvcEvent;

class Controller extends \Base\Mvc\Controller
{
    protected $session = null;    
    /**
     * Init session
     */
    public function __construct(){
        $this->session = new SessionContainer('profile');
        
        $this->pushTitle('Личный кабинет');
    }
    
    /**
     * Check for login
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onDispatch(MvcEvent $e){
        if($this->session === null){
            return new \Zend\Session\Exception\RuntimeException('Can\'t create session');
        }
        
        if(!isset($this->session->auth['id']) && 
            $this->routeNames('controller') != 'login' && 
            $this->routeNames('controller') != 'registration' && 
            $this->routeNames('controller') != 'forgot' && 
            $this->routeNames('controller') != 'error'
           ){
            return $this->redirect()
                         ->toUrl(
                             $this->easyUrl(array('controller' => 'error'))
                         );
        }

        return parent::onDispatch($e);
    }
    
    /**
     * Return $this->session->auth['id']
     * @return null|int
     */
    protected function getUserId(){
        return isset($this->session->auth['id']) ? $this->session->auth['id'] : 0;
    }
    
    /**
     * Return $this->session->auth['username']
     * @return null|string
     */
    protected function getUserNаme(){
        return isset($this->session->auth['username']) ? $this->session->auth['username'] : null;
    }
    
    /**
     * @param int $id
     */
    protected function setUserId($id = 0){
        if((int)$id > 0){
            $this->setAuth();
            $this->session->auth['id'] = (int)$id;
        }
    }
    
    /**
     * @param string $username
     */
    protected function setUserNаme($username = null){
        if($username !== null){
            $this->setAuth();
            $this->session->auth['username'] = $username;
        }
    }
    
    /**
     * Set auth
     */
    private function setAuth(){
        if(!isset($this->session->auth)){
            $this->session->auth = array();
        }
    }
}