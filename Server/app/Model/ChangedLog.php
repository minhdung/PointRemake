<?php
/**
 * User ChangedLog
 * 
 * @package Model
 * @version 1.0
 */

class ChangedLog extends AppModel {

     public $useTable = 'charge_logs';
     public $primaryKey = 'ID';
    
     public $validate = array(
        'card_id'            => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'card_name 空ではありません。'),
        ),
        'shop_id'         => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'point空ではありません。'),
        ),
         'clerk_id'         => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'point空ではありません。'),
        ),
         'point'         => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'point空ではありません。'),
        ),
    );
}
