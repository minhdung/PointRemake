<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author DungTM<dungtm@rikkeisoft.com>
 *  */

App::uses('CakeEmail', 'Network/Email');

class ShopsController extends AppController {

    public $layout = 'template';
    public $helpers = array(
        'Html',
        'Image'
    );
    public $components = array(
        'DebugKit.Toolbar',
        'Image',
        'Common',
        'Paginator',
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'shops',
                'action' => 'login'
            ),
            'authenticate' => array(
                'Basic' => array('userModle' => 'Shop'),
                'Form' => array(
                    'userModel' => 'Shop',
                    'fields' => array(
                        'username' => 'shop_login',
                        'password' => 'password'
                    ),
                )
            ),
            'loginRedirect' => array(
                'controller' => 'shops',
                'action' => 'shopLoginView'
            ),
            'logoutRedirect' => array(
                'controller' => 'shops',
                'action' => 'login'
            )
        ),
        'RequestHandler',
    );

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('login', 'register', 'forgotPassword');
        $this->loadModel('Clerk');
        $this->loadModel('Gift');
    }

    // Acount manager
    public function index() {
        $this->Shop->id = $this->Session->read('Auth.Shop.id');
        if (!$this->Shop->exists()) {
            throw new NotFoundException('Invalid Shop Login');
        }
        //get information shop
        $shop = $this->Shop->findById($this->Shop->id);
        $this->set('shop', $shop);
    }

    public function register() {
        if ($this->request->is('post')) {
            $this->Shop->create();
            if ($this->Shop->save($this->request->data)) {
                return $this->redirect(array('controller' => 'shops', 'action' => 'login'));
            }
            $this->Session->setFlash('The shop info could not be saved. Please, try again');
        }
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Session->setFlash('Login success.');
                return $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash('Invalid Shop Login or Password, try again.');
        }
    }

    public function forgotPassword() {
        if ($this->request->is('post')) {
            $shop = $this->Shop->findByShop_login($this->request->data['Shop']['shop_login']);
            pr($shop);
            if (!empty($shop)) {
                //sent new password for emaill
                $newPassword = $this->Common->rand_string(8);
                $data = array('id' => $shop['Shop']['id'], 'password' => $newPassword);
                if ($this->Shop->save($data)) {
                    $Email = new CakeEmail();
                    $Email->config('admin');
                    $Email->from(array('me@example.com' => 'Point Remake'));
                    $Email->to($shop['Shop']['shop_mail']);
                    $Email->subject('sent new paswword');
                    $Email->send($newPassword);
                    $this->Session->setFlash('New password send into registered email.');
                    $this->redirect(array('controllers' => 'shops', 'action' => 'login'));
                }
                $this->Session->setFlash('Reset password incorrect, please try again.');
            } else {
                $this->Session->setFlash('The account not isset');
            }
        }
    }

    public function logout() {
        $this->Session->setFlash('You have been logout.');
        return $this->redirect($this->Auth->logout());
    }

    public function shopLoginView() {
        $this->Shop->id = $this->Session->read('Auth.Shop.id');
        if (!$this->Shop->exists()) {
            throw new NotFoundException('Invalid Shop ID');
        }
        $shop = $this->Shop->findById($this->Shop->id);
        $this->set('shop', $shop['Shop']);
    }

    public function changePassword($shop_id = null) {
        $this->Shop->id = $shop_id;
        if (!$this->Shop->exists()) {
            throw new NotFoundException('Invalid Shop Login');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Shop->save($this->request->data)) {
                $this->Session->setFlash('You have been modified password.');
                $this->redirect(array('controller' => 'shops', 'action' => 'shopLoginView', $shop_id));
            }
            $this->Session->setFlash('Password could not be modified. Try again.');
        }
    }

    public function editShopInfo($shop_id = null) {
        $this->Shop->id = $shop_id;
        if (!$this->Shop->exists()) {
            throw new NotFoundException('Invalid Shop Login');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Shop->save($this->request->data)) {
                $this->Session->setFlash('Information Shop has been modified.');
                return $this->redirect(array('controller' => 'shops', 'action' => 'index'));
            }
            $this->Session->setFlash('Information Shop could not be modified. Try again.');
        } else {
            $this->request->data = $this->Shop->read(null, $shop_id);
        }
    }

    // Clerk manage

    public function clerkAll() {
        $this->Shop->id = $this->Session->read('Auth.Shop.id');
        if (!$this->Shop->exists()) {
            throw new NotFoundException('Invalid Shop ID');
        }
        $this->Paginator->settings = array(
            'limit' => 3
        );
        $clerks = $this->paginate('Clerk', array('shop_id' => $this->Shop->id));
        $this->set('clerks', $clerks);
    }

    public function clerkAdd() {
        if ($this->request->is('post')) {
            if ($this->Clerk->save($this->request->data)) {
                $this->Session->setFlash('You have been create new Clerk');
                $this->redirect(array('controller' => 'shops', 'action' => 'clerkAll'));
            }
            $this->Session->setFlash('The Clerk could not be saved. Please, try again.');
        }
    }

    public function clerkEdit($clerk_id = null) {
        $this->Clerk->id = $clerk_id;
        if (!$this->Clerk->exists()) {
            throw new NotFoundException('Invalid Clerk ID');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Clerk->save($this->request->data)) {
                $this->Session->setFlash('The Clerk have been modified.');
                $this->redirect(array('controller' => 'shops', 'action' => 'clerkAll'));
            }
            $this->Session->setFlash('The Clerk could not be modified. Please, try again.');
        } else {
            $this->request->data = $this->Clerk->read(null, $clerk_id);
            unset($this->request->data['Clerk']['password']);
        }
    }

    public function clerkDelete($clerk_id = null) {
        $this->request->onlyAllow('post');
        $this->Clerk->id = $clerk_id;
        if (!$this->Clerk->exists()) {
            throw new NotFoundException(__('Invalid clerk'));
        }
        if ($this->Clerk->delete()) {
            $this->Session->setFlash('The clerk deleted');
        }
        $this->Session->setFlash(__('The clerk was not deleted'));
        $this->redirect(array('controller' => 'shops', 'action' => 'clerkAll'));
    }

    // Gift manage
    public function giftAll() {
        $this->Shop->id = $this->Session->read('Auth.Shop.id');
        if (!$this->Shop->exists()) {
            throw new NotFoundException('Invalid Shop ID');
        }
        $this->set('stamp_to_pojnt', $this->Shop->field('stamp_to_point'));
        $this->Paginator->settings = array(
            'limit' => 5,
        );
        $gifts = $this->paginate('Gift', array('shop_id' => $this->Shop->id));
        $this->set('gifts', $gifts);
    }
    
    public function changeStamp(){
        $this->Shop->id = $this->Session->read('Auth.Shop.id');
        if (!$this->Shop->exists()) {
            throw new NotFoundException('Invalid Shop ID');
        }
        if($this->request->is('post')||$this->request->is('put')){
            if($this->Shop->save($this->request->data)){
                $this->Session->setFlash('You have been change Stamp to point');
                $this->redirect(array('action' => 'giftAll'));
            }
            $this->Session->setFlash('Change Stamp to point could not be successed, please try again.');
        }
        $this->request->data = $this->Shop->read(null, $this->Shop->id);
    }

    public function giftAdd() {
        $this->Shop->id = $this->Session->read('Auth.Shop.id');
        if (!$this->Shop->exists()) {
            throw new NotFoundException('Invalid Shop ID');
        }
        if ($this->request->is('post')) {
            //upload icon and poster
            $poster_path = WWW_ROOT . 'img' . DS . 'posters' . DS . 'shop' . $this->data['Gift']['shop_id'];
            $icon_path = WWW_ROOT . 'img' . DS . 'icons' . DS . 'shop' . $this->data['Gift']['shop_id'];
            $poster_file = $poster_path . DS . $this->data['Gift']['image']['name'];
            $icon_file = $icon_path . DS . $this->data['Gift']['image']['name'];
            if ($this->Shop->isUploadedFile($this->data['Gift']['image'])) {
                //move image from tmp to posters
                if (!file_exists($poster_path)) {
                    mkdir($poster_path);
                }
                move_uploaded_file($this->data['Gift']['image']['tmp_name'], $poster_file);
                // resize image for poster
                $this->Image->prepare($poster_file);
                $this->Image->resize(POSTER_WIDTH, POSTER_HEIGHT, 255, 255, 255, FALSE);
                $this->Image->save($poster_file);

                //copy image from posters to icons
                if (!file_exists($icon_path)) {
                    mkdir($icon_path);
                }
                // resize image for icon
                $this->Image->prepare($poster_file);
                $this->Image->resize(ICON_WIDTH, ICON_HEIGHT, 255, 255, 255, FALSE);
                $this->Image->save($icon_file);
            }

            // Save to database
            $this->request->data['Gift']['image'] = $this->data['Gift']['image']['name'];
            if ($this->Gift->save($this->request->data)) {
                $this->Session->setFlash('The gift have been modified.');
                $this->redirect(array('controller' => 'shops', 'action' => 'giftAll'));
            } else {
                $this->Session->setFlash('The gift could not be modified. Please, try again.');
            }
        }
    }

    public function giftEdit($gift_id = null) {
        $this->Gift->id = $gift_id;
        if (!$this->Gift->exists()) {
            throw new NotFoundException('Invalid gift ID');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //upload icon and poster
            $poster_path = WWW_ROOT . 'img' . DS . 'posters' . DS . 'shop' . $this->data['Gift']['shop_id'];
            $icon_path = WWW_ROOT . 'img' . DS . 'icons' . DS . 'shop' . $this->data['Gift']['shop_id'];
            $poster_file = $poster_path . DS . $this->data['Gift']['image']['name'];
            $icon_file = $icon_path . DS . $this->data['Gift']['image']['name'];
            if ($this->Shop->isUploadedFile($this->data['Gift']['image'])) {
                //move image from tmp to posters
                if (!file_exists($poster_path)) {
                    mkdir($poster_path);
                }
                move_uploaded_file($this->data['Gift']['image']['tmp_name'], $poster_file);
                // resize image for poster
                $this->Image->prepare($poster_file);
                $this->Image->resize(POSTER_WIDTH, POSTER_HEIGHT, 255, 255, 255, FALSE);
                $this->Image->save($poster_file);

                //copy image from posters to icons
                if (!file_exists($icon_path)) {
                    mkdir($icon_path);
                }
                // resize image for icon
                $this->Image->prepare($poster_file);
                $this->Image->resize(ICON_WIDTH, ICON_HEIGHT, 255, 255, 255, FALSE);
                $this->Image->save($icon_file);
            }

            // Save to database
            $this->request->data['Gift']['image'] = $this->data['Gift']['image']['name'];
            if ($this->Gift->save($this->request->data)) {
                $this->Session->setFlash('The gift have been modified.');
                $this->redirect(array('controller' => 'shops', 'action' => 'giftAll'));
            } else {
                $this->Session->setFlash('The gift could not be modified. Please, try again.');
            }
        } else {
            $this->request->data = $this->Gift->read(null, $gift_id);
        }
    }

    public function giftDelete($gift_id = null) {
        $this->request->onlyAllow('post');
        $this->Gift->id = $gift_id;
        if (!$this->Gift->exists()) {
            throw new NotFoundException('Invalid gift_id');
        }
        $image = $this->Gift->field('image');
        if ($this->Gift->delete()) {
            $this->Session->setFlash('Gift have been deleted.');
        } else {
            $this->Session->setFlash('Gift could not be deleted. Please, try again.');
        }
        $this->redirect(array('controllers' => 'shops', 'action' => 'giftAll'));
    }
    
    public function statistic(){
        $this->loadModel('ChargeLog');
        $shop_id = $this->Session->read('Auth.Shop.id');
        $this->Shop->id = $shop_id;
        if(!$this->Shop->exists()){
            throw new NotFoundException('Invalid shop_id');
        }
        // Get all year in charge_logs of shop
        $charges = $this->ChargeLog->find('list', array(
            'conditions' => array('ChargeLog.shop_id' => $shop_id),
            'fields' => array('ChargeLog.id', 'created')
        ));
        $all_years = array();
        foreach($charges as $charge){
            $all_years[] = date('Y', strtotime($charge));
        }
        $this->set('all_years',array_unique($all_years));
        $nowYear = date('Y',time());
        $this->set('nowYear', $nowYear);
        
        //request
        if($this->request->is('post')){
            $year = $this->request->data['Statistic']['year'];
            $month = $this->request->data['Statistic']['month'];
        }
        
        if(!isset($year)){
            $year = $nowYear;
        }
        
        if(!isset($month)||$month==0){
            // Statistic by Year
            $this->set('subtitle', $year.'年');
            //time in year
            $start = date('Y-m-d H:i:s', mktime(0,0,0,1,1,$year));
            $end = date('Y-m-d H:i:s', mktime(0,0,0,1,1,$year+1));
            //init
            $categories = array();
            $sales = array();
            $user_trans = array();
            for($i = 1; $i <= 12; $i++){
                $sales[$i] = 0;
                $user_trans[$i] = array();
                $categories[$i] = '"'.$i.'月"';
            }
            //Statistic
            $tmps = $this->ChargeLog->find('all', array(
                'conditions' => array('ChargeLog.shop_id' => $shop_id, 'created >=' => $start, 'created <' => $end)
            ));
            foreach($tmps as $tmp){
                $get_month = date('n', strtotime($tmp['ChargeLog']['created']));
                $sales[$get_month] += $tmp['ChargeLog']['point'];
                $user_trans[$get_month][] = $tmp['ChargeLog']['card_id'];
            }
            $this->set('categories', $categories);
            $this->set('sales', $sales);
            $this->set('user_trans', $user_trans);
        } else{
            // Statistic by Month
            $this->set('subtitle', $year.'年'.$month.'月');
            $start = date('Y-m-d H:i:s', mktime(0,0,0,$month,1,$year));
            $end = date('Y-m-d H:i:s', mktime(0,0,0,$month+1,1,$year));
            //init
            $categories = array();
            $sales = array();
            $user_trans = array();
            $day_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for($i = 1; $i <= $day_in_month; $i++){
                $sales[$i] = 0;
                $user_trans[$i] = array();
                $categories[$i] = '"'.$i.'日"';
            }
            //Statistic
            $tmps = $this->ChargeLog->find('all', array(
                'conditions' => array('ChargeLog.shop_id' => $shop_id, 'created >=' => $start, 'created <' => $end)
            ));
            foreach($tmps as $tmp){
                $get_day = date('j', strtotime($tmp['ChargeLog']['created']));
                $sales[$get_day] += $tmp['ChargeLog']['point'];
                $user_trans[$get_day][] = $tmp['ChargeLog']['card_id'];
            }
            $this->set('categories', $categories);
            $this->set('sales', $sales);
            $this->set('user_trans', $user_trans);
        }
    }

}
