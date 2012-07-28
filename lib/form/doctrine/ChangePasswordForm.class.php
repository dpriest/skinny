<?php

class ChangePasswordForm extends BasesfGuardUserForm
{
  /**
   * Form configuration
   */
  public function configure()
  {
    // widgets
    $this->setWidgets(array(
      'currentpassword'   => new sfWidgetFormInputPassword(),
      'password'          => new sfWidgetFormInputPassword(),
      'password2'         => new sfWidgetFormInputPassword(),
    ));

    // helps
    $this->widgetSchema->setHelps(array(
      'currentpassword'     => '请输入您当前的密码',
      'password'  => '密码至少需要6位',
      'password2' => '请再输入一次密码',
    ));

    // validators
    $this->setValidators(array(
      'currentpassword'  => new sfValidatorString(array('min_length' => 6, 'max_length' => 128), array('required'=> '请输入密码', 'min_length'=>'密码太短', 'max_length'=>'密码太长')),
      'password'  => new sfValidatorString(array('min_length' => 6, 'max_length' => 128), array('required'=> '请输入密码', 'min_length'=>'密码太短', 'max_length'=>'密码太长')),
      'password2' => new sfValidatorString(array('min_length' => 6, 'max_length' => 128), array('required'=> '请输入密码', 'min_length'=>'密码太短', 'max_length'=>'密码太长')),
    ));

    // post validator
    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorSchemaCompare('password', '==', 'password2', array(), array('invalid'=>'密码不一致')),
      new sfValidatorDoctrineUnique(array('model'  => 'sfGuardUser', 'column' => 'username'), array('invalid'=>'用户名已被注册')),
      new sfValidatorDoctrineUnique(array('model'  => 'sfGuardUser', 'column' => 'email'), array('invalid'=>'该邮箱已经注册过'))
    )));

    $this->validatorSchema->setPostValidator(new sfGuardUserChangePasswordValidator(array('user_id' =>$this->getOption('user_id'))));
    $this->mergePostValidator(new sfValidatorSchemaCompare('new_password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => '两次的密码相同')));

    $this->widgetSchema->setNameFormat('user[%s]');

    $oDecorator = new sfWidgetFormSchemaFormatterDiv($this->getWidgetSchema());
    $this->getWidgetSchema()->addFormFormatter('div', $oDecorator);
    $this->getWidgetSchema()->setFormFormatterName('div'); 
  }

}
