<?php
namespace Profile\Controller;

class RegistrationController extends \Profile\Base\Controller
{    
    public function indexAction(){
        $this->log(__CLASS__.'\\'.__FUNCTION__); 
        
        if(isset($this->session->auth['id'])){
            return $this->redirect()
                         ->toUrl(
                             $this->easyUrl(array())
                         );
        }
        
        if($this->p_int('registration-form') === 1){
            $params = array(
                'username' => $this->p_string('username'),
                'password' => $this->p_string('password'),
                'retry_password' => $this->p_string('retry_password')
            );
            
            $user = null;
            $check = $this->check($params);
            if($check['status'] == true){
                $user = $this->load('Registration', 'profile')->authUser($params);
            }
        
            return $this->setAuth($user);
        }
        
        return $this->redirect()
                     ->toUrl(
                         $this->easyUrl(array('controller' => 'error', 'action' => 'registration'))
                     );
    }
    
    /**
     * Set login
     */
    private function setAuth($user = null){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        if(isset($user['id']) && isset($user['username'])){            
            $this->session->auth = array(
                'id' => (int)$user['id'],
                'username' => (string)$user['username']
            );
            
            return $this->redirect()
                         ->toUrl(
                             $this->easyUrl(array('controller' => 'contacts'))
                         );
        }else{
            return $this->redirect()
                         ->toUrl(
                             $this->easyUrl(array('controller' => 'error', 'action' => 'registration'))
                         );
        }
    }
    
    public function validatorAction(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        $this->isAjax();
        
        $params = array(
            'username' => $this->p_string('username'),
            'password' => $this->p_string('password'),
            'retry_password' => $this->p_string('retry_password')
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
        
        $validItem = $this->load('Validator')->validStringLength($params['username'], 5, 100);
        if($validItem == false){
            $error['username'] = $validItem;
        }else{
            $validItem = $this->load('Validator')->validEmail($params['username']);
            if($validItem == false){
                $error['username'] = $validItem;
            }else{
                $validItem = $this->load('User', 'profile')->checkLogin($params['username']);
                if($validItem == true){
                    $error['username'] = $validItem;
                }
            }
        }
        
        $validItem = $this->load('Validator')->validIdentical($params['password'], $params['retry_password']);
        if($validItem == false){
            $error['retry_password'] = $validItem;
        }else{
            $validItem = $this->load('Validator')->validStringLength($params['password'], 5, 100);
            if($validItem == false){
                $error['password'] = $validItem;
            }
        }
        
        $ret = array(
            'status' => (sizeof($error) > 0 ? false : true),
            'error' => $error
        );
        
        return $ret;
    }
}
