<?php include_component('home','leftmenu'); ?>
<div class="page">
	<h3>Thanks for Registering</h3>
	<div class="centermsg">Thank You, <b><?php echo $user->getFullname()?> </b><i> <?php echo " of ".$user->getBranch()->getCode()." ".$user->getGraduationyear()." ".$user->getDegree()->getName() ?></i>.</div>
	<div class="vspacer20">&nbsp;</div>
	<div class="centermsg">Here is the info you entered.</div>
	<div class="vspacer10">&nbsp;</div>
	
	<div class="oddRow">
		<div class="formleftcol">
			<div class="formleftcoltext">Email : </div>
		</div>
		<div class="formrightcol"><?php echo $user->getEmail(); ?></div>
	</div>
	<div class="oddRow">
		<div class="formleftcol">
			<div class="formleftcoltext">Full Roll # : </div>
		</div>
		<div class="formrightcol"><?php echo $claiminfo->getRoll(); ?></div>
	</div>	<div class="oddRow">
		<div class="formleftcol">
			<div class="formleftcoltext">HAWA : </div>
		</div>
		<div class="formrightcol"><?php echo $claiminfo->getHawa(); ?></div>
	</div>	<div class="oddRow">
		<div class="formleftcol">
			<div class="formleftcoltext">City : </div>
		</div>
		<div class="formrightcol"><?php echo $claiminfo->getCity(); ?></div>
	</div>	<div class="oddRow">
		<div class="formleftcol">
			<div class="formleftcoltext">HoD : </div>
		</div>
		<div class="formrightcol"><?php echo $claiminfo->getHod(); ?></div>
	</div>	<div class="oddRow">
		<div class="formleftcol">
			<div class="formleftcoltext">Director : </div>
		</div>
		<div class="formrightcol"><?php echo $claiminfo->getDirector(); ?></div>
	</div>	<div class="oddRow">
		<div class="formleftcol">
			<div class="formleftcoltext">Favorite Teacher : </div>
		</div>
		<div class="formrightcol"><?php echo $claiminfo->getTeacher(); ?></div>
	</div>	<div class="oddRow">
		<div class="formleftcol">
			<div class="formleftcoltext">Favorite Lanka shop : </div>
		</div>
		<div class="formrightcol"><?php echo $claiminfo->getLankashop(); ?></div>
	</div>
	<div class="oddRow">
		<div class="formleftcol">
			<div class="formleftcoltext">Other Info: </div>
		</div>
		<div class="formrightcol"><?php echo $claiminfo->getOther(); ?></div>
	</div>	
	
	<div class="vspacer10">&nbsp;</div>
	<div class="centermsg">Your username is 
		<b><?php if($claiminfo->getDusername()): echo $claiminfo->getDusername(); else: echo $user->getUsername(); endif; ?></b>
		Please check your email at <b><?php echo $user->getEmail(); ?></b> for password and other instructions. [Note that your account is currently held for authorization, and you will receive the password only after authorization. -- We are working to fix this -- Animesh]
	</div>
	<div class="vspacer20">&nbsp;</div>
	<div class="formbuttons"><a href="/"><img src="/images/firstlogin.png" alt="Proceed to first login"></a></div>
	<div class="vspacer10">&nbsp;</div>
</div>
