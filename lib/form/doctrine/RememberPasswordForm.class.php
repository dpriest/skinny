<?php

class RememberPasswordForm extends BasesfGuardUserForm
{
  /**
   * Form configuration
   */
  public function configure()
  {
    // widgets
    $this->setWidgets(array(
      'email'   => new sfWidgetFormInput(),
    ));

    // helps
    $this->widgetSchema->setHelps(array(
      'email'     => '输入你的邮箱，我们会将密码发送过去',
    ));

    // validators
    $this->setValidators(array(
      'email'  => new sfGuardUserRememberPasswordValidator(),
    ));

    $this->widgetSchema->setNameFormat('choosepass[%s]');

    $oDecorator = new sfWidgetFormSchemaFormatterDiv($this->getWidgetSchema());
    $this->getWidgetSchema()->addFormFormatter('div', $oDecorator);
    $this->getWidgetSchema()->setFormFormatterName('div'); 
  }

}
