<?php 
echo javascript_include_tag('form.js');
echo stylesheet_tag('jquery-ui-1.7.1/ui-studio/jquery-ui-1.7.1.custom.css'); 
?>
<?php use_helper('I18N') ?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <table>
    <?php echo $form ?>
  </table>

  <input type="submit" value="<?php echo __('登录') ?>" />
  <a href="<?php echo url_for('@sf_guard_password') ?>"><?php echo __('忘记密码？') ?></a>
</form>
