<?php

class adminActions extends sfActions
{
	/* Chapters */
	
  public function executeChapters()
  {
	$c = new Criteria();
	$c->addAscendingOrderByColumn(ChapterPeer::NAME);
  	$this->chapters = ChapterPeer::doSelect($c);
    $regions = RegionPeer::doSelect(new Criteria());
    foreach($regions as $region){
  		$regionOptions[$region->getId()] = $region->getName();
  	}
  	$this->regionOptions = $regionOptions;
  }
  
  public function executeAddchapter()
  {
  	$c = new Criteria();
  	$c->add(ChapterPeer::NAME, $this->getRequestParameter('chapter'));
  	$exchapter = ChapterPeer::doSelectOne($c);
  	if($exchapter){
  		$this->setFlash('notice', 'Chapter could not be added. A chapter with this name already exists.');
  	}else{
	    $chapter = new Chapter();
	    $chapter->setName($this->getRequestParameter('chapter'));
	    $chapter->save();
	    
	    $cr = new Chapterregion();
	    $cr->setChapterId($chapter->getId());
	    $cr->setRegionId($this->getRequestParameter('region'));
	  	$cr->save();
	  	
	  	$this->setFlash('notice', 'Chapter <b>'.$chapter->getName().'</b> has been created successfully.');
  	}
  	$this->redirect('admin/chapters');
  }

  public function executeEditchapter(){
  	$c = new Criteria();
  	$c->add(ChapterPeer::NAME, $this->getRequestParameter('chapter'));
  	$exchapter = ChapterPeer::doSelectOne($c);
  	if($exchapter){
  		$this->setFlash('notice', 'Chapter could not be added. A chapter with this name already exists.');
  	}else{
	  	$chaptername = $this->getRequestParameter('chapter');
	  	$regionid = $this->getRequestParameter('region');
	  	$chapter = ChapterPeer::retrieveByPK($this->getRequestParameter('id'));
	  	$chapter->setName($chaptername);
	  	$chapter->save();
	  	
	  	$cr = $chapter->getChapterregion();
	  	$cr->setRegionId($regionid);
	  	$cr->save();
	  	
	  	$this->setFlash('notice', 'Chapter Edited Successfully');
  	}
  	$this->redirect('admin/chapters');
  }
  
  public function executeDeletechapter(){
  	$chapter = ChapterPeer::retrieveByPK($this->getRequestParameter('id'));
  	$cr = $chapter->getChapterregion();
  	
  	$c = new Criteria();
  	$c->add(UserchapterregionPeer::CHAPTERREGION_ID, $cr->getId());
  	$ucount = UserchapterregionPeer::doCount($c);
  	$ucr = UserchapterregionPeer::doSelectOne($c);
  	if($ucr){
  		$this->setFlash('notice', 'Cannot delete chapter. <b>'.$ucount.'</b> user(s) are subscribed to this chapter.');
  	}else{
	  	$chapter->delete();
	  	$cr->delete();
	  	$this->setFlash('notice', 'Chapter Deleted Successfully');
  	}
  	$this->redirect('admin/chapters');
  }
  
  /* User Roles */
  
  public function executeUserroles(){
	$this->type = $this->getRequestParameter('type');
  	$c = new Criteria();
  	$c->add(UserrolePeer::ROLE_ID, sfConfig::get('app_role_'.$this->type));
  	$c->addJoin(UserPeer::ID, UserrolePeer::USER_ID);
  	$c->addAscendingOrderByColumn(UserPeer::GRADUATIONYEAR);
  	$this->userroles = UserrolePeer::doSelect($c);
  }
  
  public function executeRevokerole(){
  	$type = $this->getRequestParameter('type');
  	$userid = $this->getRequestParameter('id');
  	$c = new Criteria();
  	$c->add(UserrolePeer::USER_ID, $userid);
  	$c->add(UserrolePeer::ROLE_ID, sfConfig::get('app_role_'.$type));
  	UserrolePeer::doSelectOne($c)->delete();
  	$this->setFlash('notice', 'Permission Revoked Successfully');
  	$this->redirect('/admin/userroles?type='.$type);
  }
  
  public function executeAssignrole(){
  	$roleid = $this->getRequestParameter('role');
  	$userid = $this->getRequestParameter('assignee');
  	$user = UserPeer::retrieveByPK($userid);
  	
  	$c = new Criteria();
  	$c->add(UserrolePeer::USER_ID, $userid);
  	$c->add(UserrolePeer::ROLE_ID, $roleid);
  	$userrole = UserrolePeer::doSelectOne($c);
  	if($userrole){
  		$this->setFlash('notice', 'This role is already assigned for <b>'.$user->getFullname().'</b>');
  		$this->redirect('/search/result');
  	}
  	
  	$userrole = new Userrole();
  	$userrole->setUserId($userid);
  	$userrole->setRoleId($roleid);
  	$userrole->save();
  	$this->setFlash('notice', 'Role assigned successfully for <b>'.$user->getFullname().'</b>');
  	$this->redirect('/search/result');
  }

