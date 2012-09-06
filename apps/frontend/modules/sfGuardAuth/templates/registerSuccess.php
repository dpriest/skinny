<div class="fiftypercent">
  <form action="<?php echo url_for('@register') ?>" method="post" id='register'>
    <fieldset>
      <legend><?php echo '注册' ?></legend>
      <?php echo $form->renderGlobalErrors() ?>
      <div class="form-row">
      <?php echo $form['username']->renderLabel('用户名'); ?>
      <?php echo $form['username']->render(); ?>
      </div>
      <div id="status"></div>
      <?php echo $form['email']->renderRow(array(), '注册邮箱') ?>
      <?php echo $form['password']->renderRow(array(), '密码') ?>
      <?php echo $form['password2']->renderRow(array(), '再输入一次密码') ?>
    </fieldset>
    <p style="text-align:center">
      <?php echo $form['_csrf_token'] ?>
      <input type="submit" value="<?php echo '确定注册' ?>" />
    </p>
  </form>
</div>
<div class="fiftypercent">
  <h2>为什么需要注册？</h2>   
  <p>注册用户之后，你可以创建和保存自己的事项</p>
  <h2>隐私</h2>   
  <p>我们不会将你的email泄漏给其他人</p>
  <h2>已经注册过了</h2>   
  <p>你已经有账户了？</p>
  <form>
  <?php echo button_to('登录', '@sf_guard_signin') ?>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function(){

    $("#user_username").change(function() { 

        var usr = $("#user_username").val();

        if(usr.length >= 3)
        {
            $("#status").html('<img src="/images/loader.gif" align="absmiddle">&nbsp;正在验证用户名...');

            $.ajax({
                type: "POST",
                url: "<?php echo url_for('ajax_check_username'); ?>",
                data: "username="+ usr,  
                success: function(msg){  

                 $("#status").ajaxComplete(function(event, request, settings){
                    $('#status').html(msg);
                });

             } 

         }); 

        }
        else
        {
            $("#status").html('<font color="red">用户名至少要<strong>3</strong> 位</font>');
        }

    });

});
</script>