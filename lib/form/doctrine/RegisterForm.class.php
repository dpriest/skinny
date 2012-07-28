<?php

/* 
* This code comes from http://symfonians.org/browser/trunk/lib/form/RegisterForm.class.php
*/

class RegisterForm extends BasesfGuardUserForm
{
  /**
   * Form configuration
   */
  public function configure()
  {
    // widgets
    $this->setWidgets(array(
      'username'  => new sfWidgetFormInput(),
      'email'     => new sfWidgetFormInput(),
      'password'  => new sfWidgetFormInputPassword(),
      'password2' => new sfWidgetFormInputPassword(),
    ));

    // helps
    $this->widgetSchema->setHelps(array(
      'username'  => '支持英文、数字、"_"或减号',
      'email'     => '请输入有效的email地址，一封激活邮件会发到该email',
      'password'  => '密码不得少于6位',
      'password2' => '请再输入一次密码',
    ));

    // validators
    $this->setValidators(array(
        'username'  => new sfValidatorAnd(
            array(
                new sfValidatorString(array('min_length' => 3, 'max_length' => 20)),
                new sfValidatorRegex(array('pattern' => '/^[a-zA-Z]([a-zA-Z0-9._-]+)$/'), array('invalid' => 'Name "%value%" contains forbidden characters')),
            ), 
            array('required'=>true), 
            array('required' => '请输入用户名')),
        'email'     => new sfValidatorAnd(
            array(
                new sfValidatorString(array('max_length' => 100)),
                new sfValidatorEmail(),
            ),
            array('required'=>true), 
            array('required' => '请输入邮箱')),
        'password'  => new sfValidatorString(array('min_length' => 6, 'max_length' => 128), array('required'=> '请输入密码', 'min_length'=>'密码太短', 'max_length'=>'密码太长')),
        'password2' => new sfValidatorString(array('min_length' => 6, 'max_length' => 128), array('required'=> '请输入密码')),
    ));

    // post validator
    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorSchemaCompare('password', '==', 'password2', array(), array('invalid'=>'密码不一致')),
      new sfValidatorDoctrineUnique(array('model'  => 'sfGuardUser', 'column' => 'username'), array('invalid'=>'用户名已被注册')),
      new sfValidatorDoctrineUnique(array('model'  => 'sfGuardUser', 'column' => 'email'), array('invalid'=>'该邮箱已经注册过'))
    )));

    $this->widgetSchema->setNameFormat('user[%s]');

    $oDecorator = new sfWidgetFormSchemaFormatterDiv($this->getWidgetSchema());
    $this->getWidgetSchema()->addFormFormatter('div', $oDecorator);
    $this->getWidgetSchema()->setFormFormatterName('div'); 
  }

}
