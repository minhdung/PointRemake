<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('PointRemakeConst', 'Lib/PointRemake/Logic');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
   
    
    public function beforeFilter() {
        $this->set('PointRemakeDescription', PointRemakeConst::$header['description']);
    }

    /**
     * Set view vars and _serialize var for JSON or XML response
     * @param int $code Response code
     * @param array $data Response data
     * @author DungTM<dungtm@rikkeisoft.com>
     */
    protected function _apiResponse($code, $data) {
        $this->set('code', $code);
        $this->set('data', $data);
        $this->set('_serialize', array('code', 'data'));
    }
}
