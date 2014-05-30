<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Card
 *
 * @author systena
 */
class Card extends AppModel {

    //put your code here
    public $useTable = 'cards';
    public $primaryKey = 'id';
    var $name = 'Card';

    
    /**
     * 
     * @param type $access_token
     * @return type
     */
    function checkAuth($access_token) {
        $card = $this->find('first', array('conditions' => array('access_token' => $access_token)));
        return $card;
    }

}
