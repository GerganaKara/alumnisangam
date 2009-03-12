<?php
// auto-generated by sfPropelCrud
// date: 2009/02/10 08:14:41
?>
<?php

/**
 * user actions.
 *
 * @package    sf_sandbox
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class userActions extends sfActions
{
  public function executeIndex()
  {
    return $this->forward('user', 'pendinglist');
  }

  public function executeList()
  {
    $this->users = UserPeer::doSelect(new Criteria());
  }

  public function executeShow()
  {
    $this->user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->user);
  }

  public function executeCreate()
  {
    $this->user = new User();

    $this->setTemplate('edit');
  }

  public function executeEdit()
  {
    $this->user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->user);
  }

  public function executeUpdate()
  {
    if (!$this->getRequestParameter('id'))
    {
      $user = new User();
    }
    else
    {
      $user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
      $this->forward404Unless($user);
    }

    $user->setId($this->getRequestParameter('id'));
    $user->setUsername($this->getRequestParameter('username'));
    $user->setPassword($this->getRequestParameter('password'));
    $user->setEnrolment($this->getRequestParameter('enrolment'));
    $user->setEnrolflag($this->getRequestParameter('enrolflag'));
    $user->setRoll($this->getRequestParameter('roll'));
    $user->setRollflag($this->getRequestParameter('rollflag'));
    $user->setGraduationyear($this->getRequestParameter('graduationyear'));
    $user->setGraduationyearflag($this->getRequestParameter('graduationyearflag'));
    $user->setBranchId($this->getRequestParameter('branch_id') ? $this->getRequestParameter('branch_id') : null);
    $user->setBranchflag($this->getRequestParameter('branchflag'));
    $user->setDegreeId($this->getRequestParameter('degree_id') ? $this->getRequestParameter('degree_id') : null);
    $user->setDegreeflag($this->getRequestParameter('degreeflag'));
    $user->setSecretquestion($this->getRequestParameter('secretquestion'));
    $user->setSecretanswer($this->getRequestParameter('secretanswer'));
    $user->setIslocked($this->getRequestParameter('islocked', 0));

    $user->save();

    return $this->redirect('user/show?id='.$user->getId());
  }

  public function executeDelete()
  {
    $user = UserPeer::retrieveByPk($this->getRequestParameter('id'));

    $this->forward404Unless($user);

    $user->delete();

    return $this->redirect('user/list');
  }
  
  public function executePendinglist()
  {
  	$c = new Criteria();
  	$c->addJoin(UserPeer::ID, PersonalPeer::USER_ID);
  	$c->addJoin(UserPeer::DEGREE_ID, DegreePeer::ID);
  	$c->addJoin(UserPeer::BRANCH_ID, BranchPeer::ID);
  	$c->add(UserPeer::ISLOCKED, '2');
  	$this->personal = PersonalPeer::doSelect($c);
  	
  }
  
  public function executeManagenewuser()
  {
  	$ids = $this->getRequestParameter('ids');
  	$action = $this->getRequestParameter('action1');
  	$value = 5;
  	if($action == 'approve')
  	{
  		$value = 0;
  	}
  	elseif($action == 'reject')
  	{
  		$value = 1;
  	}
  	$idlist = split(',',$ids);
  	$count = 0;
  	foreach($idlist as $id)
  	{
  		$user = UserPeer::retrieveByPK($id);
  		
		if($user)
		{
			$c = new Criteria();
			$c->add(PersonalPeer::USER_ID, $user->getId());
			$personal = PersonalPeer::doSelectOne($c);
			$name = $personal->getFirstname()." ".$personal->getMiddlename()." ".$personal->getLastname();
			$newmail = $personal->getEmail();
			
			$newpassword = $this->generatePassword();
  			$user->setIslocked($value);
  			$user->setPassword($newpassword);
  			
  			$count++;
  			
			$sendermail = sfConfig::get('app_from_mail');
			$sendername = sfConfig::get('app_from_name');
			$to = $newmail;
			$subject = "Registration request for ITBHU Global Org";
			if($action == 'approve')
			{
				$userrole = new Userrole();
				$userrole->setRoleId('3');
				$userrole->setUserId($id);
				$userrole->save();
				
				$professional = new Professional();
				$professional->setUserId($id);
				$professional->save();
				
				$academic = new Academic();
				$academic->setUserId($id);
				$academic->save();
				
				$user->save();
				$body ='
Dear '.$name.',

Congrats!! You are now connected to ITBHU GLOBAL.

Your Login Details are:

Username: '.$user->getUsername().'
Password: '.$newpassword.'

Admin,
ITBHU Global
';
			}
			elseif($action == 'reject')
			{
				$user->delete();
				$personal->delete();
				$body ='
Dear '.$name.',

Your connect request to ITBHU GLOBAL is not approved as your details couldn\'t be verified. 	


Admin,
ITBHU Global
';
			}
			$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
  			
		}
  	}
  	if($action == 'approve')
  	{
  		if($count == 0)
  		{
  			$this->setFlash('newuseraction', 'No user(s) selected to approve');
  		}
  		else
  		{
  			$this->setFlash('newuseraction', 'You have successfuly approved '.$count.' users');
  		}
  	}
  	elseif($action == 'reject')
  	{
  		if($count == 0)
  		{
  			$this->setFlash('newuseraction', 'No user(s) selected to reject');
  		}
  		else
  		{
  			$this->setFlash('newuseraction', 'You have successfuly rejected '.$count.' users');
  		}
  	}
  	return $this->redirect('user/newregister');
  	
  }
  protected function generatePassword($length = 8)
  {
	  $password = "";
	  $possible = "0123456789abcdefghjkmnpqrstvwxyzBCDEFGHJKMNPQRSTVWXYZ!@$#%"; 
	  $i = 0; 
	  while ($i < $length) 
	  { 
	    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
	    if (!strstr($password, $char)) { 
	      $password .= $char;
	      $i++;
	    }
	  }
	  return $password;
  }
  
  public function executeNewregister()
  {
  	$c = new Criteria();
  	$c->addJoin(UserPeer::ID, PersonalPeer::USER_ID);
  	/*$c->addJoin(UserPeer::BRANCH_ID, BranchPeer::ID);*/
  	$c->add(UserPeer::ISLOCKED, '3');
  	$this->personal = PersonalPeer::doSelect($c);  	
  }
  
 public function executeForgotpasswordform()
 {
 	
 }
  
  public function executeForgotpassword()
  {
  	$email = $this->getRequestParameter('email');
	if($email)
	{
  		$c = new Criteria();
	  	$c->add(PersonalPeer::EMAIL, $email);
	  	$personal = PersonalPeer::doSelectOne($c);
	  	if($personal)
	  	{
		  	$user = $personal->getUser();
		  	
		  	$name = $personal->getFirstname()." ".$personal->getMiddlename()." ".$personal->getLastname();
			$newpassword = $this->generatePassword();
		  	$user->setPassword($newpassword);
		  	$user->save();
		  	
		  	$sendermail = sfConfig::get('app_from_mail');
			$sendername = sfConfig::get('app_from_name');
			$to = $email;
			$subject = "Password reset request for ITBHU Global Org";
			$body ='
		
			Dear '.$name.',
			
			As per your request, your password has been reset.
		
			Your Login Details are:
			
			Username: '.$user->getUsername().'
			Password: '.$newpassword.'
			
			Admin,
			ITBHU Global
			';
			
		  	$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
	  	}
		$this->setFlash('forgotpassword', 'If the Email provided by you is correct and registered, You\'ll recieve a mail soon.' );
  		$this->redirect('user/forgotpasswordform');
	}
  }
	public function handleErrorForgotpassword()
	{
		$this->forward('user','forgotpasswordform');
	}
  	
  public function executeChangepassword()
  {
  	$oldpass = $this->getRequestParameter('oldpassword');
  	$newpass = $this->getRequestParameter('newpassword');
  	if($oldpass)
  	{
		$user = UserPeer::retrieveByPK($this->getUser()->getAttribute('userid'));  		
  		$salt = md5("I am Indian.");
		if(sha1($salt.$oldpass) == $user->getPassword())
		{
			$user->setPassword($newpass);
			$user->save();
			$this->setFlash('changepassword', 'Password changed successfully.' );
			
	  		$c = new Criteria();
		  	$c->add(PersonalPeer::USER_ID, $user->getId());
		  	$personal = PersonalPeer::doSelectOne($c);
		  			  	
		  	$name = $personal->getFirstname()." ".$personal->getMiddlename()." ".$personal->getLastname();
		  	
		  	$sendermail = sfConfig::get('app_from_mail');
			$sendername = sfConfig::get('app_from_name');
			$to = $personal->getEmail();
			$subject = "Password change request for ITBHU Global Org";
			$body ='
		
Dear '.$name.',

Someone, probably you have changed the password.
If its not you, please contact admin as soon as practical.

Admin,
ITBHU Global
';
			
		  	$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
			
		}
		else
		{
			$this->setFlash('changepassword', 'Incorrect Old Password' );			
		}
  	}
  }
  

  public function executeLorform(){
  	$this->lorForId = $this->getRequestParameter('selectedid');
  	$user = UserPeer::retrieveByPK($this->lorForId);
  	$this->fullname = $user->getFullname();
  	//$lorById = $this->getUser()->getAttribute('userid');
  }

  public function executeLor(){
  	$lorById = $this->getUser()->getAttribute('userid');
  	$lorForId = $this->getRequestParameter('lorfor');
 	
  	$lor = new Lor();
  	$lor->setUserId($lorById);
  	$lor->setLocation($this->getRequestParameter('location'));
  	$lor->setEmployer($this->getRequestParameter('employer'));
  	$lor->setPosition($this->getRequestParameter('position'));
  	$lor->setLinkedin($this->getRequestParameter('linkedin'));
  	$lor->setGeneral($this->getRequestParameter('general'));
  	$lor->save();
  	
  	$loruser = new Loruser();
  	$loruser->setLorId($lor->getId());
  	$loruser->setUserId($lorForId);
  	$loruser->save();
  	
  	$this->setFlash('notice', 'Comment saved successfully.');
  	$this->redirect('home/searchform');
  }
	
  public function executeProfile(){
  	$oUserid = $this->getRequestParameter('selectedid');
  }
  
}

