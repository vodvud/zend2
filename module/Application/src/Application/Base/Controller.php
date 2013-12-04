<?php
namespace Application\Base;

use Zend\Session\Container as SessionContainer;
use Zend\Mvc\MvcEvent;

class Controller extends \Base\Mvc\Controller
{
    protected $session = null;
    
    /**
     * Init session
     */
    public function __construct(){
        $this->session = new SessionContainer('application');
    }
    
    /**
     * Check session
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onDispatch(MvcEvent $e){
        if($this->session === null){
            return new \Zend\Session\Exception\RuntimeException('Can\'t create session');
        }

        return parent::onDispatch($e);
    }

    /**
     * Return $this->session->auth['id']
     * @return null|int
     */
    protected function getUserId(){
        return isset($_SESSION['profile']->auth['id']) ? $_SESSION['profile']->auth['id'] : 0;
    }
}