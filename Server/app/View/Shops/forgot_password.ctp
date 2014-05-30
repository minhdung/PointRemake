<div class="shops">
    <?php echo $this->Form->create('Shop'); ?>
    <fieldset>
        <legend>Forgot Password</legend>
        <p>Enter your account, we will send new password into registered email.</p>
        <?php
        echo $this->Form->input('shop_login');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>