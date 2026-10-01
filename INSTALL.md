# Installation

## Requirements

- Kanboard >= 1.2.20. No database changes.


## Install

1. Extract `NotKanboard.zip` to `/path/to/kanboard/plugins/NotKanboard/`
2. Edit `plugins/NotKanboard/config.php` and set the custom strings. Every key is listed in the README.
3. Reload PHP-FPM if opcache is on, so the new `config.php` is read.
4. Send a test email (invite a user, trigger a task notification, etc.) and check the "From" name and footer.


## Keep your custom strings through an update

Kanboard's in-app plugin updater replaces the whole plugin folder (including `config.php`), so you can put your custom strings in `NotKanboard.config.json` in Kanboard's `data/` directory. NotKanboard reads it after the plugin's `config.php`, so any key in it works and a NotKanboard update won't overwrite it.

The second file only has the keys to change:

```json
{
    "sender_name": "Acme Projects",
    "footer_name": "Acme Projects"
}
```

The file is JSON (and not PHP) on purpose. NotKanboard never runs code from `data/`, so a writable data directory can't become a path for code execution. Invalid JSON and non-text values are ignored.

The `data/` directory comes from Kanboard's `DATA_DIR` constant. The override is skipped if that constant isn't defined or the file isn't there.


## Conflicts

No Kanboard core or third-party plugin files are edited. These conflict because NotKanboard replaces the same parts at runtime, and the one that loads last takes priority:

- Any plugin that replaces the `emailClient` service.
- Any plugin that replaces the `notification/footer`, `user_invite/email`, or `password_reset/email` templates.
- With `page_title_prefix` on, a plugin that overrides the `layout` template from its own `onStartup()`. A plugin like Customizer that does it in `initialize()` keeps working since NotKanboard wraps that layout and changes only the title.
