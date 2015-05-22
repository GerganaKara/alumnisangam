## Applying a patch ##

Now that you're creating and submitting patches like a pro, you may find yourself wanting to apply someone else's patch to your source tree:

  * Download the patch and save it to your file system.
  * Use Tortoise SVN "Apply Patch" from top-level directory in your source tree
> > Look at https://www.projects.dev2dev.bea.com/Subversion%20Clients/TortoiseSVN.html for some help if required. You need to search for "Apply Patch" to quickly navigate to the relevant section
  * A good practice is to a diff to ensure that the patch is applied properly.
  * Compile and test the feature/defect related to the patch
  * Once you are fully satisfied with the working of the patch, commit the changes to the code by using "TortoiseSVN Commit" from top-level directory in your source tree.
  * Intimate the patch submitter about the commit so that he/she can treat his/her friends at Limbdi Corner or Mochu's dukaan.