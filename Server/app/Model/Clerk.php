<?php

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * User Clerk
 * 
 * @package Model
 * @version 1.0
 */
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class Clerk extends AppModel {

        /**
         * @var string Name of table 
         */
        public $useTable = 'clerks';


    /**
     * @var array  Validate for Clerk
     */
     public $primaryKey = 'ID';
    
    public $validate = array(
        'clerk_login'            => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'メールアドレス 空ではありません。'),
            'isUnique' => array('rule' => 'isUnique', 'message' => 'メールアドレス ありますした。'),
        ),
        'password'         => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'パスワード空ではありません。'),
            'length'   => array('rule' => array('between', 6, 50), 'message' => 'パスワードの長さは6文字から30文字の間でなければなりません。'),
        ),
    );
    
    public function beforeSave($options = array()) {
        if(isset($this->data['Clerk']['password'])){
            $passwordHasher = new SimplePasswordHasher();
            $this->data['Clerk']['password'] = $passwordHasher->hash($this->data['Clerk']['password']);
        }
        return true;
    }

}
