<div class="shops">
    <fieldset>
        <legend>Shop Acount</legend>
        <?php
        echo '<p>Shop Login: '.$shop['shop_login'].'</p>';
        echo '<small>Create Time: '.$shop['created'].'</small>  ||  ';
        echo '<small>Update Time: '.$shop['updated'].'</small><br /><br />';
        echo $this->Html->link('Change password', array('controller' => 'shops', 'action' => 'changePassword', $this->Session->read('Auth.Shop.id')));
        ?>
    </fieldset>
</div>