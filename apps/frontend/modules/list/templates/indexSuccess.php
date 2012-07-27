<div class="fiftypercent">
<center>
<div class="title_head_center"><h2>以简单的方式</h2><h1>创建事项</h1>
</div>
<p class="bigtext">简便地创建事项<br/> 尽可能详细地描述你的事项</p>
<div class="register bigtext">
<?php echo link_to('马上注册', '@register',array('class'=>'pinkrounded'))?>
</div>
</center>
</div>
<div class="fiftypercent">
  <?php echo image_tag('screenshot.jpg')?>
</div>

<div class="title_head"><h2>最近发布的事项</h2></div>

<?php if($sf_user->isAuthenticated()):?>
  <div class="right"><?php echo link_to('创建一个新事项', 'list/new')?></div>
<?php endif?>
<?php include_partial('listoflists', array('lists' => $lists)) ?>
