<!-- app/View/Users/add.ctp -->
<div class="clerks">
    <?php echo $this->Form->create('Gift', array('enctype' => 'multipart/form-data', 'type' => 'file')); ?>
    <fieldset>
        <legend><?php echo __('Add Gift'); ?></legend>
        <?php
        echo $this->Form->input('Gift.name');
        echo $this->Form->input('Gift.description');
        echo $this->Form->file('Gift.image');
        echo $this->Form->input('Gift.stamp');
        echo $this->Form->input('Gift.start_time');
        echo $this->Form->input('Gift.end_time');
        echo $this->Form->input('Gift.shop_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.Shop.id')));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>