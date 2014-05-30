<div class="shops">
    <?php echo $this->Form->create('Shop'); ?>
    <fieldset>
        <legend><?php echo __('Register'); ?></legend>
        <?php
        echo $this->Form->input('shop_login');
        echo $this->Form->input('password');
        echo $this->Form->input('confirm_password', array('type' => 'password'));
        echo $this->Form->input('shop_mail');
        echo $this->Form->input('shop_name');
        echo $this->Form->input('shop_address');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>