    /* Regions */
  
  public function executeRegions(){
  	$c = new Criteria();
  	$c->addAscendingOrderByColumn(RegionPeer::NAME);
  	$this->regions = RegionPeer::doSelect($c);
  }

  public function executeDeleteregion(){
  	$regionid = $this->getRequestParameter('id');
  	$c = new Criteria();
  	$c->add(ChapterregionPeer::REGION_ID, $regionid);
  	$chcount = ChapterregionPeer::doCount($c);
  	$chapterregion = ChapterregionPeer::doSelectOne($c);
  	if($chapterregion){
  		$this->setFlash('notice', 'Region cannot be deleted. <b>'.$chcount.'</b> chapters belong to this region.');
  	}else{
  		$region = RegionPeer::retrieveByPK($regionid);
  		$region->delete();
  		$this->setFlash('notice', 'Region deleted Successfully.');
  	}
  	$this->redirect('admin/regions');
  }
  
  public function executeEditregion(){
  	$c = new Criteria();
  	$c->add(RegionPeer::NAME, $this->getRequestParameter('region'));
  	$exregion = RegionPeer::doSelectOne($c);
  	if($exregion){
  		$this->setFlash('notice', 'Region could not be edited. A Region with this name already exists.');
  	}else{
	  	$region = RegionPeer::retrieveByPK($this->getRequestParameter('id'));
	  	$region->setName($this->getRequestParameter('region'));
	  	$region->save();
	  	$this->setFlash('notice', 'Region Edited Successfuly');
  	}
  	$this->redirect('admin/regions');
  }

  public function executeAddregion(){
  	$c = new Criteria();
  	$c->add(RegionPeer::NAME, $this->getRequestParameter('region'));
  	$exregion = RegionPeer::doSelectOne($c);
  	if($exregion){
  		$this->setFlash('notice', 'Region could not be added. A Region with this name already exists.');
  	}else{
  		$region = new Region();
  		$region->setName($this->getRequestParameter('region'));
  		$region->save();
  		$this->setFlash('notice', 'Region <b>'.$region->getName().'</b> added successfully');
  	}
  	$this->redirect('admin/regions');
  }
  
  /* Branches */
  
  public function executeBranches(){
  	$c = new Criteria();
  	$c->addAscendingOrderByColumn(BranchPeer::NAME);
  	$this->branches = BranchPeer::doSelect($c); 
  }
  
  public function executeDeletebranch(){
  	$branchid = $this->getRequestParameter('id');
  	$c = new Criteria();
  	$c->add(UserPeer::BRANCH_ID, $branchid);
  	$ucount = UserPeer::doCount($c);
  	$exuser = UserPeer::doSelectOne($c);
  	if($exuser){
  		$this->setFlash('notice', 'Branch could not be deleted. <b>'.$ucount.'</b> users are from this branch.');
  	}else{
  		$branch = BranchPeer::retrieveByPK($branchid);
  		$branch->delete();
  		$this->setFlash('notice', 'Branch deleted successfully.');
  	}
  	$this->redirect('/admin/branches');
  }
  
  public function executeEditbranch(){
  	$branchid = $this->getRequestParameter('id');
  	$c = new Criteria();
  	$c->add(BranchPeer::NAME, $this->getRequestParameter('branch'));
  	$c->add(BranchPeer::ID, $branchid, Criteria::NOT_EQUAL);
  	$exbranch = BranchPeer::doSelectOne($c);
  	$c->clear();
  	$c->add(BranchPeer::CODE, $this->getRequestParameter('code'));
  	$c->add(BranchPeer::ID, $branchid, Criteria::NOT_EQUAL);
  	$excode = BranchPeer::doSelectOne($c);
  	if($exbranch){
  		$this->setFlash('notice', 'Brach could not be edited. A branch with same name already exists.');
  	}elseif($excode){
  		$this->setFlash('notice', 'Branch could not be edited. A branch with same code already exists.');
  	}else{
  		$branch = BranchPeer::retrieveByPK($branchid);
  		$branch->setName($this->getRequestParameter('branch'));
  		$branch->setCode($this->getRequestParameter('code'));
  		$branch->save();
  		$this->setFlash('notice', 'Branch Edited successfully.');
  	}
  	$this->redirect('/admin/branches');
  }
  
