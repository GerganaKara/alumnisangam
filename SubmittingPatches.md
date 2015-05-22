## Overview ##

So, you've identified a simple problem or you have a quick new feature in-mind. Please submit a patch to have these changes go in to the source code.

  * If you have the skills to identify what broke, you have the skills to write a patch.
  * A patch is a concise description of your proposed change; in fact, it may take less effort to create a patch than to describe the problem in e-mail - "a patch is worth a thousand words".
  * Reduces the workload for other developers.  Your patch may be trivial, but it's more efficient when you create it - another developer has to take time to understand your description of the problem, formulate a fix, build, and test it - this time adds-up quickly.

## Creating A Patch ##

Creating a patch using [Subversion with TortoiseSVN](http://tortoisesvn.tigris.org/) is the **only** way to work.  Note that you don't have to be a developer or have write permissions to create a patch using Subversion:

  * Get your source tree from [Subversion](http://code.google.com/p/alumnisangam/source/checkout) and build normally.
  * Edit files in your subversion source tree as needed.  No backups or copies are required.  Compile and test.
  * If you created new files or new directories, add them to the subversion tree.  This is a local operation, you don't have to have subversion write access: Use Tortoise SVN "Add" command from the top-level directory of the subversion source tree
  * To create your patch, use the Tortoise SVN "Create Patch" command from the top-level directory of the subversion source tree, and redirect its output to a file say my\_changes.patch
> > my\_changes.patch will contain your new files and any modifications to existing files.
  * Notify the committers mailing list and enjoy your well-deserved praise.