<?php
// auto-generated by sfPropelCrud
// date: 2009/03/10 06:44:12
?>
<?php

/**
 * mag actions.
 *
 * @package    sf_sandbox
 * @subpackage mag
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class magActions extends sfActions
{
  public function executeIndex()
  {
    return $this->forward('mag', 'list');
  }

  public function executeList()
  {
    $this->mags = MagPeer::doSelect(new Criteria());
    $this->count = MagPeer::doCount(new Criteria());
  }

  public function executeShow()
  {
  	$this->userid = $this->getUser()->getAttribute('userid');
    $this->mag = MagPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->mag);
  }

  public function executeCreate()
  {
    $this->mag = new Mag();

    $branches = BranchPeer::doSelect(new Criteria());
  	foreach($branches as $branch)
  	{
  		$branchOptions[$branch->getId()] = $branch->getName();
  	}
  	$this->branchOptions = $branchOptions;
  	for($i=1923; $i<=2013; $i++)
  	{
  		$yearoptions[$i] = $i;
  	}
  	$this->yearoptions = $yearoptions;
    $this->setTemplate('edit');
  }

  public function executeEdit()
  {
    $this->mag = MagPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->mag);
  }

  public function executeUpdate()
  {
    if (!$this->getRequestParameter('id'))
    {
      $mag = new Mag();
    }
    else
    {
      $mag = MagPeer::retrieveByPk($this->getRequestParameter('id'));
      $this->forward404Unless($mag);
    }

    $mag->setId($this->getRequestParameter('id'));
   //$mag->setUserId($this->getRequestParameter('user_id') ? $this->getRequestParameter('user_id') : null);
    $mag->setUserId($this->getUser()->getAttribute('userid'));
    $mag->setMailinggroup($this->getRequestParameter('mailinggroup'));
    $mag->setYear($this->getRequestParameter('year'));
    $mag->setBranch($this->getRequestParameter('branch'));
    $mag->setModeratoremail($this->getRequestParameter('moderatoremail'));
    $mag->setDetails($this->getRequestParameter('details'));

    $mag->save();

    return $this->redirect('mag/show?id='.$mag->getId());
  }

  public function executeDelete()
  {
    $mag = MagPeer::retrieveByPk($this->getRequestParameter('id'));

    $this->forward404Unless($mag);

    $mag->delete();

    return $this->redirect('mag/list');
  }
}
