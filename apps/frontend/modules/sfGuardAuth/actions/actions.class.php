<?php

require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

/*
 * There is a lot of code here from http://symfonians.org/browser/trunk/apps/main/modules/sfGuardAuth/actions/actions.class.php
 */


class sfGuardAuthActions extends BasesfGuardAuthActions
{
  public function executeRegister(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->redirect('@homepage');
    }

    $this->form = new RegisterForm();
    $params = $request->getParameter('user', array());

    if (!$request->isMethod('post') or !$this->form->bindAndSave($params))
    {
      return sfView::SUCCESS; // redisplay form with errors
    }

    //users are inactive until they confirm their email accounts
    $user = $this->form->getObject();
    $user->setIsActive(false);
    $user->save();

    // At this point we got a valid form and a created sfGuardUser object

    // Create activation entry
    $activation = new SkinnyActivation();
    $activation->setUserId($user->getId());
    $activation->setHash(md5(rand(100000, 999999)));
    $activation->save();

    $message = Swift_Message::newInstance()
        ->setSubject('激活你的帐号')
        ->setBody($this->getPartial('activationMail', array(
            'username' => $user->username,
            'token'    => $activation->hash
        )))
        ->setFrom(array('listandcheck@googlemail.com' => 'List & Check'))
        ->setTo(array($user->email => $user->username));

    $this->getMailer()->send($message);
    $this->getUser()->setFlash('error', '一封确认邮件已经发往'. $user->email);
    $this->redirect('@homepage');
  }

  public function executeRegisterDone(sfWebRequest $request)
  {
    $this->user = $request->getAttribute('user');
    return sfView::SUCCESS;
  }

  public function executeChangePassword(sfWebRequest $request)
  {
    $this->forward404Unless($this->getUser() && $this->getUser()->isAuthenticated());
    $this->form = new ChangePasswordForm(null, array('user_id' => $this->getUser()->getGuardUser()->getId()));
    if($request->isMethod('post')){
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid()){
        $password = $this->form->getValue('password');
        $user = $this->getUser()->getGuardUser();
        $user->setPassword($password);
        $user->save();
        $this->getUser()->setFlash('notice', '密码修改成功');
        $this->redirect('@homepage');

      }
    }
  } 

  public function executePassword($request)
  {
    $this->form = new RememberPasswordForm();
    if($request->isMethod('post')){
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid()){
        $email = $this->form->getValue('email');
        $user = Doctrine::getTable('sfGuardUser')->findOneByEmail($email);
        $password = substr(md5(rand(100000, 999999)), 0, 8);
        $user->setPasswordForgotten($password);

        $message = Swift_Message::newInstance()
          ->setSubject('Password reminder')
          ->setBody($this->getPartial('forgotPasswordMail', array(
            'username' => $user->username,
            'password'    => $password
          )))
          ->setFrom(array('listandcheck@googlemail.com' => 'List & Check'))
          ->setTo(array($user->email => $user->username));

        $this->getMailer()->send($message);
        $this->getUser()->setFlash('notice', '新密码已发送到'. $user->email);
        $this->redirect('@homepage');

      }else{
          $this->getUser()->setFlash('error', '邮箱地址无效');
      }
    }
  }

  public function executeActivate(sfWebRequest $request)
  {
    $key = $this->getRequestParameter('token');
    $activation = Doctrine::getTable('SkinnyActivation')->
      findOneByHash($key);
    if (!$activation){
      $this->getUser()->setFlash('error', '激活码错误');
      return sfView::ERROR;
    }

    if (!$user = $activation->getUser()){
      $this->getUser()->setFlash('error', '对不起，找不到改激活码对应的用户');
      return sfView::ERROR;
    }
    if ($user->getIsActive()){
      $this->getUser()->setFlash('error', '用户已经激活');
      return sfView::ERROR;
    }

    $user->setIsActive(true);
    $user->save();
    $activation->delete();

    $this->getUser()->setFlash('notice', '你的账户已经成功激活。你现在可以正常登录本网站了');
    $this->redirect('@sf_guard_signin');
  }

}
