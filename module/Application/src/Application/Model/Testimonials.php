<?php
namespace Application\Model;

class Testimonials extends \Application\Base\Model
{
    const POST_PER_PAGE = 10;

    private function getSQL(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        $select = $this->select()
                       ->from(array('t' => self::TABLE_TESTIMONIALS))
                       ->columns(array())
                       ->where(array('t.is_verified' => 'y'));

        return $select;
    }

    /**
     * 
     * @param array $params
     * @return bool
     */
    public function add($params, $car_params = array()){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        $ret = false;
        
        if($params !== null){
            $params['is_verified'] = 'n';
            $params['timestamp'] = $this->load('Date', 'admin')->getDateTime();
            $insert = $this->insert(self::TABLE_TESTIMONIALS)
                           ->values($params);

            $ret = $this->execute($insert);
        }
        
        return (bool)$ret;
    }

    /**
     * Get all
     * @param int $page
     * @return null|array
     */
    public function getAll($page = 0){
        $this->log(__CLASS__.'\\'.__FUNCTION__);

        $result = null;
        $select = $this->getSQL();

        if($select instanceof \Zend\Db\Sql\Select){            
            $select->columns(array(
                    'id',
                    'name',
                    'email',
                    'comment',
                    'date' => $this->expr('date_format(t.timestamp, "%e %M %Y %H:%s")')
                ))
                ->order('timestamp desc');

            if($page != 0){
                $select->limitPage($page, self::POST_PER_PAGE);
            }

            $result = $this->fetchSelect($select);

            foreach($result as &$item){

                $item['date'] = $this->load('Date', 'admin')->translateMonth($item['date']);
            }
        }


        return $result;
    }

    /**
     * Get last
     * @param int $limit
     * @return null|array
     */
    public function getLast($limit = 3){
        $this->log(__CLASS__.'\\'.__FUNCTION__);
        
        $result = null;
        $select = $this->getSQL();

        if($select instanceof \Zend\Db\Sql\Select){            
            $select->columns(array(
                    'id',
                    'name',
                    'comment',
                    'date' => $this->expr('date_format(timestamp, "%e %M %Y")')
                ))
                ->order('timestamp desc')
                ->limit($limit);

            $result = $this->fetchSelect($select);

            foreach($result as &$item){

                $item['date'] = $this->load('Date', 'admin')->translateMonth($item['date']);
            }
        }

        return $result;
    }

    /**
     * get paginator
     * @param int $page
     * @return null|array
     */
    public function getPaginator($page = 0){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        $count = 0;
        $page = ((int)$page > 0) ? (int)$page : 1;

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