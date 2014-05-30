<!-- app/View/Users/add.ctp -->
<div class="clerks">
    <?php echo $this->Form->create('Clerk'); ?>
    <fieldset>
        <legend><?php echo __('Edit Clerk'); ?></legend>
        <?php
        echo $this->Form->input('Clerk.clerk_login');
        echo $this->Form->input('Clerk.password');
        echo $this->Form->input('Clerk.clerk_name');
        echo $this->Form->input('Clerk.shop_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.Shop.id')));
        ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>