<div>
    <fieldset>
        <legend> All Clerks</legend>
        <table>
            <tr>
                <th>Id</th>
                <th>Clerk Login</th>
                <th>Clerk Name</th>
                <th>Action</th>
                <th>Created</th>
                <th>Updated</th>
            </tr>

            <!-- Here is where we loop through our $posts array, printing out post info -->

            <?php foreach ($clerks as $clerk): ?>
                <tr>
                    <td><?php echo $clerk['Clerk']['id']; ?></td>
                    <td><?php echo $clerk['Clerk']['clerk_login']; ?></td>
                    <td><?php echo $clerk['Clerk']['clerk_name']; ?></td>
                    <td>
                        <?php echo $this->Html->link('Edit', array('controller' => 'shops', 'action' => 'clerkEdit', $clerk['Clerk']['id'])); ?>
                        <?php echo $this->Form->postLink('Delete', array('controller' => 'shops', 'action' => 'clerkDelete', $clerk['Clerk']['id']), array('confirm' => 'Are you sure?')); ?>
                    </td>
                    <td><?php echo $clerk['Clerk']['created']; ?></td>
                    <td><?php echo $clerk['Clerk']['updated']; ?></td>
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
        <h1><?php echo $this->Html->link('Add clerk', array('controller' => 'shops', 'action' => 'clerkAdd')); ?></h1>
    </fieldset>
</div>