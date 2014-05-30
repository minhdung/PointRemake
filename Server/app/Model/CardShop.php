<?php

/**
 * User CardShop
 * 
 * @package Model
 * @version 1.0
 */
class CardShop extends AppModel {

        /**
         * @var string Name of table 
         */
        public $useTable = 'card_shops';

        /**
         * @var array  Validate for Clerk
         */
         public $primaryKey = 'ID';
         
        public $validate = array(
            'card_id'            => array(
                'notEmpty' => array('rule' => 'notEmpty', 'message' => 'メールアドレス 空ではありません。'),
            ),
            'shop_id' => array(
                'notEmpty' => array('rule' => 'notEmpty', 'message' => 'パスワード空ではありません。'),
            )
        );

}
