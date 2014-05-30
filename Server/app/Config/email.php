<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailConfig
 *
 * @author systena
 */
class EmailConfig {

    //put your code here
    public function __construct() {
        
    }

    public $admin = array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => 465,
        'username' => 'chienlv.ict',
        'password' => 'khongcaidat',
        'transport' => 'Smtp',
        'timeout' => '60'
    );

}
