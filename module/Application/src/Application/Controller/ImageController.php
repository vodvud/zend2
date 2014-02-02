<?php
namespace Application\Controller;

class ImageController extends \Base\Mvc\Controller 
{    

 /** TODO: Example
    public function placesAllAction(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $id = $this->p_int('id');
        $w = $this->p_int('w');
        $h = $this->p_int('h');
        $url = $this->load('PlacesAll')->getPhoto($id);
        
        return $this->load('Image')->get($url, $w, $h);
    }
    
    public function placesGalleryAction(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $id = $this->p_int('id');
        $w = $this->p_int('w');
        $h = $this->p_int('h');
        $crop = $this->p_select('crop', 'n', array('y', 'n'));
        $url = $this->load('PlacesGallery', 'admin')->one($id);
        
        return $this->load('Image')->get($url, $w, $h, $crop);
    }
  */
    
    public function blogAction(){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        $id = $this->p_int('id');
        $url = $this->load('Blog')->getPhoto($id);

        return $this->load('Image')->get($url);
    }
}
