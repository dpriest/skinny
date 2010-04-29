<?php

/**
 * list actions.
 *
 * @package    skinny
 * @subpackage list
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class listActions extends sfActions
{
  //hijack to add an owner credential
  public function getCredential()
  {
    $list = $this->retrieveSkinnyList();
    if ($list && $this->getUser()->isOwnerOf($list)){
      $this->getUser()->addCredential('owner');
    }else{
      $this->getUser()->removeCredential('owner');
    }
    // the hijack is over, let the normal flow continue:
    return parent::getCredential();
  }

  protected function retrieveSkinnyList(){
    if($id = $this->getRequest()->getParameter('id'));
    $list = Doctrine::getTable('SkinnyList')->find(array($id));
    return $list;
  }

  public function executeIndex(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated()){
      $this->redirect('list/mylists');
    }
    $this->lists = Doctrine_Query::create()->
      from('SkinnyList l')->
      orderby('l.updated_at DESC')->
      limit('10')->
      execute();

  }

  public function executeShow(sfWebRequest $request)
  {
    $this->list = $this->getRoute()->getObject();
    $this->forward404Unless($this->list);
    $items = Doctrine::getTable('SkinnyItem')->findAllSortedWithParent($this->list->id, 'list_id', 'ASCENDING');
    $this->rows = array();
    foreach ($items as $key => $item){
      $this->rows[$key] = array( 
        'item' => $item, 
        'form' => new SkinnyItemForm($item) );
    }
    $this->owner = $this->getUser()->isOwnerOf($this->list);
  }

  public function executePrint(sfWebRequest $request)
  {
      $this->list = $this->retrieveSkinnyList();
      $this->forward404Unless($this->list);
      $this->items = Doctrine::getTable('SkinnyItem')->findAllSortedWithParent($this->list->id, 'list_id', 'ASCENDING');
  }

  public function executeNew(sfWebRequest $request)
  {
    $list = new SkinnyList(); 
    $list->user_id = $this->getUser()->getGuardUser()->getId();
    $this->form = new SkinnyListForm($list);
    if ($request->isMethod('post')){
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid()){
        $list = $this->form->save();
        $this->redirect('list/show?slug='.$list->slug);
      }
    }
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($skinny_list = Doctrine::getTable('SkinnyList')->find(array($request->getParameter('id'))), sprintf('Object skinny_list does not exist (%s).', $request->getParameter('id')));
    $skinny_list->delete();

    $this->redirect('list/index');
  }

  public function executeSort($request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $jsarray = $request->getParameter("sortarr");
    $obj = json_decode($jsarray); 
    $pos = 1;
    foreach ($obj as $item_id){
      $item = Doctrine::getTable('SkinnyItem')->find(substr($item_id,5));
      $item->moveToPosition($pos);
      $item->save();
      $pos++;
    }
    return sfView::NONE;
  }
  
  public function executeDeleteSkinnyItem($request)
  {
    $item = Doctrine::getTable('Skinnyitem')->find(array($request->getParameter('item_id')));
    //Security check
    $this->forward404unless($item->list_id == $request->getParameter('id'));
    $item->delete();
    return sfView::NONE;
  }

  public function executeUpdateSkinnyItem($request)
  {
    $item = Doctrine::getTable('Skinnyitem')->find(array($request->getParameter('item_id')));
    //Security check
    $this->forward404unless($item->list_id == $request->getParameter('id'));
    $form = new SkinnyItemForm($item);
    $form->bind($request->getParameter($form->getName()));
    if($form->isValid()){
      $item = $form->save();
    }
    return $this->renderPartial('item', array('item' => $item, 'include_dashboard_links' => true, 'form' => $form, 'owner' => true));
  }

  public function executeAddSkinnyItem($request)
  {
    $this->forward404unless($request->isXmlHttpRequest());

    $item = new SkinnyItem();
    $item->list_id = $request->getParameter('id');
    $item->moveToLast();
    $item->save();
    $form = new SkinnyItemForm($item);

    return $this->renderPartial('item', array('item' => $item, 'include_dashboard_links' => true, 'form' => $form, 'owner' => true));
  }

  public function executeCheckItem($request)
  {
    $this->forward404unless($request->isXmlHttpRequest());
    $check = new SkinnyCheck();
    $check->item_id = $request->getParameter('id');
    $check->user_id = $this->getUser()->getGuardUser()->id;
    $check->save();
    return sfView::NONE;
  }

  public function executeUncheckItem($request)
  {
    $this->forward404unless($request->isXmlHttpRequest());
    $q = Doctrine_Query::create()
      ->delete('SkinnyCheck')
      ->addWhere('item_id = ?', $request->getParameter('id'))
      ->addWhere('user_id = ?', $this->getUser()->getGuardUser()->id);
    $deleted = $q->execute();
    return sfView::NONE;
  }

  public function executeMylists($request)
  {
    $this->lists = Doctrine_Query::create()->
      from('SkinnyList l')->
      where('l.user_id = ?', $this->getUser()->getGuardUser()->id )->
      orderby('l.id DESC')->
      execute();
  }
}
