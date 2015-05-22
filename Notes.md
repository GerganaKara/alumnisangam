## Register New Person Page ##
  * Needed: Answers to questions, same list as claim ID page.
  * Needed: Cleanup list of departments
  * Needed: Change/cleanup copy
  * Works: username collision (tested with username animesh)
  * Needed: Does not auto-add new person to MGL (maybe this should happen only after the user is approved. But in any case, we need to make sure the MGL is "complete" at all times)

## Recover Password page ##
  * Works: Recovering password
  * Needed: If the email does not exist in the system, say "there is no user with that email, you provided $emailAddress. Try again or email $contactaddress"
  * Needed: The "Thanks" Page needs to be changed. (should not ask for the email again)
  * Needed: What would happen if two usernames had the same email ID? (can happen for father and son being alumni, etc. Expected behavior is either a) change both IDs, or b)). Currently ONLY one ID gets an email. (tested with usernames animesh and Raju.Hukku@ECE83 both having animesh @ gmail.com )

## MGL Listing page ##
http://itbhu.web-01.neevtech.com/home/regsearch.html
  * Works: Searching ECE and 1983 gives a list of grads from that time
  * Needed: Hide enrolment number. Show roll number instead
  * Needed: Sortability on this list. Right now it is hard to find one's name
  * Works: Choosing name brings one to next screen with questions
  * Needed: Edit copy of question page http://itbhu.web-01.neevtech.com/home/regsearch.html
  * Needed: Ask for email **twice**, just to be sure
  * Needed: Misc field at the bottom asking for "any other info that will help us authenticate you". Make it a 3 line textarea.
  * Needed: Username choice. **IMPORTANT**

## User Claim Handling ##
  * Works: Name appears in listing of "claimed users"
  * Needed: Detailed "page" with info submitted by user (e.g., answers to questions)

## Viewing own profile ##
  * Needed: To clearly view the info from the MGL, since that is my "primary info"