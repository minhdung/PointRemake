<div class="shops">
    <?php echo $this->Form->create('Shop'); ?>
    <fieldset>
        <legend><?php echo __('Change Password'); ?></legend>
        <?php
        echo $this->Form->input('shop_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.Shop.id')));
        echo $this->Form->input('current_password', array('type' => 'password'));
        echo $this->Form->input('password', array('label' => 'New Passord'));
        echo $this->Form->input('confirm_password', array('type' => 'password'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>