<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author DungTM<dungtm@rikkeisoft.com>
 */
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class ClerksController extends AppController {

    public $helpers = array('Paginator' => array('Paginator'));
    public $components = array('RequestHandler');

    /**
     * Generate access token with user id 
     * @return string
     */
    public function generate_token($clerk_id) {
        // join user_id with device_id and a random string
        $access_token = $clerk_id . "-" . String::uuid();
        return $access_token;
    }

    public function login() {
        $this->autoRender = FALSE;
        if ($this->request->is('post')) {

            if (!isset($this->request->data['clerk_login']) || !isset($this->request->data['password']) || !isset($this->request->data['shop_id'])) {
                $return = array(
                    'status' => array(
                        'code' => PointRemakeConst::API_STATUS_CODE_NOT_PARAM_LOGIN,
                        'string' => PointRemakeConst::API_STATUS_CODE_NOT_PARAM_LOGIN_MSG
                    ),
                );
                return json_encode($return);
            }

            $this->request->data['Clerk']['clerk_login'] = $this->request->data['clerk_login'];
            $this->request->data['Clerk']['password'] = $this->request->data['password'];
            $this->request->data['Clerk']['shop_id'] = $this->request->data['shop_id'];

            $passwordHasher = new SimplePasswordHasher();
            $this->request->data['Clerk']['password'] = $passwordHasher->hash($this->request->data['password']);

            $account = $this->Clerk->find('first', array('conditions' => array('clerk_login' => $this->request->data['Clerk']['clerk_login'], 'password' => $this->request->data['Clerk']['password'], 'deleted' => null)));
            // check if login successfully
            if (!empty($account)) {

                $token = $this->generate_token($account['Clerk']['id']);
                $this->request->data['Clerk']['access_token'] = $token;
                //return json_encode($this->request->data['Clerk']);
                $this->Clerk->id = $account['Clerk']['id'];
                if ($this->Clerk->saveField('access_token', $token)) {
                    $account['Clerk']['access_token'] = $token;
                    $return = array(
                        'status' => array(
                            'code' => PointRemakeConst::API_STATUS_CODE_LOGIN_SUCCESS,
                            'string' => PointRemakeConst::API_STATUS_CODE_LOGIN_SUCCESS_MSG
                        ),
                        'data' => $account
                    );
                    return json_encode($return);
                } else {
                    $return = array(
                        'status' => array(
                            'code' => PointRemakeConst::API_STATUS_CODE_SERVER_ERROR,
                            'string' => PointRemakeConst::API_STATUS_CODE_SERVER_ERROR_MSG
                        ),
                        'data' => $account
                    );
                    return json_encode($return);
                }

                // If log in successfully, return detail information of user
            } else {
                // if log in fail, return status code and message
                $return = array(
                    'status' => array(
                        'code' => PointRemakeConst::API_STATUS_CODE_SERVER_LOGIN_ERROR,
                        'string' => PointRemakeConst::API_STATUS_CODE_SERVER_LOGIN_ERROR_MSG
                    ),
                );
                return json_encode($return);
            }
        }
    }

    public function listshop() {
        $this->autoRender = FALSE;
        $this->loadModel('Shop');
        if ($this->request->is('get')) {
            $array = $this->Shop->find('all');
            return json_encode($array);
        }
    }

    public function changepass() {
        $this->autoRender = FALSE;
        $this->loadModel('Clerk');
        if ($this->request->is('post')) {
            if (isset($this->request->data['access_token'])) {
                $clerk = $this->Clerk->find('first', array('conditions' => array('access_token' => $this->request->data['access_token'])));
                if (empty($clerk)) {
                    $return = array(
                        'status' => array(
                            'code' => PointRemakeConst::API_STATUS_CODE_AUTH,
                            'string' => PointRemakeConst::API_STATUS_CODE_AUTH_MSG
                        ),
                    );
                    return json_encode($return);
                }
                $passwordHasher = new SimplePasswordHasher();
                if (!empty($this->request->data['old_password']) && $passwordHasher->check($this->request->data['old_password'], $clerk['Clerk']['password'])) {
                    if (!empty($this->request->data['confirm_password']) && !empty($this->request->data['new_password']) && $this->request->data['new_password'] == $this->request->data['confirm_password']) {
                        $clerk['Clerk']['password'] = $this->request->data['new_password'];
                    } else {
                        $return = array(
                            'status' => array(
                                'code' => PointRemakeConst::API_STATUS_CODE_SERVER_CONFIRME_NOT_CORRECT,
                                'string' => PointRemakeConst::API_STATUS_CODE_SERVER_CONFIRME_NOT_CORRECT_MSG
                            ),
                        );
                        return json_encode($return);
                    }
                    if (strlen($this->request->data['new_password']) < 6) {
                        $return = array(
                            'status' => array(
                                'code' => PointRemakeConst::API_STATUS_CODE_SERVER_PASS_LENGHT,
                                'string' => PointRemakeConst::API_STATUS_CODE_SERVER_PASS_LENGHT_MSG
                            ),
                        );
                        return json_encode($return);
                    }
                    $token = $this->generate_token($clerk['Clerk']['id']);
                    $clerk['Clerk']['access_token'] = $token;


                    if ($this->Clerk->save($this->Clerk->save(array('Clerk' => array('password' => $clerk['Clerk']['password'], 'access_token' => $clerk['Clerk']['access_token']))))) {
                        $user_detail = array(
                            'access_token' => $token
                        );
                        // Return detail information after update
                        $return = array(
                            'status' => array(
                                'code' => PointRemakeConst::API_STATUS_CODE_CHANGEPASS_SUCCESS,
                                'string' => PointRemakeConst::API_STATUS_CODE_CHANGEPASS_SUCCESS_MSG
                            ),
                            'data' => $user_detail
                        );
                        return json_encode($return);
                    } else {
                        $return = array(
                            'status' => array(
                                'code' => PointRemakeConst::API_STATUS_CODE_SERVER_PASS_LENGHT,
                                'string' => PointRemakeConst::API_STATUS_CODE_SERVER_PASS_LENGHT_MSG
                            ),
                        );
                        return json_encode($return);
                    }
                } else {
                    $return = array(
                        'status' => array(
                            'code' => PointRemakeConst::API_STATUS_CODE_SERVER_OLDPASS_NOT_CORRECT,
                            'string' => PointRemakeConst::API_STATUS_CODE_SERVER_OLDPASS_NOT_CORRECT_MSG
                        ),
                    );
                    return json_encode($return);
                }
            } else {
                $return = array(
                    'status' => array(
                        'code' => PointRemakeConst::API_STATUS_CODE_AUTH,
                        'string' => PointRemakeConst::API_STATUS_CODE_AUTH_MSG
                    ),
                );
                return json_encode($return);
            }
        }
    }

    public function addlog($card, $clerk) {
        $data = array(
            'ChangedLog' => array(
                'card_id' => $card['Customer']['id'],
                'shop_id' => $clerk['Clerk']['shop_id'],
                'clerk_id' => $clerk['Clerk']['id'],
                'point' => $this->request->data['point'],
            ),
        );
        $this->ChangedLog->create();
        $this->ChangedLog->saveAssociated($data);
    }

//    public function addcard() {
//        $this->autoRender = FALSE;
//        $this->loadModel('Customer');
//        $this->loadModel('CardShop');
//        $this->loadModel('ChangedLog');
//        if ($this->request->is('post')) {
//            if (isset($this->request->data['access_token'])) {
//                $clerk = $this->Clerk->find('first', array('conditions' => array('access_token' => $this->request->data['access_token'])));
//                if (empty($clerk)) {
//                    $return = array(
//                        'status' => array(
//                            'code' => "1004",
//                            'string' => "ログインが失敗しました。入力した情報を再確認して下さい。"
//                        ),
//                    );
//                    return json_encode($return);
//                }
//                if (isset($this->request->data['card_name']) && isset($this->request->data['point'])) {
//
//                    $this->request->data['Customer']['card_name'] = $this->request->data['card_name'];
//                    $result = $this->Customer->find('first', array('conditions' => array('card_name' => $this->request->data['Customer']['card_name'])));
//
//                    if (empty($result)) {
//                        $this->Customer->create();
//                        $success = $this->Customer->saveAssociated($this->request->data);
//                        if ($success) {
//                            $card = $this->Customer->find('first', array('conditions' => array('card_name' => $this->request->data['Customer']['card_name'])));
//                            $data = array(
//                                'CardShop' => array(
//                                    'card_id' => $card['Customer']['id'],
//                                    'shop_id' => $clerk['Clerk']['shop_id'],
//                                    'point' => $this->request->data['point'],
//                                ),
//                            );
//                            $this->CardShop->create();
//                            if ($this->CardShop->saveAssociated($data)) {
//                                $this->addlog($card, $clerk);
//                                return json_encode(' create and add card successfull');
//                            }
//                        }
//                    } else {
//                        $cardshop = $this->CardShop->find('first', array('conditions' => array('card_id' => $result['Customer']['id'], 'shop_id' => $clerk['Clerk']['shop_id'])));
//                        if (empty($cardshop)) {
//                            $data = array(
//                                'CardShop' => array(
//                                    'card_id' => $result['Customer']['id'],
//                                    'shop_id' => $clerk['Clerk']['shop_id'],
//                                    'point' => $this->request->data['point'],
//                                ),
//                            );
//                            $this->CardShop->create();
//                            if ($this->CardShop->saveAssociated($data)) {
//                                $this->addlog($result, $clerk);
//                                return json_encode('creat point successfull');
//                            }
//                        } else {
//                            $this->CardShop->id = $cardshop['CardShop']['id'];
//                            if ($this->CardShop->saveField('point', $this->request->data['point'] + $cardshop['CardShop']['point'])) {
//                                $this->addlog($result, $clerk);
//                                return json_encode('creat point successfull');
//                            }
//                        }
//                    }
//                } else {
//                    $return = array(
//                        'status' => array(
//                            'code' => "1003",
//                            'string' => "データを取得するための認証に失敗しました。しばらくお待ち頂いた後再度お試し下さい。。"
//                        ),
//                    );
//                    return json_encode($return);
//                }
//            } else {
//                $return = array(
//                    'status' => array(
//                        'code' => "1004",
//                        'string' => "ログインが失敗しました。入力した情報を再確認して下さい。"
//                    ),
//                );
//                return json_encode($return);
//            }
//        }
//    }
    public function addcard() {
        $this->autoRender = FALSE;
        $this->loadModel('Customer');
        $this->loadModel('CardShop');
        $this->loadModel('ChangedLog');
        $this->loadModel('Shop');
        $this->loadModel('Gift');
        if ($this->request->is('get')) {
//            if (isset($this->request->data['access_token'])) {
//                $clerk = $this->Clerk->find('first', array('conditions' => array('access_token' => $this->request->data['access_token'])));
//                if (empty($clerk)) {
//                   $return = array(
//                    'status' => array(
//                        'code' => PointRemakeConst::API_STATUS_CODE_AUTH,
//                        'string' => PointRemakeConst::API_STATUS_CODE_AUTH_MSG
//                    ),
//                );
//                return json_encode($return);
//                }
            if (isset($this->request->query['card_name'])) {
                $shop = $this->Shop->find('first', array('conditions' => array('id' => 2)));

                $this->request->data['Customer']['card_name'] = $this->request->query['card_name'];
                $result = $this->Customer->find('first', array('conditions' => array('card_name' => $this->request->data['Customer']['card_name'])));
                if (!isset($this->request->query['point'])) {
                    if (empty($result)) {
                        $point = 0;
                        $return = array(
                            'status' => array(
                                'code' => PointRemakeConst::API_STATUS_CODE_SUCCESS,
                                'string' => PointRemakeConst::API_STATUS_CODE_SUCCESS_MSG
                            ),
                            'data' => array(
                                'point' => $point,
                            ),
                        );
                        return json_encode($return);
                    } else {
                        $cardshop = $this->CardShop->find('first', array('conditions' => array('card_id' => $result['Customer']['id'], 'shop_id' => 2)));
                        if (isset($cardshop)) {
                            $point = $cardshop['CardShop']['point'];
                            $return = array(
                                'status' => array(
                                    'code' => PointRemakeConst::API_STATUS_CODE_SUCCESS,
                                    'string' => PointRemakeConst::API_STATUS_CODE_SUCCESS_MSG
                                ),
                                'data' => array(
                                    'point' => $point,
                                ),
                            );
                            return json_encode($return);
                        } else {
                            $point = 0;
                            $return = array(
                                'status' => array(
                                    'code' => PointRemakeConst::API_STATUS_CODE_SUCCESS,
                                    'string' => PointRemakeConst::API_STATUS_CODE_SUCCESS_MSG
                                ),
                                'data' => $point,
                            );
                            return json_encode($return);
                        }
                    }
                } else {
                    if (empty($result)) {
                        $this->Customer->create();
                        $success = $this->Customer->saveAssociated($this->request->data);
                        if ($success) {
                            $card = $this->Customer->find('first', array('conditions' => array('card_name' => $this->request->data['Customer']['card_name'])));
                            $data = array(
                                'CardShop' => array(
                                    'card_id' => $card['Customer']['id'],
                                    'shop_id' => 2,
                                    'point' => $this->request->query['point'],
                                ),
                            );
                            $this->CardShop->create();
                            if ($this->CardShop->saveAssociated($data)) {
//                                $this->addlog($card, $clerk);
                                $stamp = $this->request->query['point'] / $shop['Shop']['stamp_to_point'];
                                $gift = $this->Gift->find('all', array('conditions' => array('shop_id' => 2, 'stamp' <= $stamp)));
                                $customer_gift = null;
                                if (!empty($gift)) {
                                    $customer_gift = $gift[count($gift) - 1]['Gift'];
                                }
                                $return = array(
                                    'status' => array(
                                        'code' => PointRemakeConst::API_STATUS_CODE_SUCCESS,
                                        'string' => PointRemakeConst::API_STATUS_CODE_SUCCESS_MSG
                                    ),
                                    'data' => $customer_gift,
                                );
                                return json_encode($return);
                            }
                        }
                    } else {
                        $cardshop = $this->CardShop->find('first', array('conditions' => array('card_id' => $result['Customer']['id'], 'shop_id' => 2)));
                        if (empty($cardshop)) {
                            $data = array(
                                'CardShop' => array(
                                    'card_id' => $result['Customer']['id'],
                                    'shop_id' => 2,
                                    'point' => $this->request->query['point'],
                                ),
                            );
                            $this->CardShop->create();
                            if ($this->CardShop->saveAssociated($data)) {
//                                $this->addlog($result, $clerk);
                                $stamp = $this->request->query['point'] / $shop['Shop']['stamp_to_point'];
                                $gift = $this->Gift->find('all', array('conditions' => array('shop_id' => 2, 'stamp' <= $stamp)));
                                $customer_gift = null;
                                if (!empty($gift)) {
                                    $customer_gift = $gift[count($gift) - 1]['Gift'];
                                }
                                $return = array(
                                    'status' => array(
                                        'code' => PointRemakeConst::API_STATUS_CODE_SUCCESS,
                                        'string' => PointRemakeConst::API_STATUS_CODE_SUCCESS_MSG
                                    ),
                                    'data' => $customer_gift,
                                );
                                return json_encode($return);
                            }
                        } else {
                            $this->CardShop->id = $cardshop['CardShop']['id'];
                            if ($this->CardShop->saveField('point', $this->request->query['point'] + $cardshop['CardShop']['point'])) {

//                                $this->addlog($result, $clerk);
                                $stamp = ($cardshop['CardShop']['point'] + $this->request->query['point'] ) / $shop['Shop']['stamp_to_point'];
                                $gift = $this->Gift->find('all', array('conditions' => array('shop_id' => 2, 'stamp' <= $stamp)));
                                $customer_gift = null;
                                if (!empty($gift)) {
                                    $customer_gift = $gift[count($gift) - 1]['Gift'];
                                }
                                $return = array(
                                    'status' => array(
                                        'code' => PointRemakeConst::API_STATUS_CODE_SUCCESS,
                                        'string' => PointRemakeConst::API_STATUS_CODE_SUCCESS_MSG
                                    ),
                                    'data' => $customer_gift,
                                );
                                return json_encode($return);
                            }
                        }
                    }
                }
            } else {
                $return = array(
                    'status' => array(
                        'code' => PointRemakeConst::API_STATUS_CODE_NOT_PARMA,
                        'string' => PointRemakeConst::API_STATUS_CODE_NOT_PARMA_MSG
                    ),
                );
                return json_encode($return);
            }
//            } else {
//                $return = array(
//                    'status' => array(
//                        'code' => PointRemakeConst::API_STATUS_CODE_AUTH,
//                        'string' => PointRemakeConst::API_STATUS_CODE_AUTH_MSG
//                    ),
//                );
//                return json_encode($return);
//            }
        }
    }

}
