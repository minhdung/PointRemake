<?php
/**
 * User Customer
 * 
 * @package Model
 * @version 1.0
 */

class Customer extends AppModel {

     public $useTable = 'cards';
     public $primaryKey = 'ID';
     public $belongTo = array(
	    'Shop' => array(
		'className' => 'Shop',
		'foreignKey' => 'shop_id'
	    ));
     public $validate = array(
        'card_name'            => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'card_name 空ではありません。'),
            'isUnique' => array('rule' => 'isUnique', 'message' => 'card_name ありますした。'),
        ),
        'point'         => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'point空ではありません。'),
        ),
    );
}
