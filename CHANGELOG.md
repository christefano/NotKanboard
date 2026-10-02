# Changelog

## v1.1.0

- README and INSTALL rewritten
- Every string now comes from `config.php`, and the `SENDER_NAME` constant is gone
- Replaces "Kanboard" in the notification footer, the invitation email, and the password reset email, and not only the "From" name
- Added `NotKanboard.config.json` in Kanboard's `data/` directory. It overrides `config.php` and survives plugin updates. It's JSON and not PHP, so `data/` is never a code-execution path
- Added `product_url`, which links the sign-off name in task notifications and password reset emails
- Added `page_title_prefix`, which puts `sender_name` in front of every browser tab title, as in "NotKanboard: Login". Off by default
- Added keys for the password reset and invitation email subjects, the Plugin Directory notice, and the remote users note
- Added `invite_link` for the join link text in the invitation email
- A key left out of `config.php` shows Kanboard's default string in the reader's language
- The task notification footer skips the board link when the task has no `project_id`
- The password reset link is now clickable
- 

## v1.0.0

- First public release.
