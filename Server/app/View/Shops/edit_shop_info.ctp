<div class="shops">
    <?php echo $this->Form->create('Shop'); ?>
    <fieldset>
        <legend><?php echo __('Edit Shop Information'); ?></legend>
        <?php
        echo $this->Form->input('shop_name');
        echo $this->Form->input('shop_address');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>