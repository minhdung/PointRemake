<?php

/**
 * User Gift
 * 
 * @package Model
 * @version 1.0
 */
class Gift extends AppModel {

    public $name = 'Gift';
    public $useTable = 'gifts';
    public $primaryKey = 'ID';
    /* Ban ghi nao cung ghet them thong tin shop la thua thai, nen bo di thi tot hon
    public $belongsTo = array(
        'Shop' => array(
            'className' => 'Shop',
            'foreignKey' => 'shop_id'
    ));
     * 
     */
    public $validate = array(
        'image' => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'Image 空ではありません。'),
        )
    );

}
