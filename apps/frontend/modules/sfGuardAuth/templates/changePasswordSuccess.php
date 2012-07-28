<div class="fiftypercent">
  <form action="<?php echo url_for('@changePassword') ?>" method="post">
    <fieldset>
      <legend><?php echo '更改密码' ?></legend>
      <?php echo $form->renderGlobalErrors() ?>
      <?php echo $form['currentpassword']->renderRow(array(), '当前密码') ?>
      <?php echo $form['password']->renderRow(array(), '新密码') ?>
      <?php echo $form['password2']->renderRow(array(), '再输入一次新密码') ?>
    </fieldset>
    <p style="text-align:center">
      <?php echo $form['_csrf_token'] ?>
      <input type="submit" value="<?php echo '更改密码' ?>" />
    </p>
  </form>
</div>
