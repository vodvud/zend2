<?php
namespace Profile\Model;

class Forgot extends \Application\Base\Model
{
    /**
     * Recover User
     * @param array $params
     * @return bool
     */
    public function recover($params = null){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = false;
        
        if(isset($params['username'])){
            $select = $this->select()
                           ->from(self::TABLE_USER)
                           ->columns(array('id'))
                           ->where(array(
                               'username' => $params['username'],
                               'level' => self::USERS_LEVEL_USER
                           ))
                           ->limit(1);
            
            $userId = (int)$this->fetchOneSelect($select);
            
            if($userId > 0){
                $newPassword = $this->randString(8);
                $salt = $this->load('User', 'profile')->generateSalt();

                $update = $this->update(self::TABLE_USER)
                               ->set(array(
                                   'password' => $this->expr('md5(?)', $newPassword.$salt),
                                   'salt' => $salt
                               ))
                               ->where(array(
                                   'id' => $userId,
                                   'level' => self::USERS_LEVEL_USER
                               ));

                $result = $this->execute($update);

                if($result){
                    $ret = true;
                    $this->load('SendEmail', 'admin')->fogotPassword($params['username'], $newPassword);
                }
            }
        }
        
        return $ret;
    }
}