  public function executeAddbranch(){
  	$c = new Criteria();
  	$c->add(BranchPeer::NAME, $this->getRequestParameter('branch'));
  	$exbranch = BranchPeer::doSelectOne($c);
  	$c->clear();
  	$c->add(BranchPeer::CODE, $this->getRequestParameter('code'));
  	$excode = BranchPeer::doSelectOne($c);
  	if($exbranch){
  		$this->setFlash('notice', 'Branch could not be added. A branch with this name already exists.');
  	}elseif($excode){
  		$this->setFlash('notice', 'Branch could not be added. A branch with this code already exists.');
  	}else{
  		$branch = new Branch();
  		$branch->setName($this->getRequestParameter('branch'));
  		$branch->setCode($this->getRequestParameter('code'));
  		$branch->save();
  		$this->setFlash('notice', 'Branch <b>'.$branch->getName().'</b> with code <b>'.$branch->getCode().'</b> added successfully.');
  	}
  	$this->redirect('/admin/branches');
  }
  
  /* Bulk Upload */
  
  public function executeBulkuploadform(){
  	
  }
	
  public function executeBulkupload(){
		if($this->getRequest()->getFileName('csvfile'))
		{
	    	$fileName = md5($this->getRequest()->getFileName('csvfile').time().rand(0, 99999));
		 	$ext = $this->getRequest()->getFileExtension('csvfile');
		 	$this->getRequest()->moveFile('csvfile', sfConfig::get('sf_upload_dir')."//csvfiles//".$fileName.".csv");
		 	$fullname = $fileName.".csv";
		 	//$fullpath = '/uploads/csvfiles/'.$fullname;
		 	$fp = sfConfig::get('sf_upload_dir')."//csvfiles//".$fileName.".csv";
			$reader = new sfCsvReader($fp, ',', '"');
			$reader->open();
		
			$i=1;
			$exist;
			$ignore;
			$log;
			$ignoreflag = 0;
			$success = 0;
		    while ($data = $reader->read())
		    {
		    	$name[] = array();
		    	$name = explode(' ', $data[0]);
		    	$roll = $data[1];
		    	$enrol = $data[2];
		    	$branch = $data[3];
		    	$degree = $data[4];
		    	$year = $data[5];
		    	
		    	$c = new Criteria();
		    	$c->add(UserPeer::ENROLMENT, $enrol);
		    	$user = UserPeer::doSelectOne($c);
		    	if(!$user){
			    	$c = new Criteria();
			    	$c->add(BranchPeer::CODE, $branch);
			    	$br = BranchPeer::doSelectOne($c);
			    	if(!$br){
			    		$br = new Branch();
			    		$br->setName($branch);
			    		$br->setCode($branch);
			    		$br->save();
			    	}
			    	
			    	$c = new Criteria();
			    	$c->add(DegreePeer::NAME, $degree);
			    	$dg = DegreePeer::doSelectOne($c);
			    	if(!$dg){
			    		$dg = new Degree();
			    		$dg->setName($degree);
			    		$dg->save();
			    	}
			    	
			    	$user = new User();
			    	if($roll){
			    		$user->setRoll($roll);
			    		$user->setRollflag(sfConfig::get('app_defaultprivacy_roll'));
			    	}
			    	if($enrol){
			    		$user->setEnrolment($enrol);
			    		$user->setEnrolflag(sfConfig::get('app_defaultprivacy_enrol'));
			    	}else{
			    		$ignoreflag = 1;
			    	}
			    	if($year){
			    		$user->setGraduationyear($year);
			    		$user->setGraduationyearflag(sfConfig::get('app_defaultprivacy_year'));
			    	}
			    	$user->setBranchId($br->getId());
			    	$user->setBranchflag(sfConfig::get('app_defaultprivacy_branch'));
			    	$user->setDegreeId($dg->getId());
			    	$user->setDegreeflag(sfConfig::get('app_defaultprivacy_degree'));
			    	$user->setIslocked(sfConfig::get('app_islocked_unclaimed'));
			    	$user->setUsertype(sfConfig::get('app_usertypecode_Alumni'));
			    	$lastname = '';
			    	
			    	$personal = new Personal();
			    	$name[0] = str_replace('.', '', $name[0]);
			    	$personal->setFirstname($name[0]);
			    	if($name[3]){
			    		$name[1] = str_replace('.', '', $name[1]);
			    		$name[2] = str_replace('.', '', $name[2]);
			    		$name[3] = str_replace('.', '', $name[3]);
			    		$midname = $name[1]." ".$name[2];
			    		$personal->setMiddlename($midname);
			    		$personal->setLastname($name[3]);
			    		$lastname = $name[3];
			    	}elseif($name[2]){
			    		$name[1] = str_replace('.', '', $name[1]);
			    		$name[2] = str_replace('.', '', $name[2]);
			    		$personal->setMiddlename($name[1]);
			    		$personal->setLastname($name[2]);
			    		$lastname = $name[2];
			    	}elseif($name[1]){
			    		$name[1] = str_replace('.', '', $name[1]);
			    		$personal->setLastname($name[1]);
			    		$lastname = $name[1];
			    	}
		    		
                                $uname_suffix = $branch.substr($year,-2);
			    	if($lastname){
			    		$username = $name[0].'.'.$lastname.'@';
			    	}else{
			    		$username = $name[0].'@';
			    	}
			    	$temp = 1;
			    	$tempusername = $username;
			    	while($this->uniqueuser($tempusername.$uname_suffix)){
			    		$tempusername = $username.$temp;
					$temp++;
			    	}
			    	
			    	$tempusername=$tempusername.$uname_suffix;
			    	$user->setUsername($tempusername);
			    	if($ignoreflag == 0){
			    		$e = $user->save();
			    		$personal->setUserId($user->getId());
			    		$personal->save();
			    		$success++;
			    		$log[$i][0] = ($e == 1) ? "$i) Uploaded Successfully": $e;
			    		$log[$i][1] = $data[0];
			    	}else{
			    		$ignore[] = $i;
			    		$ignoreflag = 0;
			    		$log[$i][0] = "$i) NO enrolment number";
			    		$log[$i][1] = $data[0];
			    	}
		    	}else{
		    		$exist[] = $i;
		    		$log[$i][0] = "$i) In Database";
			    	$log[$i][1] = $data[0];
		    	}
		    	$i++;
		    } // while ($data = $reader->read()) ends here
		    $reader->close();
		    
		    $this->log = $log;
			$this->success = $success;
			$this->ignored = $ignore;
			$this->exists = $exist;
		}
  }
	
