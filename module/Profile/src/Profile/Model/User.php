<?php
namespace Profile\Model;

class User extends \Application\Base\Model
{
    /**
     * Get User
     * @param int $id
     * @return array|null
     */
    public function getOne($id = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = null;
        
            if($id > 0){
                $select = $this->select()
                               ->from(self::TABLE_USER)
                               ->columns(array(
                                   'username'
                               ))
                               ->where(array(
                                   'id' => $id
                               ))
                               ->limit(1);
                
                $result = $this->fetchRowSelect($select);
                
                if($result){
                    $ret = $result;
                }
            }
        
        return $ret;
    }
    
    /**
     * Edit User
     * @param array $params
     * @param int $id
     * @return bool
     */
    public function edit($params = null, $id = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = false;
        
        if(isset($params['username']) && isset($params['password']) && isset($params['old_password']) && $id > 0){
            if($this->checkLogin($params['username'], $id) == false){
                $select = $this->select()
                               ->from(self::TABLE_USER)
                               ->columns(array('id'))
                               ->where(array(
                                   'id' => $id,
                                   'password' => $this->expr('md5(concat(?,salt))', $params['old_password']),
                                   'level' => self::USERS_LEVEL_USER
                               ))
                               ->limit(1);
                
                $userId = (int)$this->fetchOneSelect($select);
                
                if($userId == $id){                    
                    $set = array(
                        'username' => $params['username']
                    ); 

                    if(!empty($params['password'])){
                        $salt = $this->generateSalt();
                        $set['password'] = $this->expr('md5(?)', $params['password'].$salt);
                        $set['salt'] = $salt;
                    }

                    $update = $this->update(self::TABLE_USER)
                                   ->set($set)
                                   ->where(array('id' => $id));


                    $result = $this->execute($update);

                    if($result){
                        $this->load('SendEmail', 'admin')->changeData($params['username'], $params['password']);
                        $ret = true;
                    }
                }
            }
        }
        
        return $ret;
    }
    
    /**
     * Check is there this username
     * @param string $login
     * @param int $id
     * @return bool
     */
    public function checkLogin($login = null, $id = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = false;
        
        if($login !== null){
            $select = $this->select()
                           ->from(self::TABLE_USER)
                           ->columns(array('id'))
                           ->where(array(
                               'username' => $login,
                               'level' => self::USERS_LEVEL_USER
                           ))
                           ->limit(1);
            if($id > 0){
                $select->where(array(
                    $this->where()
                         ->notEqualTo('id', $id)
                ));
            }
            
            $result = (int)$this->fetchOneSelect($select);
            
            if($result > 0){
                $ret = true;
            }
                           
        }
        
        return $ret;
    }
    
    /**
     * Generate salt string
     * @return string
     */
    public function generateSalt(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        return $this->randString(rand(5,10));
    }
    
    /**
     * 
     * @param int $id
     * @param int $star
     * @return bool
     */
    public function payment($id = 0, $star = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = false;
        
            if($id > 0 && $star > 0){
                $select = $this->select()
                               ->from(self::TABLE_USER)
                               ->columns(array('star'))
                               ->where(array('id' => $id))
                               ->limit(1);
                
                $result = $this->fetchOneSelect($select);
                
                if((int)$result > 0 && (int)$result >= $star){
                    $update = $this->update(self::TABLE_USER)
                                   ->set(array(
                                       'star' => ((int)$result - $star)
                                   ))
                                   ->where(array(
                                       'id' => $id,
                                   ));
                    
                    $ret = (bool)$this->execute($update);
                }
            }
        
        return $ret;
    }
}