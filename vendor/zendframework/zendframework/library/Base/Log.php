<?php
namespace Base;

class Log
{
    private static $is_writable = true;

    public static function save($str){
        if(self::$is_writable == true){
            $filename = BASE_PATH.'/data/cache/project.log';
            if (is_writable($filename)) {
                $str = date('Y-m-d H:i:s') . "\t" . $_SERVER['REQUEST_URI'] . "\t" . $str . "\n";
                file_put_contents($filename, $str, FILE_APPEND);
            }else{
                self::$is_writable = false;
            }            
        }
    }
}