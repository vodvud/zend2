<?php
namespace Base\Mvc;

use Base\Log;
use Base\Storage;
use Base\Sql\CustomSelect;
use Base\Mvc\ReflectionClass;
use Base\Mvc\ModelsLoader;
use Base\Mvc\Paginator;
use Base\Text\Translit;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Having;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Math\Rand;


/**
 * show-off @property
 * @property \Base\Mvc\ReflectionClass $const $this->load('ModelName')->const Get constant from loaded model
 * @property \Base\Mvc\ReflectionClass $static $this->load('ModelName')->static Get static property from loaded model
 */
class Model
{

    // SQL constant
    const SQL_ALL = CustomSelect::QUANTIFIER_ALL;
    const SQL_DISTINCT = CustomSelect::QUANTIFIER_DISTINCT;
    const SQL_JOIN_LEFT = CustomSelect::JOIN_LEFT;
    const SQL_JOIN_RIGHT = CustomSelect::JOIN_RIGHT;
    const SQL_JOIN_INNER = CustomSelect::JOIN_INNER;
    const SQL_JOIN_OUTER = CustomSelect::JOIN_OUTER;
    const SQL_COMBINE_UNION = CustomSelect::COMBINE_UNION;
    const SQL_COMBINE_EXCEPT = CustomSelect::COMBINE_EXCEPT;
    const SQL_COMBINE_INTERSECT = CustomSelect::COMBINE_INTERSECT;
    const SQL_WHERE_AND = PredicateSet::OP_AND;
    const SQL_WHERE_OR = PredicateSet::OP_OR;

    private static $_adapter = null;
    
    /**
     * Get constant and static property val
     * @param str $name
     * @return $this|str
     */
    public final function __get($name) {        
        $reflection = new ReflectionClass($this);
        return $reflection->$name;
    }

    /**
     * save log
     * @param str $str __CLASS__.'\\'.__FUNCTION__
     */
    public final function log($str){        
        Log::save($str);
    }
    
    /**
     * get storage
     * @return \Base\Storage
     */
    public final function storage(){
        return new Storage();
    }
    
    /**
     * Get Adapter
     * @return \Zend\Db\Adapter\Adapter
     */
    public final function adapter() {  
       if(self::$_adapter === null){ 
            self::$_adapter = new Adapter($this->storage()->dbConfig);               
       }
       return self::$_adapter;
    }

    /**
     * 
     * @param str|null $table
     * @return \Zend\Db\Sql\Select
     */
    public final function select($table = null) {
        return new CustomSelect($table);
    }
    
    /**
     *
     * @param str|null $table
     * @return \Zend\Db\Sql\Insert
     */
    public final function insert($table = null) {
        return new Insert($table);
    }
    
    /**
     *
     * @param str|null $table
     * @return \Zend\Db\Sql\Update
     */
    public final function update($table = null) {
        return new Update($table);
    }
    
    /**
     *
     * @param str|null $table
     * @return \Zend\Db\Sql\Delete
     */
    public final function delete($table = null) {
        return new Delete($table);
    }
    
    /**
     *
     * @return \Zend\Db\Sql\Where
     */
    public final function where(){
        return new Where();
    }
    
    /**
     *
     * @return \Zend\Db\Sql\Having
     */
    public final function having(){
        return new Having();
    }
    
    /**
     * Set SQL expression
     * <pre>
     * sql string:
     * &nbsp;&nbsp; $this->expr('count(*)')
     * sub query:
     * &nbsp;&nbsp; $this->expr('?', array($subQry))
     * </pre>
     * @param string $expression
     * @param string|array $parameters
     * @return \Zend\Db\Sql\Expression
     */
    public final function expr($expression = '', $parameters = null){
        return new Expression($expression, $parameters);
    }

    /**
     * SQL Query
     * @param \Zend\Db\Sql\* $query
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public final function sqlQuery($query) {
        $this->log('* '.$query);
        return $this->adapter()->query($query)->execute();
    }

    /**
     * Execute SQL
     * @param \Zend\Db\Sql\* $select
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public final function execute($select) {
        $sql = new Sql($this->adapter());
        $sqlstring = $sql->getSqlStringForSqlObject($select);
        
        $this->log('* '.$sqlstring);
        return $this->adapter()->query($sqlstring)->execute();
    }

    /**
     * Fetch all
     * @param \Zend\Db\Sql\Select $select
     * @return array
     */
    public final function fetchSelect(\Zend\Db\Sql\Select $select) {
        $res = array();
        foreach ($this->execute($select) as $row) {
            array_push($res, $row);
        }
        return $res;

    }
    
