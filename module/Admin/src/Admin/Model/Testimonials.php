<?php
namespace Admin\Model;

class Testimonials extends \Application\Base\Model
{
    const POST_PER_PAGE = 20;
    
    /**
     * Get all list
     * @param int $page
     * @return null|array
     */
    public function getList($page = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = null;

        $select = $this->select()
                       ->from(self::TABLE_TESTIMONIALS)
                       ->columns(array(
                           'id',
                           'name',
                           'email',
                           'comment',
                           'is_verified',
                           'date' => $this->expr('date_format(timestamp, "%d.%m.%Y %H:%i")')
                       ))
                       ->order('is_verified desc')
                       ->order('timestamp desc');
        
        if($page > 0){
            $select->limitPage($page, self::POST_PER_PAGE);
        }

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
                           ->from(self::TABLE_TESTIMONIALS)
                           ->columns(array(
                                'id',
                                'name',
                                'email',
                                'comment',
                                'is_verified'
                           ))
                           ->where(array('id' => $id))
                           ->limit(1);

            $result = $this->fetchRowSelect($select);

            if($result){
               $ret = $result; 
            }
        }
        
        return $ret;
    }    
    
    /**
     * Edit
     * @param int $id
     * @param array $params
     * @return bool
     */
    public function edit($id = 0, $params = null){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = false;
        
        if($id > 0 && $params !== null){ 
            $update = $this->update(self::TABLE_TESTIMONIALS)
                           ->set($params)
                           ->where(array('id' => $id));

            $ret = $this->execute($update);
        }
        
        return (bool)$ret;
    }
    
    /**
     * Set status
     * @param int $id
     * @return bool
     */
    public function setStatus($id = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = false;
        
        if($id > 0){            
            $select = $this->select()
                           ->from(self::TABLE_TESTIMONIALS)
                           ->columns(array('is_verified' ))
                           ->where(array('id' => $id))
                           ->limit(1);
            
            $status = $this->fetchOneSelect($select);
            
            if($status){                
                $update = $this->update(self::TABLE_TESTIMONIALS)
                               ->set(array(
                                   'is_verified' => ($status == 'y' ? 'n' : 'y')
                               ))
                               ->where(array('id' => $id));
                
                $ret = $this->execute($update);
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
            $delete = $this->delete(self::TABLE_TESTIMONIALS)
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
                       ->from(self::TABLE_TESTIMONIALS)
                       ->columns(array(
                           'count' => $this->expr('count(*)')
                       ));

        $count = (int)$this->fetchOneSelect($select);

        return $this->paginator($page, $count, self::POST_PER_PAGE);
    }
}