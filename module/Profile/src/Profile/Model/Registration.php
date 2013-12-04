<?php
namespace Profile\Model;

class Registration extends \Application\Base\Model
{
    /**
     * Authorize User
     * @param array $params
     * @return null|array
     */
    public function authUser($params = null){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = null;
        
        if(isset($params['username']) && isset($params['password'])){
            if($this->load('User', 'profile')->checkLogin($params['username']) == false){  
                $salt = $this->load('User', 'profile')->generateSalt();
                
                $insert = $this->insert(self::TABLE_USER)
                               ->values(array(
                                   'username' => $params['username'],
                                   'password' => $this->expr('md5(?)', $params['password'].$salt),
                                   'salt' => $salt,
                                   'level' => self::USERS_LEVEL_USER,
                                   'timestamp' => $this->load('Date', 'admin')->getDateTime()
                               ));

                $result = $this->execute($insert);

                if($result){
                    $id = $this->insertId();
                    $ret = array(
                        'id' => $id,
                        'username' => $params['username']
                    );

                    $this->load('SendEmail', 'admin')->registration($params['username'], $params['password']);
                }



            }
        }
        
        return $ret;
    }
}