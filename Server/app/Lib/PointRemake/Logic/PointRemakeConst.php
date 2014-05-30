<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Message
 *
 * @author DungTM<dungtm@rikkeisoft.com>
 */
class PointRemakeConst {

    public static $error = array(
        '1001' => 'Wrong Username or Password',
        '1002' => 'You logged in successfully. You will be back to homepage in 5 seconds.',
        '1003' => 'Missing parameters', 
       
    );
    public static $success = array(
    );
    public static $header = array(
        'description' => 'PointRemake'
    );
    const API_STATUS_CODE_SUCCESS = 0;
    const API_STATUS_CODE_SUCCESS_MSG = 'Success !';
    const API_STATUS_CODE_NOT_PARMA = 1001;
    const API_STATUS_CODE_NOT_PARMA_MSG = 'データを取得するための認証に失敗しました。しばらくお待ち頂いた後再度お試し下さい。。';
    const API_STATUS_CODE_AUTH = 1002;
    const API_STATUS_CODE_AUTH_MSG = 'ログインが失敗しました。入力した情報を再確認して下さい。';
    const API_STATUS_CODE_NOT_PARAM_LOGIN = 1003;
    const API_STATUS_CODE_NOT_PARAM_LOGIN_MSG = 'ユーザIDもしくはパスワードや店ＩＤが空白になっています';
    const API_STATUS_CODE_LOGIN_SUCCESS = 0;
    const API_STATUS_CODE_LOGIN_SUCCESS_MSG = '承認が成功いたしました';
    const API_STATUS_CODE_SERVER_ERROR= 1004;
    const API_STATUS_CODE_SERVER_ERROR_MSG = 'システム側のエラーです。しばらく待ってから接続して下さい。'; 
    const API_STATUS_CODE_SERVER_LOGIN_ERROR= 1005;
    const API_STATUS_CODE_SERVER_LOGIN_ERROR_MSG = 'ユーザIDかパスワードが正しくありません。ご確認の上再度お試し下さい。'; 
    const API_STATUS_CODE_SERVER_CONFIRME_NOT_CORRECT= 1006;
    const API_STATUS_CODE_SERVER_CONFIRME_NOT_CORRECT_MSG = '新しく設定されたパスワード入力と確認用入力が一致しません。再度ご確認下さい。'; 
    const API_STATUS_CODE_SERVER_PASS_LENGHT= 1007;
    const API_STATUS_CODE_SERVER_PASS_LENGHT_MSG = 'パスワードは６文字以上でご登録下さい。'; 
    const API_STATUS_CODE_CHANGEPASS_SUCCESS= 0;
    const API_STATUS_CODE_CHANGEPASS_SUCCESS_MSG = 'パスワードの変更を完了いたしました';
    const API_STATUS_CODE_SERVER_OLDPASS_NOT_CORRECT= 1008;
    const API_STATUS_CODE_SERVER_OLDPASS_NOT_CORRECT_MSG = '以前のパスワードが正しくありません。再度ご確認下さい。'; 
}
