<?php
namespace Admin\Model;

class Blog extends \Application\Base\Model
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
                       ->from(self::TABLE_BLOG)
                       ->columns(array(
                           'id',
                           'title',
                           'date' => $this->expr('date_format(timestamp, "%d.%m.%Y %H:%i")')
                       ))
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
                           ->from(self::TABLE_BLOG)
                           ->columns(array(
                                'id',
                                'title',
                                'description',
                                'img'
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
     * Add
     * @param array $params
     * @param mixed $img
     * @return bool
     */
    public function add($params = null, $img = null){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = false;
        
        if($params !== null){ 
            $photo = $this->load('Upload', 'admin')->save($img, array('gif', 'png', 'jpg', 'jpeg'), 'blog', array('width' => 600));

            if($photo !== null){
                $params['img'] = $photo;
            }
            
            $insert = $this->insert(self::TABLE_BLOG)
                           ->values($params);

            $ret = $this->execute($insert);
        }
        
        return (bool)$ret;
    }
    
    /**
     * Edit
     * @param int $id
     * @param array $params
     * @param mixed $img
     * @return bool
     */
    public function edit($id = 0, $params = null, $img = null){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $ret = false;
        
        if($id > 0 && $params !== null){ 
            $photo = $this->load('Upload', 'admin')->save($img, array('gif', 'png', 'jpg', 'jpeg'), 'blog', array('width' => 600));

            if($photo !== null){
                $params['img'] = $photo;

                $post = $this->getOne($id);
                if(isset($post['img'])){
                    $this->load('Upload', 'admin')->unlink($post['img']);
                }
            }
            
            $update = $this->update(self::TABLE_BLOG)
                           ->set($params)
                           ->where(array('id' => $id));

            $ret = $this->execute($update);
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
            $post = $this->getOne($id);
            
            $delete = $this->delete(self::TABLE_BLOG)
                           ->where(array('id' => $id));

            $ret = $this->execute($delete);
            
            if($ret && isset($post['img'])){
                $this->load('Upload', 'admin')->unlink($post['img']);
            }
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
                       ->from(self::TABLE_BLOG)
                       ->columns(array(
                           'count' => $this->expr('count(*)')
                       ));

        $count = (int)$this->fetchOneSelect($select);

        return $this->paginator($page, $count, self::POST_PER_PAGE);
    }
}