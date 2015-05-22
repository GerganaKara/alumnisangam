Description of Polling Module in ITBHUGlobal.org 2.0

# Introduction #

The polling module will be one the first module as we move towards ITBHUGlobal.org 2.0.

It will be employed to hold CoR and BoD elections (Nov - Dec' 08).

A demo is available at https://itbhuglobal.org/devsite/drupal/


# Details #

(Assuming all the currently registered in ITBHUGlobal.org has been imported into Drupal and are associated with drupal roles like ece, batch83, ece83 etc.)

The polling module (http://drupal.org/project/advpoll) will be used which provides the following type so of polls -

-- Binary Poll - Vote for or against something
-- Simple Poll - Multiple choice question which visitors can vote on.
-- Ranking Poll - Rank a number of choices.

(the above should suffice for us, any ideas?)

AdvPoll also has an electoral list concept, whereby we can choose which users are eligible to vote.

Users can also be added by providing the drupal role name. (here all the users currently associated with the said drupal role are added to the electoral list)


# Issue #

Though users can be added based on roles but newly registered users under the said role are not automatically added to the electoral list. (this is expected to happen at high stake elections).

The solution is to modify AdvPoll module to store drupal role name in its electoral list (instead of one - by - one adding all the _current_ users in the electoral list)

It would be way more easier to manage as well in elections involving a large set of alumni. (though we loose the flexibility of removing a particular user from electoral list when present in a valid drupal role list)

AdvPoll should also cross check if one of user's roles is present in a given electoral list (instead of only his user name).


# Summary #

The above is not a blocker issue for the initial CoR elections as -
- Very few elections are expected (one CoR per batch is required)
- Electoral list will be at max contain one batch (400-600)
- Not many new alumni are expected to register during CoR elections.

We are on track of Nov' 05 deadline for elections