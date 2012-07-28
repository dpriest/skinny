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

<script type="text/javascript">
  $('.icon-delete').live('click',function(){
    var agree=confirm("你确定要删除这条事项？");
    if (!agree) return;
    item_id = $(this).attr('id');
    var r = $.ajax({
      type: 'POST',
      url: '/list/delete/'+item_id,
      async: false,
      error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert('网络连接出错。请稍后再试！');
        },
      success: function(data){
        $('#'+item_id).parent().remove();
      }
    }).responseText;
    return r;
  });
</script>