<?php
namespace Application\Model;

class Blog extends \Application\Base\Model
{
    const POST_PER_PAGE = 5;

    private function getSQL(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        $select = $this->select()
            ->from(self::TABLE_BLOG)
            ->columns(array());

        return $select;
    }

    /**
     * Get all
     * @param int $page
     * @return array
     */
    public function getAll($page = 0){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        $ret = null;
        $select = $this->getSQL();
        
        if($select instanceof \Zend\Db\Sql\Select){            
            $select->columns(array(
                       'id',
                       'title',
                       'description',
                       'img'
                   ))
                   ->order('timestamp desc');

            if(isset($page)){
                $select->limitPage($page, self::POST_PER_PAGE);
            }

            $result = $this->fetchSelect($select);
            
            if($result){               
               $ret = $result; 
            }
        }
        
        
        return $ret;
    }

    /**
     * Get last
     * @param int $limit
     * @return array
     */
    public function getLast($limit = 3){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        $ret = null;
        $select = $this->getSQL();
        
        if($select instanceof \Zend\Db\Sql\Select){            
            $select->columns(array(
                       'id',
                       'title',
                       'description',
                       'date' => $this->expr('date_format(timestamp, "%d %M %Y")')
                   ))
                   ->order('timestamp desc')
                   ->limit($limit);

            $result = $this->fetchSelect($select);

            foreach($result as &$item){

                $item['date'] = $this->load('Date', 'admin')->translateMonth($item['date']);
            }
            
            if($result){               
               $ret = $result; 
            }
        }
        
        return $ret;
    }

    /**
     * get one post
     * @param int $id
     * @return null|array
     */
    public function getOnePost($id = 0){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        $ret = null;
        $select = $this->getSQL();
        
        if($select instanceof \Zend\Db\Sql\Select){            
            if($id > 0){
                $select->columns(array(
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
        } 

        return $ret;
    }

    /**
     * Get photo
     * @param int $id
     * @return null|string
     */
    public function getPhoto($id = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        $ret = null;

        if($id > 0){
            $select = $this->select()
                ->from(self::TABLE_BLOG)
                ->columns(array('img'))
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
     * get paginator
     * @param array $params search params
     * @return null|array
     */
    public function getPaginator($p){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        $count = 0;
        $page = isset($p) ? $p : 1;

        $select = $this->getSQL();

        if($select instanceof \Zend\Db\Sql\Select){
            $select->columns(array(
                'count' => $this->expr('count(*)')
            ));

            $count = (int)$this->fetchOneSelect($select);
        }

        return $this->paginator($page, $count, self::POST_PER_PAGE);
    }
}