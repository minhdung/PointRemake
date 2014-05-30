<?php

/**
 * @author DungTM<dungtm@rikkeisoft.com>
 */
class CustomersController extends AppController {

    const LIMIT_RECORDS = 30;

    var $name = 'Customers';
    var $uses = array('Card', 'CardShop', 'Gift', 'Shop');
    var $components = array('Common', 'Paginator');

    public function login() {
        $this->autoRender = FALSE;
        return json_encode(PointRemakeConst::$header['description']);
    }

    function beforeFilter() {
        $this->layout = FALSE;
        $this->autoRender = false;
    }

    /**
     * ショップ一覧のＡＰＩ
     */
    public function listStore() {

        //GET メソッド
        $params = $this->request->query;
        $auth_token = $params['auth_token'];
        $limit = $params['limit'];
        $load_type = $params['load_type'];
        $time = $params['time'];

        if ($limit == NULL) {
            $limit = self::LIMIT_RECORDS;
        }
        if ($auth_token == NULL) {
            //TODO : return error
            return json_encode(array(
                'status' => array(
                    'code' => ApiConst::API_STATUS_CODE_MISS_PARAM,
                    'message' => ApiConst::API_STATUS_CODE_MISS_PARAM_MSG
                )
            ));
        }
        $card = $this->Card->checkAuth($auth_token);
        if (!$card) {
            //TODO : return error
            return json_encode(array(
                'status' => array(
                    'code' => ApiConst::API_STATUS_CODE_AUTH_TOKEN_NOT_VALID,
                    'message' => ApiConst::API_STATUS_CODE_AUTH_TOKEN_NOT_VALID_MSG
                )
            ));
        }
        $card_id = $card['Card']['id'];
        $conditions = array('CardShop.card_id' => $card_id);

        $opr = '<';
        if (isset($time)) {
            if ($load_type == ApiConst::LOAD_NEW) {
                $opr = '>';
            } elseif ($load_type == ApiConst::LOAD_OLD) {
                $opr = '<';
            }
            $and = array(
                'and' => array(
                    'CardShop.updated ' . $opr => $time
                )
            );
            $conditions = array_merge($conditions, $and);
        }

        $listStore = $this->CardShop->find('all', array('conditions' => $conditions, 'limit' => $limit, 'order' => array('CardShop.updated' => 'DESC')));
        if (!$listStore) {
            return json_encode(array(
                'status' => array(
                    'code' => ApiConst::API_STATUS_CODE_CARD_NOT_REGISTED,
                    'message' => ApiConst::API_STATUS_CODE_CARD_NOT_REGISTED_MSG
                )
            ));
        }
        return json_encode(array(
            'data' => $listStore,
            'status' => array(
                'code' => ApiConst::API_STATUS_CODE_NORMAL,
                'message' => ApiConst::API_STATUS_CODE_NORMAL_MSG
            )
        ));
    }

    /**
     * ポイントチェックＡＰＩ
     */
    function checkPoint() {
        //GET メソッド
        $params = $this->request->query;
        $auth_token = $params['auth_token'];
        $shop_id = $params['shop_id'];
        if ($auth_token == NULL || $shop_id == NULL || !is_numeric($shop_id)) {
            //TODO : return error
            return json_encode(array(
                'status' => array(
                    'code' => ApiConst::API_STATUS_CODE_MISS_PARAM,
                    'message' => ApiConst::API_STATUS_CODE_MISS_PARAM_MSG
                )
            ));
        }
        $card = $this->Card->checkAuth($auth_token);
        if (!$card) {
            //TODO : return error
            return json_encode(array(
                'status' => array(
                    'code' => ApiConst::API_STATUS_CODE_AUTH_TOKEN_NOT_VALID,
                    'message' => ApiConst::API_STATUS_CODE_AUTH_TOKEN_NOT_VALID_MSG
                )
            ));
        }
        $card_id = $card['Card']['id'];
        //自分のポイント取得
        $cardShop = $this->CardShop->find('first', array('conditions' => array('CardShop.card_id' => $card_id, 'CardShop.shop_id' => $shop_id)));
        if (!$cardShop) {
            return json_encode(array(
                'status' => array(
                    'code' => ApiConst::API_STATUS_CODE_CARD_NOT_REGISTED,
                    'message' => ApiConst::API_STATUS_CODE_CARD_NOT_REGISTED_MSG
                )
            ));
        }
        //ショップＩＤチェック
        $shop = $this->Shop->find('first', array('conditions' => array('id' => $shop_id)));
        if (!$shop) {
            return json_encode(array(
                'status' => array(
                    'code' => ApiConst::API_STATUS_CODE_SHOP_NOT_EXIST,
                    'message' => ApiConst::API_STATUS_CODE_SHOP_NOT_EXIST_MSG
                )
            ));
        }
        $now = date('Y-m-d H:i:s');
        //プレゼント一覧取得
        $conditions = array('Gift.shop_id' => $shop_id, 'Gift.start_time < ' => $now, 'Gift.end_time > ' => $now);
        $listGift = $this->Gift->find('all', array('conditions' => $conditions, 'order' => array('Gift.stamp' => 'asc')));
        return json_encode(array(
            'data' => array(
                'shop' => $shop,
                'point' => $cardShop['CardShop']['point'],
                'listGift' => $listGift),
            'status' => array(
                'code' => ApiConst::API_STATUS_CODE_NORMAL,
                'message' => ApiConst::API_STATUS_CODE_NORMAL_MSG
            )
        ));
    }

    /**
     * プレゼントチェックＡＰＩ
     */
    function checkGift() {
        //GET メソッド
        $params = $this->request->query;
        $auth_token = $params['auth_token'];
        $shop_id = $params['shop_id'];
        $gift_id = $params['gift_id'];
        if ($auth_token == NULL || $shop_id == NULL || !is_numeric($shop_id) || $gift_id == NULL || !is_numeric($gift_id)) {
            //TODO : return error
            return json_encode(array(
                'status' => array(
                    'code' => ApiConst::API_STATUS_CODE_MISS_PARAM,
                    'message' => ApiConst::API_STATUS_CODE_MISS_PARAM_MSG
                )
            ));
        }
        //Authen check
        $card = $this->Card->checkAuth($auth_token);
        if (!$card) {
            //TODO : return error
            return json_encode(array(
                'status' => array(
                    'code' => ApiConst::API_STATUS_CODE_AUTH_TOKEN_NOT_VALID,
                    'message' => ApiConst::API_STATUS_CODE_AUTH_TOKEN_NOT_VALID_MSG
                )
            ));
        }
        //ショップＩＤチェック
        $shop = $this->Shop->find('first', array('conditions' => array('id' => $shop_id)));
        if (!$shop) {
            return json_encode(array(
                'status' => array(
                    'code' => ApiConst::API_STATUS_CODE_SHOP_NOT_EXIST,
                    'message' => ApiConst::API_STATUS_CODE_SHOP_NOT_EXIST_MSG
                )
            ));
        }
        //プレゼント詳細
        $gift = $this->Gift->find('first', array('conditions' => array('id' => $gift_id)));
        if (!$gift) {
            return json_encode(array(
                'status' => array(
                    'code' => ApiConst::API_STATUS_CODE_GIFT_NOT_EXIST,
                    'message' => ApiConst::API_STATUS_CODE_GIFT_NOT_EXIST
                )
            ));
        }

        return json_encode(array(
            'data' => $gift,
            'status' => array(
                'code' => ApiConst::API_STATUS_CODE_NORMAL,
                'message' => ApiConst::API_STATUS_CODE_NORMAL_MSG
            )
        ));
    }

}