  public function handleErrorBulkupload()
  {
	$this->forward('admin', 'bulkuploadform');
  }

  public function uniqueuser($username){
	$c = new Criteria();
	$c->add(UserPeer::USERNAME, $username);
	$user = UserPeer::doSelectOne($c);
	if($user){
		return true;
	}else{
		return false;
	}
  }

  /* Badges */
  
  public function executeBadges(){
  	$c = new Criteria();
  	$c->addAscendingOrderByColumn(BadgePeer::NAME);
  	$this->badges = BadgePeer::doSelect($c); 
  }
  
  public function executeDeletebadge(){
  	$badgeid = $this->getRequestParameter('id');
  	$c = new Criteria();
  	$c->add(UserbadgePeer::BADGE_ID, $badgeid);
  	$ucount = UserPeer::doCount($c);
  	$exuser = UserPeer::doSelectOne($c);
  	if($exuser){
  		$this->setFlash('notice', 'Badge could not be deleted. <b>'.$ucount.'</b> users are holding this badge.');
  	}else{
  		$badge = BadgePeer::retrieveByPK($badgeid);
  		$badge->delete();
  		$this->setFlash('notice', 'Badge deleted successfully.');
  	}
  	$this->redirect('/admin/badges');
  }
  
  public function executeEditbadge(){
  	$badgeid = $this->getRequestParameter('id');
  	$c = new Criteria();
  	$c->add(BadgePeer::NAME, $this->getRequestParameter('badge'));
  	$c->add(BadgePeer::ID, $badgeid, Criteria::NOT_EQUAL);
  	$exbadge = BadgePeer::doSelectOne($c);
  	if($exbadge){
  		$this->setFlash('notice', 'Badge could not be edited. A badge with same name already exists.');
  	}else{
  		$badge = BadgePeer::retrieveByPK($badgeid);
  		$badge->setName($this->getRequestParameter('badge'));
  		$badge->save();
  		$this->setFlash('notice', 'Badge Edited successfully.');
  	}
  	$this->redirect('/admin/badges');
  }
  
  public function executeAddbadge(){
  	$c = new Criteria();
  	$c->add(BadgePeer::NAME, $this->getRequestParameter('badge'));
  	$exbadge = BadgePeer::doSelectOne($c);
  	if($exbadge){
  		$this->setFlash('notice', 'Badge could not be added. A badge with this name already exists.');
  	}else{
  		$badge = new Badge();
  		$badge->setName($this->getRequestParameter('badge'));
  		$badge->save();
  		$this->setFlash('notice', 'Badge <b>'.$badge->getName().'</b> added successfully.');
  	}
  	$this->redirect('/admin/badges');
  }
  

  

}
