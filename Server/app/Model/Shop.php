<?php

/**
 * User shop
 * 
 * @package Model
 * @version 1.0
 */
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class Shop extends AppModel {

    public $useTable = 'shops';
    public $primaryKey = 'id';

    public $validate = array(
        'shop_login' => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'shop_login 空ではありません。'),
            'isUnique' => array('rule' => 'isUnique', 'message' => 'shop_login ありますした。'),
        ),
        'password' => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'パスワード空ではありません。'),
            'length' => array('rule' => array('between', 6, 30), 'message' => 'パスワードの長さは6文字から30文字の間でなければなりません。'),
        ),
        'current_password' => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'パスワード空ではありません。'),
            'length' => array('rule' => array('between', 6, 30), 'message' => 'パスワードの長さは6文字から30文字の間でなければなりません。'),
            'checkInDatabase' => array('rule' => 'checkInDatabase', 'message' => 'Current password do not match.'),
        ),
        'confirm_password' => array(
            'rule' => 'checkConfirmPassword',
            'message' => 'Confirm password do not match'
        ),
        'shop_mail' => array('rule' => 'email', 'message' => 'Is not email')
    );

    public function checkConfirmPassword() {
        if ($this->data['Shop']['password'] === $this->data['Shop']['confirm_password']) {
            return true;
        }
        return false;
    }

    public function checkInDatabase() {
        if (isset($this->data['Shop']['current_password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data['Shop']['current_password'] = $passwordHasher->hash($this->data['Shop']['current_password']);
        }
        $account = $this->find('first', array('conditions' => array('id' => $this->data['Shop']['shop_id'], 'password' => $this->data['Shop']['current_password'])));
        if (!empty($account)) {
            return true;
        }
        return false;
    }

    public function beforeSave($options = array()) {
        if (isset($this->data['Shop']['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data['Shop']['password'] = $passwordHasher->hash($this->data['Shop']['password']);
        }
        return true;
    }

    public function isUploadedFile($val) {
        if ((isset($val['error']) && $val['error'] == 0) ||
                (!empty($val['tmp_name']) && $val['tmp_name'] != 'none')
        ) {
            return is_uploaded_file($val['tmp_name']);
        }
        return false;
    }

}
