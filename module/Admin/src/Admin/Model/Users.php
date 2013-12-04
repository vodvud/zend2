<?php
namespace Admin\Model;

class Users extends \Application\Base\Model
{
    const USERS_PER_PAGE = 20;
    
    private static $userLevel = array();

    /**
     * Get user list
     * @param int $page
     * @return null|array
     */
    public function getList($page = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = null;

        $select = $this->select()
                       ->from(array('u' => self::TABLE_USER))
                       ->columns(array(
                           'id',
                           'username',
                           'name',
                           'star',
                           'date' => $this->expr('date_format(u.timestamp, "%d.%m.%Y %H:%i")')
                       ))
                       ->where(array(
                           'u.level' => self::USERS_LEVEL_USER
                        ))
                       ->order('u.timestamp desc');
        
        if($page > 0){
            $select->limitPage($page, self::USERS_PER_PAGE);
        }
        
        $result = $this->fetchSelect($select);

        if($result){               
           $ret = $result; 
        }

        return $ret;
    }
    
    /**
     * Get all list
     * @return null|array
     */
    public function getAll(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = null;

        $select = $this->select()
                       ->from(self::TABLE_USER)
                       ->columns(array(
                           'id',
                           'username'
                       ))
                       ->order('level asc')
                       ->order('timestamp desc');
        
        $result = $this->fetchSelect($select);

        if($result){               
           $ret = $result; 
        }

        return $ret;
    }
    
