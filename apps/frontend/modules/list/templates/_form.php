<div class="fiftypercent">
  <form action="<?php echo url_for('list/'.($form->getObject()->isNew() ? 'new':'update?id='.$form->getObject()->id)) ?>" method="post">
      <fieldset>
        <legend>新建事项</legend>
        <?php echo $form->renderGlobalErrors() ?>
        <?php echo $form['id']->render() ?>
        <?php echo $form['name']->renderRow() ?>
        <?php echo $form['description']->renderRow() ?>
        <?php echo $form['private']->renderRow() ?>
      </fieldset>
      <p style="text-align:center">
        <?php echo $form['_csrf_token'] ?>
        <input type="submit" value="<?php echo $form->getObject()->isNew() ? '创建事项' : '保存' ?>" />
      </p>
  </form>
</div>
