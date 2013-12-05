<?php
namespace Profile\Controller;

class FavoritesController extends \Profile\Base\Controller
{
    public function indexAction()
    {
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        $userId = $this->getUserId();

        $ret = array(

        );

        return $this->view($ret);
    }

    public function removeAction()
    {
        $this->log(__CLASS__ . '\\' . __FUNCTION__);
        
        $id = $this->p_int('id');
        $userId = $this->getUserId();

        $this->load('Favorites', 'profile')->remove($id, $userId);

        return $this->redirect()->toUrl(
            $this->easyUrl(array('action' => 'index'))
        );
    }
}