    /**
     * Get SQL String
     * @param \Zend\Db\Sql\* $sql
     * @return string
     */
    public final function getSqlString($sql){
        return $sql->getSqlString($this->adapter()->getPlatform());
    }
    
    /**
     * Get Sub Query String
     * @param \Zend\Db\Sql\Select $sql
     * @return string
     */
    public final function subQuery(\Zend\Db\Sql\Select $sql){
        return $this->expr('('.
                               $this->getSqlString($sql)
                           .')');
    }
    
    /**
     * Fetch one row
     * @param \Zend\Db\Sql\Select $select
     * @return array
     */
    public final function fetchRowSelect(\Zend\Db\Sql\Select $select) {
        $res = array();
        foreach ($this->execute($select) as $row) {
            array_push($res, $row);
        }
        return reset($res);        
    }
    
    /**
     * Fetch first columns
     * @param \Zend\Db\Sql\Select $select
     * @return array
     */
    public final function fetchColSelect(\Zend\Db\Sql\Select $select) {
        $res = array();
        foreach ($this->execute($select) as $row) {
            array_push($res, reset($row));
        }
        return $res;        
    }
    
    /**
     * Fetch only one param
     * @param \Zend\Db\Sql\Select $select
     * @return mixed
     */
    public final function fetchOneSelect(\Zend\Db\Sql\Select $select) {
        $res = array();
        
        foreach ($this->execute($select) as $row) {
            array_push($res, $row);
        }
        $res = reset($res);
        if(is_array($res)){
            $res = reset($res);
        }
        return $res;        
    }
    
    /**
     * Last insert id
     * @return int 
     */
    public final function insertId() {
        return $this->adapter()->getDriver()->getLastGeneratedValue();
    }
    
    /**
     * Generate a random string of specified length.
     *
     * Uses supplied character list for generating the new string.
     * If no character list provided - uses Base 64 character set.
     *
     * @param  int $length
     * @param  string|null $charlist
     * @param  bool $strong  true if you need a strong random generator (cryptography)
     * @return string
     * @throws Exception\DomainException
     */
    public final function randString($length, $charlist = null, $strong = false){
        return Rand::getString($length, $charlist, $strong);
    }
    
    /**
     * Load models
     * @param str $model
     * @param str $module
     * @return object
     * @throws \Zend\Mvc\Exception\InvalidArgumentException
     */
    public final function load($model = null, $module = 'application') {
        return ModelsLoader::load($model, $module);
    }
    
    /**
     * Returns site's base path.
     * 
     * @return string
     */
    public final function basePath(){
        return ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'];
    }
    
    /**
     * Page paginator
     * @param int $page Current page
     * @param int $count All rows
     * @param int $rows Rows per page
     * @return null|array
     */
    public final function paginator($page = 0, $count = 0, $rows = 10){
        $paginator = new Paginator();
        return $paginator($page, $count, $rows);
    }
    
    /**
     * Page limiter
     * @param int $limit Current limit
     * @return null|array
     */
    public final function limiter($limit = 10){ //self::CARS_PER_PAGE
        $arr = array(10, 25, 50, 'all');
        $ret = array();
        
        foreach($arr as $item){
            $ret[] = array(
                'val' => $item,
                'type' => ($limit == $item) ? 'current' : 'page'
            );
        }
        
        return $ret;
    }
    
    /**
     * Translit string
     * @param string $string
     * @param string $separator
     * @param boolean $lowercase
     * @return string
     */
    public final function translit($string = '', $separator = '-', $lowercase = true){
        $translit = new Translit();
        return $translit($string, $separator, $lowercase);
    }
    
    /**
     * Debuger
     * @param mixed $obj
     */
    public final function debug($obj){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        \Zend\Debug\Debug::dump($obj);
    }
          
    /**
     * Returns site email.
     * @return string
     */
    public final function getSiteEmail(){        
        return isset($this->storage()->siteConfig['email']) ? $this->storage()->siteConfig['email'] : 'info@'.$_SERVER['HTTP_HOST'];
    }
    
    /**
     * Returns site name.
     * @return string
     */
    public final function getSiteName(){
        return isset($this->storage()->siteConfig['name']) ? $this->storage()->siteConfig['name'] : 'Site Name';
    }
    
}