<div>
    <?php echo $this->Form->create('Shop'); ?>
    <fieldset>
        <legend><?php echo __('Edit Stamp to point'); ?></legend>
        <?php
        echo $this->Form->input('Shop.stamp_to_point');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>