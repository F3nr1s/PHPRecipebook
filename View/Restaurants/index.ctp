<script type="text/javascript">
    $(function() {
        setSearchBoxTarget('Restaurants');
        
        $(document).on("saved.restaurant", function() {
            $('#editRestaurantDialog').dialog('close');
            ajaxGet('restaurants');
        });
        
        $(".addressQTip").each(function() {
            var $address = $(this).parent().find('address');
            $(this).qtip({
                content: $address,
                position: {
                    my: 'top center',  // Position my top left...
                    at: 'bottom center', // at the bottom right of...
                },
                style: {
                    classes: 'qtip-rounder qtip-shadow',
                    widget: true, // Use the jQuery UI widget classes
                    def: true // Remove the default styling (usually a good idea, see below)  
                },
                show: {
                    event: 'click',
                    effect: function(offset) {
                        $(this).slideDown(400); // "this" refers to the tooltip
                    }
                },
                hide: {
                    event: 'click',
                    effect: function(offset) {
                        $(this).slideUp(400); // "this" refers to the tooltip
                    }
                }
            });
        });
    });
</script>
<div class="restaurants index">
	<h2><?php echo __('Restaurants'); ?></h2>
        <?php if ($loggedIn): ?>
        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('Add Restaurant'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editRestaurantDialog'));?></li>
                <li><button id="moreActionLinks">More Actions...</button></li>
            </ul>
            <div style="display: none;">
                <ul id="moreActionLinksContent">
                    <li><?php echo $this->Html->link(__('List Price Ranges'), array('controller' => 'price_ranges', 'action' => 'index'), array('class' => 'ajaxNavigationLink')); ?> </li>
                    <li><?php echo $this->Html->link(__('New Price Ranges'), array('controller' => 'price_ranges', 'action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editPriceRangesDialog')); ?> </li>
                </ul>
            </div> 
        </div>
        <?php endif;?>
	<table cellpadding="0" cellspacing="0">
	<tr>
        <?php if ($loggedIn  && ($isAdmin || $loggedInuserId == $recipe['User']['id'])):?>
            <th class="actions"><?php echo __('Actions'); ?></th>
        <?php endif;?>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('phone'); ?></th>
            <th><?php echo __('Address');?></th>
            <th><?php echo $this->Paginator->sort('hours'); ?></th>
            <th><?php echo __('Price');?></th>
            <th><?php echo $this->Paginator->sort('comments'); ?></th>
            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
            
	</tr>
    <tbody>
	<?php foreach ($restaurants as $restaurant): ?> 
	<tr>
            <?php if ($loggedIn  && ($isAdmin || $loggedInuserId == $recipe['User']['id'])):?>
            <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $restaurant['Restaurant']['id']), array('class' => 'ajaxLink', 'targetId' => 'editRestaurantDialog')); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $restaurant['Restaurant']['id']), null, __('Are you sure you want to delete # %s?', $restaurant['Restaurant']['id'])); ?>
            </td>
            <?php endif;?>
            <td>
                <?php if (!empty($restaurant['Restaurant']['website'])) { ?>
                <a href="<?php echo $restaurant['Restaurant']['website'];?>" target="_blank">
                    <?php echo $restaurant['Restaurant']['name']; ?>
                </a>
                <?php } else {?>
                    <?php echo $restaurant['Restaurant']['name']; ?>
                <?php } ?>
            </td>
            <td><?php echo h($restaurant['Restaurant']['phone']); ?>&nbsp;</td>
            <td><?php echo $this->Html->image("address_24.png", array('title' => "Add More items for this ingredient", 'alt' => 'Add', 'class' => 'addressQTip'));?>
                <address style="display: none;">
                <?php echo h($restaurant['Restaurant']['street']); ?><br/>
                <?php echo h($restaurant['Restaurant']['city']); ?>, <?php echo h($restaurant['Restaurant']['state']); ?> <?php echo h($restaurant['Restaurant']['zip']); ?><br/>
                <?php echo h($restaurant['Restaurant']['country']); ?>
                </address>
            <td><?php echo $restaurant['Restaurant']['hours']; ?>&nbsp;</td>
            <td><?php echo $restaurant['PriceRange']['name'];?></td>
            <td><?php echo $restaurant['Restaurant']['comments']; ?>&nbsp;</td>
            <td>
            <?php 
            if ($isAdmin) { 
                echo $this->Html->link($restaurant['User']['name'], array('controller' => 'users', 'action' => 'view', $restaurant['User']['id']));
            } else {
                echo $restaurant['User']['name'];
            }?>
            </td>
    </tr>
<?php endforeach; ?>
    </tbody>
	</table>
	<p>
	<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')));?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
