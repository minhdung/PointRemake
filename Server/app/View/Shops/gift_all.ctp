<div class="gifts">
    <div style='float: right;'>
        <span>1 Stamp = <?php echo $stamp_to_pojnt;?> Point</span>
        <?php echo $this->Html->link('Edit', array('controller' => 'shops', 'action' => 'changeStamp'))?>
    </div>
    <fieldset>
        <legend> All Gifts</legend>
        <table>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>image</th>
                <th>Stamp</th>
                <th>Start time</th>
                <th>End time</th>
                <th>Action</th>
            </tr>

            <!-- Here is where we loop through our $posts array, printing out post info -->

            <?php foreach ($gifts as $gift): ?>
                <tr>
                    <td><?php echo $gift['Gift']['id']; ?></td>
                    <td><?php echo $gift['Gift']['name']; ?></td>
                    <td><?php echo $gift['Gift']['description']; ?></td>
                    <td><?php echo $this->Image->getGiftImage($gift['Gift'], ICON); ?></td>
                    <td><?php echo $gift['Gift']['stamp']; ?></td>
                    <td><?php echo $gift['Gift']['start_time']; ?></td>
                    <td><?php echo $gift['Gift']['end_time']; ?></td>
                    <td>
                        <?php echo $this->Html->link('Edit', array('controller' => 'shops', 'action' => 'giftEdit', $gift['Gift']['id'])); ?>
                        <?php echo $this->Form->postLink('Delete', array('controller' => 'shops', 'action' => 'giftDelete', $gift['Gift']['id']), array('confirm' => 'Are you sure?')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="paging">
            <?php echo $this->Paginator->first('First'); ?>
            <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>
            |  <?php echo $this->Paginator->numbers(); ?>
            |
            <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->last('Last'); ?>
        </div>
        <br />
        <h1><?php echo $this->Html->link('Add gift', array('controller' => 'shops', 'action' => 'giftAdd')); ?></h1>
    </fieldset>
</div>