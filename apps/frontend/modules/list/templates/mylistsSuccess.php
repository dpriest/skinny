<div class="title_head"><h1>我的事项</h1></div>

<?php if (count($lists) ):?>
  <div class="right"><?php echo link_to('新建事项', 'list/new', array('class'=>'pinkrounded'))?></div>
  <?php include_partial('listoflists', array('lists' => $lists)) ?>
<?php else:?>
  <div class="msgcenter">
    <h2 style="margin-bottom:50px;">You haven't created any list yet</h2>
    <h3><?php echo link_to('新建事项', 'list/new', array('class'=>'pinkrounded'))?></h3>
  </div>
<?php endif?>

