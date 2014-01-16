<?php
namespace Application\Base;

abstract class Model extends \Base\Mvc\Model
{

    // Table constant
    const TABLE_SQL_UPDATES = '_sql_updates';
    const TABLE_USER = 'user';
    const TABLE_USER_PHONE = 'user_phone';
    const TABLE_PAGES = 'pages';
    const TABLE_TESTIMONIALS = 'testimonials';
    const TABLE_PHONE_MASK = 'phone_mask';
    const TABLE_EMAIL_NOTIFICATIONS = 'email_notifications';
    const TABLE_HELPS = 'helps';

    // Users level
    const USERS_LEVEL_ADMIN = 'admin';
    const USERS_LEVEL_USER = 'user';

    // Email Notifications
    const EMAIL_REGISTRATION = 'registration';
    const EMAIL_CHANGE_DATA = 'change_data';
    const EMAIL_ADD_ADVERT = 'add_advert';
    const EMAIL_DELETE_ADVERT = 'delete_advert';
    const EMAIL_ACTIVATION_ADVERT = 'activation_advert';
    const EMAIL_EXTEND_TIME = 'extend_time';
    const EMAIL_EXPIRY_TIME = 'expiry_time';
    const EMAIL_REFILL = 'refill';
    const EMAIL_FORGOT = 'forgot';

    /**
     * Get limiter
     * @param array $params search params
     * @return null|array
     */
    public function getLimiter($params = array()){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        return $this->limiter($this->getLimit($params));
    }

    /**
     * Get limit
     * @param array $params search params
     * @return int|string
     */
    protected function getLimit($params = array()){
        $this->log(__CLASS__ . '\\' . __FUNCTION__);

        $limit = isset($params['limit']) ? $params['limit'] : 10;
        return $limit;
    }

}