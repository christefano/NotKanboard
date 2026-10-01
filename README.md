# NotKanboard

*NotKanboard* is a Kanboard plugin that helps whitelabel Kanboard. It replaces "Kanboard" in page titles, outgoing emails, and a few other places with whatever custom string you set in NotKanboard's `config.php` file (and optionally a `NotKanboard.config.json` file in Kanboard's `data/` directory).


## Quick start

1. Extract `NotKanboard.zip` to `plugins/NotKanboard/` in the Kanboard install.
2. Edit `plugins/NotKanboard/config.php` (or optionally a `NotKanboard.config.json` file in Kanboard's `data/` directory) and set each custom string. Delete or comment out a line to keep Kanboard's original string.
3. Reload PHP-FPM if opcache is on. `config.php` is cached like any PHP file, so edits don't show until it reloads.

The config file defaults to "NotKanboard" and `https://notkanboard.org` as an example, so you'll want to change those right away. [INSTALL.md](INSTALL.md) covers what NotKanboard conflicts with and updating without losing your custom strings when updating NotKanboard.


## What it replaces

| Key | Where it shows up | Kanboard default |
|---|---|---|
| `product_url` | Optional link target (http or https) for the sign-off name in task notifications and the password reset email | none |
| `sender_name` | "From" name on every email | Kanboard |
| `sender_name_via` | "From" name when a logged-in user triggers the email (`%s` is their name). Empty means always use `sender_name` | %s via Kanboard |
| `footer_name` | Sign-off at the bottom of task and comment notifications | Kanboard |
| `footer_task_link` | "view the task" link in that footer | view the task on Kanboard |
| `footer_board_link` | "view the board" link in that footer | view the board on Kanboard |
| `invite_text` | First line of the invitation email | You have been invited to register on Kanboard. |
| `invite_link` | Text of the join link in the invitation email | Click here to join your team |
| `invite_footer_link` | Link text at the bottom of the invitation email | Kanboard |
| `password_reset_sign` | Sign-off on the password reset email | Kanboard |
| `password_reset_subject` | Subject of the password reset email | Password Reset for Kanboard |
| `invite_subject` | Subject of the invitation email | Kanboard Invitation |
| `plugin_directory_notice` | Warning on the Plugin Directory page when installs from the interface are off | Your Kanboard instance is not configured to install plugins from the user interface. |
| `remote_users_notice` | Note on a user's authentication page | Remote users do not store their password in Kanboard database, examples: LDAP, Google and Github accounts. |
| `page_title_prefix` | `true` puts `sender_name` in front of every browser tab title, as in "NotKanboard: Login". The page header doesn't change | false |

A key left out of `config.php` (or optionally a `NotKanboard.config.json` file in Kanboard's `data/` directory) keeps Kanboard's original string. A key set to your own custom string displays that way in every language.


## Other "Kanboard" labels

- Two-factor app label: Kanboard's own `config.php` sets this, and no extra plugin is needed. Add `define('TOTP_ISSUER', 'NotKanboard');` or set the `TOTP_ISSUER` environment variable. It defaults to "Kanboard".
- Calendar feeds: core iCal export hardcodes "Kanboard" as the feed's product ID with no hook, and NotKanboard can't change that. The calendar name itself, though, is the Kanboard project or username.
- On the server where only a Kanboard admin can see it, strings are unchanged in the command-line tool name, the HTTP user agent, the database application name, and error log lines.


## Limitations

- Strings that another plugin adds to email (for example an "automated notification" line) aren't changed. Find which plugin is doing that and override it there.
- Replaces the `emailClient` service and three email templates, so it conflicts with any plugin that does the same. Be sure to check this on your server if you're using other email plugins.
- With `page_title_prefix` on, it also overrides the `layout` template. It wraps whatever layout was registered before it (core or a plugin like Customizer) and changes only the title, so the two will work together. A plugin that overrides `layout` later in its own `onStartup()` replaces the prefix.
- The replacement `emailClient` registers only the smtp, sendmail, and mail transports, so the load order is important. A plugin that resolves `emailClient` before NotKanboard loads can hit Pimple's frozen-service error or lose its transport. Be sure to check this on your server if you're using other email plugins.


## What it overrides

NotKanboard doesn't change any Kanboard core files or other plugin files. It replaces these at runtime:

| Part | Owner | How |
|---|---|---|
| `emailClient` service | Kanboard | Subclass (`Client.php`) whose `getAuthorName()` returns `sender_name` or `sender_name_via`. Registers core smtp, sendmail, and mail transports again |
| `notification/footer`, `user_invite/email`, `password_reset/email` templates | Kanboard | Template overrides |
| `layout` template (only with `page_title_prefix` on) | Kanboard, or a theme plugin such as Customizer that overrode it first | Wraps the registered layout and changes only `$page_title` |
| Translation table entries for the four subject and interface keys | Kanboard's translations | Replaced in `onStartup()`, only for keys set to something other than Kanboard's English |

TagAlong replaces the transports on NotKanboard's mail client after it loads, and NotifyMe reads `footer_name` and `product_url` for its own email footer.


## Other plugins

NotKanboard works with several other plugins by the same author:

- [NotifyMe](https://github.com/christefano/NotifyMe) emails you about your own actions in a project, adds a vacation mode, notifies users of failed login attempts, and gives admins control of how many notifications are shown in the Notifications menu. Its email footer uses NotKanboard's name when both are installed.
- [TagAlong](https://github.com/christefano/TagAlong) supercharges Kanboard email support by filtering autoreplies, email signatures, and quoted text from incoming mail, points Reply-To to the reply-by-email address, and adds a reply token to email subjects, so replies become task comments through [Mailmagik](https://github.com/creecros/Mailmagik/).


## Compatibility

- Kanboard >= 1.2.20
- No database changes


## License

GNU General Public License v2. See LICENSE for details.
