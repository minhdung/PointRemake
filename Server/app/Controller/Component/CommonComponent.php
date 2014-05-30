<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommonComponent
 *
 * @author systena
 */
class CommonComponent {

    //put your code here
    //called before Controller::beforeFilter()
    function initialize(&$controller, $settings = array()) {
        // saving the controller reference for later use
        $this->controller = & $controller;
    }

    //called after Controller::beforeFilter()
    function startup(&$controller) {
        
    }

    //called after Controller::beforeRender()
    function beforeRender(&$controller) {
        
    }

    //called after Controller::render()
    function shutdown(&$controller) {
        
    }

    //called before Controller::redirect()
    function beforeRedirect(&$controller, $url, $status = null, $exit = true) {
        
    }

    function redirectSomewhere($value) {
        // utilizing a controller method
    }

    function rand_string($length) {
        $str = '';
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }

}