    /**
     * Get one
     * @param int $id
     * @return null|array
     */
    public function getOne($id = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = null;

        if($id > 0){                
            $select = $this->select()
                           ->from(array('u' => self::TABLE_USER))
                           ->columns(array(
                                'id',
                                'username',
                                'name',
                                'star',
                           ))
                           ->where(array(
                               'u.id' => $id,
                               'u.level' => self::USERS_LEVEL_USER
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
     * Get User
     * @param int $id
     * @return array|null
     */
    public function getUsername($id = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        $ret = null;

        if($id > 0){
            $select = $this->select()
                ->from(self::TABLE_USER)
                ->columns(array('username'))
                ->where(array('id' => $id))
                ->limit(1);

            $result = $this->fetchOneSelect($select);

            if($result){
                $ret = $result;
            }
        }

        return $ret;
    }
    
    /**
     * Get User Name
     * @param int $id User ID
     * @return string|null
     */
    public function getName($id = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = null;
        
            if($id > 0){
                $select = $this->select()
                               ->from(self::TABLE_USER)
                               ->columns(array('name'))
                               ->where(array('id' => $id))
                               ->limit(1);
                
                $result = $this->fetchOneSelect($select);
                
                if($result){
                    $ret = $result;
                }
            }
        
        return $ret;
    }
    
    /**
     * Get User Level
     * @param int $id User ID
     * @return string|null
     */
    public function getLevel($id = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = null;
        
            if($id > 0){
                if(isset(self::$userLevel[$id])){
                    $ret = self::$userLevel[$id];
                }else{                    
                    $select = $this->select()
                                   ->from(self::TABLE_USER)
                                   ->columns(array('level'))
                                   ->where(array('id' => $id))
                                   ->limit(1);

                    $result = $this->fetchOneSelect($select);

                    if($result){
                        self::$userLevel[$id] = $result;
                        $ret = $result;
                    }
                }
            }
        
        return $ret;
    }
    
    /**
     * Check level "user"
     * @param int $id
     * @return bool
     */
    public function checkUserLevel($id = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = false;
        
            if($id > 0){
                $level = $this->getLevel($id);
                
                if($level === self::USERS_LEVEL_USER){
                    $ret = true;
                }
            }
        
        return $ret;
    }
    
    /**
     * Check level "admin"
     * @param int $id
     * @return bool
     */
    public function checkAdminLevel($id = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = false;
        
            if($id > 0){
                $level = $this->getLevel($id);
                
                if($level === self::USERS_LEVEL_ADMIN){
                    $ret = true;
                }
            }
        
        return $ret;
    }
    
    /**
     * Edit
     * @param int $id
     * @param array $params
     * @param array $arrays
     * @return bool
     */
    public function edit($id = 0, $params = null, $arrays = null){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = false;
        
        if($id > 0 && $params !== null){ 
            
            if(isset($params['username']) && $this->load('User', 'profile')->checkLogin($params['username'], $id) == false){
                $set = array(
                    'username' => $params['username'],
                    'name' => isset($params['name']) ? $params['name'] : '',
                    'star' => isset($params['star']) ? $params['star'] : 0
                );

                $select = $this->select()
                    ->from(self::TABLE_USER)
                    ->columns(array('star' => 'star'))
                    ->where(array('id' => $id));
                $oldStars = self::fetchOneSelect($select);

                if(
                    isset($params['password']) && 
                    isset($params['retry_password']) && 
                    !empty($params['password']) && 
                    $this->load('Validator')->validIdentical($params['password'], $params['retry_password']) === true
                  ){
                    $salt = $this->load('User', 'profile')->generateSalt();
                    $set['password'] = $this->expr('md5(?)', $params['password'].$salt);
                    $set['salt'] = $salt;
                }

                $update = $this->update(self::TABLE_USER)
                               ->set($set)
                               ->where(array('id' => $id));
                
                $ret = $this->execute($update);

                if ($ret){
                    $stars = $set['star'] - $oldStars;
                    if ($stars > 0){
                        $this->load('SendEmail', 'admin')->refill($set['username'], $stars);
                    }
                }
            }

            if(isset($arrays['phone'])){
                $maskArray = isset($arrays['mask']) ? $arrays['mask'] : null;
                $this->load('UsersPhone', 'admin')->add($id, $arrays['phone'], $maskArray);
            } 
        }
        
        return (bool)$ret;
    }

    /**
     * Remove
     * @param int $id
     * @return bool
     */
    public function remove($id = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = false;
        
        if($id > 0){ 
            $delete = $this->delete(self::TABLE_USER)
                           ->where(array('id' => $id));

            $ret = $this->execute($delete);
        }
        
        return (bool)$ret;
    }

    /**
     * get paginator
     * @param int $page
     * @return null|array
     */
    public function getPaginator($page = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        $count = 0;
        $page = ($page > 0) ? $page : 1;

        $select = $this->select()
                       ->from(self::TABLE_USER)
                       ->columns(array(
                           'count' => $this->expr('count(*)')
                       ))                       
                       ->where(array(
                           'level' => self::USERS_LEVEL_USER
                       ));

        $count = (int)$this->fetchOneSelect($select);

        return $this->paginator($page, $count, self::USERS_PER_PAGE);
    }
    
    public function getCarsCount($userId = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = array();
        
        $count = $this->load('VehiclesCarRent', 'admin')->getCount($userId);
        if($count > 0){
            $ret[] = array(
                'url' => 'vehicles-'.self::VEHICLES_CAT_CAR_RENT,
                'name' => $this->load('VehiclesCat', 'admin')->getCatName(self::VEHICLES_CAT_CAR_RENT),
                'count' => $count
            );
        }
        
        $count = $this->load('VehiclesPassengerTransportation', 'admin')->getCount($userId);
        if($count > 0){
            $ret[] = array(
                'url' => 'vehicles-'.self::VEHICLES_CAT_PASSENGER_TRANSPORTATION,
                'name' => $this->load('VehiclesCat', 'admin')->getCatName(self::VEHICLES_CAT_PASSENGER_TRANSPORTATION),
                'count' => $count
            );
        }
        
        $count = $this->load('VehiclesFreightTransportation', 'admin')->getCount($userId);
        if($count > 0){
            $ret[] = array(
                'url' => 'vehicles-'.self::VEHICLES_CAT_FREIGHT_TRANSPORTATION,
                'name' => $this->load('VehiclesCat', 'admin')->getCatName(self::VEHICLES_CAT_FREIGHT_TRANSPORTATION),
                'count' => $count
            );
        }
        
        $count = $this->load('VehiclesSpecialMachinery', 'admin')->getCount($userId);
        if($count > 0){
            $ret[] = array(
                'url' => 'vehicles-'.self::VEHICLES_CAT_SPECIAL_MACHINERY,
                'name' => $this->load('VehiclesCat', 'admin')->getCatName(self::VEHICLES_CAT_SPECIAL_MACHINERY),
                'count' => $count
            );
        }
        
        return $ret;
    }
}