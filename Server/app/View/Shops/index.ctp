<div class='shops'>
    <fieldset>
        <legend>Shop Info</legend>
        <?php
        echo '<p>Shop Name: ' . $shop['Shop']['shop_name'] . '</p>';
        echo '<p>Address: ' . $shop['Shop']['shop_address'] . '</p>';
        echo '<p>Mail: ' . $shop['Shop']['shop_mail'] . '</p>';
        echo $this->Html->link('Edit Information Shop', array('controller' => 'shops', 'action' => 'editShopInfo', $this->Session->read('Auth.Shop.id')));
        ?>
    </fieldset>
</div>