<?php include_component('home','leftmenu'); ?>
<?php include_component('home', 'messages'); ?>
<div class="page">
		  <?php if($user && $user->getIslocked() != 1): ?>
			  <h3>Oops! Account already claimed</h3>
			  <div class="vspacer20">&nbsp;</div>
			  <div class="centermsg">It seems that <b><?php echo $user->getFullname().", "?></b> <i><?php echo $user->getDegree()->getName()." ".$user->getBranch()->getCode().", ".$user->getGraduationyear() ?></i> &nbsp;has already claimed.<br />
			    Did you <?php echo link_to('Forgot Password', 'user/forgotpasswordform') ?>&nbsp;? </div>
		  <?php else: ?>
		  	  <?php echo form_tag('home/registration'); ?>
		  	  <?php if($user): ?>
				  <h3>Claim your Account</h3>
				  <div class="vspacer20">&nbsp;</div>
				  <div class="centermsg">Welcome <b><?php echo $user->getFullname().", "?></b> <i><?php echo $user->getDegree()->getName()." ".$user->getBranch()->getCode().", ".$user->getGraduationyear() ?></i> Batch! <br />
				    Please fill in the following info to claim your account. </div>
				  <div class="vspacer20">&nbsp;</div>
				  <input type="hidden" value="<?php echo $user->getId(); ?>" name="userid" />
			  <?php else: ?>
				  <h3>Name Not in Our Records!!</h3>
				  <div class="vspacer20">&nbsp;</div>
				  <div class="centermsg">Sorry! But your name is not in the <i><?php echo $degreename." ".$branchcode.", list of".$year ?></i><br />
				    Please fill in the following register and we'll get back to you. </div>
				    <div class="vspacer20">&nbsp;</div>
				    <input type="hidden" value="<?php echo $branchid; ?>" name="branchid" />
				    <input type="hidden" value="<?php echo $degreeid; ?>" name="degreeid" />
				    <input type="hidden" value="<?php echo $year; ?>" name="year" />
				    
				   <div class="evenRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext"> First Name <font color="red">*</font> :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="fname">
				    </div>
				  </div>
				   <div class="oddRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext"> Middle Name :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="mname">
				    </div>
				  </div>
				  <div class="evenRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext"> Last Name<font color="red">*</font> :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="lname">
				    </div>
				  </div>
			  <?php endif; ?>
				  <div class="oddRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext"> Current Email<font color="red">*</font> :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="email">
				    </div>
				  </div>
				  <div class="evenRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext"> Confirm Email<font color="red">*</font> :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="confirmemail">
				    </div>
				  </div>
				  <div class="oddRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext"> Mobile Number<font color="red">*</font> :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="mob">
				    </div>
				  </div>
				  <div class="evenRow">
				    <div class="formleftcol">
				      <?php if($user): ?>
				      	<div class="formleftcoltext"> Desired USERNAME :</div>
				      <?php else: ?>
				      	<div class="formleftcoltext"> Desired USERNAME<font color="red">*</font> :</div>
				      <?php endif; ?>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="dusername" id="dusername" style="float: left;">
				      <div style="float:left; padding-top: 1px; padding-left: 10px;"><img src="/images/check.png" onclick="checkuser()" alt="check" /></div>
				      <div id="checkuserresult" class="checkuserresult" style="float: left;"></div>
				    </div>
				    <?php if($user): ?>
				    <div class="centermsg">(Your default username is <b><?php echo $user->getUsername(); ?></b>. To change fill in the field above. )</div>
				    <?php endif; ?>
				  </div>
				  <div class="vspacer20">&nbsp;</div>
				  <div style="float: left; width: 832px;"><h4><u>Questions about you</u></h4></div>
				  <div class="vspacer20">&nbsp;</div>
				  <div class="centermsg">At ITBHU Alumni Association, we take your privacy seriously. So, we need to make sure only genuine alumni register.<br />
				    Please answer the following questions.</div>
				  <div class="vspacer20">&nbsp;</div>
				  <div class="evenRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext">Your Full Roll # :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="roll">
				    </div>
				  </div>
				  <div class="oddRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext">Your HAWA :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="hawa">
				    </div>
				  </div>
				  <div class="evenRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext">City :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="city">
				    </div>
				  </div>
				  <div class="oddRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext">HoD @ your time :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="hod">
				    </div>
				  </div>
				  <div class="evenRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext">Director @ your time :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="director">
				    </div>
				  </div>
				  <div class="oddRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext">Favorite Teacher :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="favteacher">
				    </div>
				  </div>
				  <div class="evenRow">
				    <div class="formleftcol">
				      <div class="formleftcoltext">Favorite shop @ Lanka :</div>
				    </div>
				    <div class="formrightcol">
				      <input type="text" name="favlankashop">
				    </div>
				  </div>
				  <div class="oddRow">
				    <div class="formleftcol">
				      <?php if($user): ?>
				      	<div class="formleftcoltext" style="padding-top: 20px; line-height: 17px;">Anything else to help us make sure you are indeed<br /><b><?php echo $user->getFullname()?></b> of <i><?php echo $user->getDegree()->getName()." ".$user->getBranch()->getCode().", ".$user->getGraduationyear() ?></i> Batch</div>
				      <?php else: ?>
				      	<div class="formleftcoltext" style="padding-top: 20px; line-height: 17px;">Anything else to help us make sure you are indeed an Alumni/Student of <i><?php echo $degreename." ".$branchcode.", ".$year ?></i> Batch</div>
				      <?php endif; ?>
				    </div>
				    <div class="formrightcol">
				      <textarea cols="20" rows="3" name="otherinfo"></textarea>
				    </div>
				  </div>
				  
				  <div class="evenRow">
						<div class="naturetitle">Nature of Work :</div>
				    </div>
					<div class="oddRow">
						<div class="naturecheckbox">
						    <table border="0">
							    <tr>  
							    <?php $rt=0; foreach($worktype as $workt): $rt++; ?>
								    <?php if($rt==0): ?> <tr> <?php endif; ?>
											<td width="20"><?php $rt++; echo checkbox_tag($workt->getId(),1,false); ?></td>
											<td><?php echo $workt->getName(); ?></td>
										<?php if($rt==12): $rt=0;?></tr><?php endif; ?>
								<?php endforeach; ?>
								
							</table>
								  <div class="vspacer20">&nbsp;</div>
								  <div class="formbuttons"> <input type="image" src="/images/registerme.png" alt="Register Me"></div>
								  <div class="vspacer20">&nbsp;</div>
						  <?php endif; ?>
				      </div>
<script type="text/javascript">
function checkuser()
{
	var url="/home/checkuser.html";
	var un = document.getElementById('dusername').value;
	if(un){
		var username = "username="+un;
		new Ajax.Updater('checkuserresult', url, {method: 'get', parameters: username,onComplete:function() {
			}});
	}else{
		alert('Fill in your desired username to check availability');
	}
}
</script> 
