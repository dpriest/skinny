<?php

/**
 * SkinnyList form.
 *
 * @package    combo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SkinnyListForm extends BaseSkinnyListForm
{
  public function configure()
  {
    $this->useFields(array(
      'name',
      'private',
      'id',
      'description'
    ));
    $this->widgetSchema->setLabels(array(
      'name'    => '事项名称',
      'private'   => '私有',
      'description' => '描述',
    ));

    // helps
    $this->widgetSchema->setHelps(array(
      'name'  => '给这个事项添加一个标题',
      'description'     => '你可以在这里写一个简短的描述',
      'private' => '如果你不想公开你的事项可以选中这个'
    ));

    $this->setDefault('private', false);

    $oDecorator = new sfWidgetFormSchemaFormatterDiv($this->getWidgetSchema());
    $this->getWidgetSchema()->addFormFormatter('div', $oDecorator);
    $this->getWidgetSchema()->setFormFormatterName('div');

  }
}
