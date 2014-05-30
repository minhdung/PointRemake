<?php
/**
 *
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
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('cake.generic');
        echo $this->Html->css('style');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h2><?php echo $this->Html->link('Home', array('controller' => 'shops', 'action' => 'index')); ?></h2>
                <div id='search'>
                    <input type='text' name='search_input' placeholder="search" />
                </div>
                <nav>
                    <ul>
                        <li class="home"><?php echo $this->Html->link('Home', array('controller' => 'shops', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Clerks manage', array('controller' => 'shops', 'action' => 'clerkAll')); ?></li>
                        <li><?php echo $this->Html->link('Gifts manage', array('controller' => 'shops', 'action' => 'giftAll')); ?></li>
                        <li><?php echo $this->Html->link('Sales manage', array('controller' => 'shops', 'action' => 'statistic', date('Y',time()))); ?></li>
                        <li><?php echo $this->Html->link('Contact', array('controller' => 'shops', 'action' => 'index')); ?></li>
                        <li class="last">
                            <?php
                            if (!empty($this->Session->read('Auth.Shop'))) {
                                echo $this->Html->link($this->Session->read('Auth.Shop.shop_login'), array('controller' => 'shops', 'action' => 'shopLoginView'));
                                echo ' | ';
                                echo $this->Html->link('Logout', array('controller' => 'shops', 'action' => 'logout'));
                            } else {
                                echo $this->Html->link('Login', array('controller' => 'shops', 'action' => 'login'));
                                echo ' | ';
                                echo $this->Html->link('Register', array('controller' => 'shops', 'action' => 'register'));
                            }
                            ?>
                        </li>
                    </ul>
                </nav>
            </div>
            <div id="content">
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
            </div>
        </div>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
