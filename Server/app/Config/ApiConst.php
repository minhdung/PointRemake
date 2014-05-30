<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApiConst
 *
 * @author systena
 */
class ApiConst {

    //put your code here
    #error code
    const API_STATUS_CODE_NORMAL = 1000;
    const API_STATUS_CODE_NORMAL_MSG = 'Success !';
    const API_STATUS_CODE_MISS_PARAM = 1001;
    const API_STATUS_CODE_MISS_PARAM_MSG = 'Parameter is incorrect !';
    const API_STATUS_CODE_AUTH_TOKEN_NOT_VALID = 1002;
    const API_STATUS_CODE_AUTH_TOKEN_NOT_VALID_MSG = 'Auth token not valid';
    const API_STATUS_CODE_CARD_NOT_REGISTED = 1003;
    const API_STATUS_CODE_CARD_NOT_REGISTED_MSG = 'Card is not registed';
    const API_STATUS_CODE_SHOP_NOT_EXIST = 1004;
    const API_STATUS_CODE_SHOP_NOT_EXIST_MSG = 'Shop is not exist';
    const API_STATUS_CODE_GIFT_NOT_EXIST = 1005;
    const API_STATUS_CODE_GIFT_NOT_EXIST_MSG = 'Gift is not exist';


    #Const define
    const LOAD_OLD = 0;
    const LOAD_NEW = 1;

}
