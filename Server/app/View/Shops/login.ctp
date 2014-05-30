<div class="shops">
    <?php echo $this->Form->create('Shop'); ?>
    <fieldset>
        <legend>
            <?php echo __('Please enter your Shop_login and Password'); ?>
        </legend>
        <?php
        echo $this->Form->input('shop_login');
        echo $this->Form->input('password');
        echo $this->Html->link('Forgot password', array('controller' => 'shops', 'action' => 'forgotPassword'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Login')); ?>
</div>