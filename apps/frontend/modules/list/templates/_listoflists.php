  <ul class="listoflists">
    <?php foreach ($lists as $list):?>
    <li>
    	<!-- delete icon -->
    	<div class="ui-icon ui-icon-closethick icon-delete" id='<?php echo $list->id?>'></div>
    	<!-- /delete icon -->
    	<?php echo link_to($list->name, 'list/show?slug='.$list->slug)?>&nbsp;
    <span class="shortdesc"><?php echo link_to($list->getShortDescription(50).'....','list/show?slug='.$list->slug )?></span><?php echo $list->private ? image_tag('lock.png', array('alt' => 'list is private', 'title' => 'private')) : ''?>
    </li>
    <?php endforeach ?>
  </ul>

