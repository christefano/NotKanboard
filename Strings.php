<?php

namespace Kanboard\Plugin\NotKanboard;

use Kanboard\Core\Translator;

class Strings
{
    /** Keys set in config.php or data/NotKanboard.config.json. */
    private static $custom = null;

    /** Kanboard's own wording, used when neither file sets a key. */
    private static $defaults = array(
        'product_url'         => '',
        'sender_name'         => 'Kanboard',
        'sender_name_via'     => '%s via Kanboard',
        'footer_name'         => 'Kanboard',
        'footer_task_link'    => 'view the task on Kanboard',
        'footer_board_link'   => 'view the board on Kanboard',
        'invite_text'         => 'You have been invited to register on Kanboard.',
        'invite_link'         => 'Click here to join your team',
        'invite_footer_link'  => 'Kanboard',
        'password_reset_sign' => 'Kanboard',
        'page_title_prefix'   => false,

        // Interface and subject strings replaced through Kanboard's translation table.
        'password_reset_subject'  => 'Password Reset for Kanboard',
        'invite_subject'          => 'Kanboard Invitation',
        'plugin_directory_notice' => 'Your Kanboard instance is not configured to install plugins from the user interface.',
        'remote_users_notice'     => 'Remote users do not store their password in Kanboard database, examples: LDAP, Google and Github accounts.',
    );

    /** Defaults that core runs through its translator, so they follow the reader's language. */
    private static $translated = array(
        'sender_name_via',
        'footer_task_link',
        'footer_board_link',
        'invite_text',
        'invite_link',
        'password_reset_subject',
        'invite_subject',
        'plugin_directory_notice',
        'remote_users_notice',
    );

    /** Keys whose value replaces a core string in Kanboard's translation table. */
    private static $overrides = array(
        'password_reset_subject',
        'invite_subject',
        'plugin_directory_notice',
        'remote_users_notice',
    );

    public static function get($key)
    {
        $custom = self::custom();

        if (array_key_exists($key, $custom)) {
            return is_scalar($custom[$key]) ? (string) $custom[$key] : '';
        }

        if (! array_key_exists($key, self::$defaults)) {
            return '';
        }

        $default = self::$defaults[$key];

        // Translator::get() returns the raw translation with no sprintf, so a %s stays intact.
        if (in_array($key, self::$translated, true)) {
            return (string) Translator::getInstance()->get($default, $default);
        }

        return is_bool($default) ? ($default ? '1' : '') : (string) $default;
    }

    /** True when the key is on, as set in config.php or the JSON file. */
    public static function enabled($key)
    {
        return (bool) self::get($key);
    }

    /**
     * Customized override keys, as core English string => replacement.
     * A key left at Kanboard's English wording is skipped, so a non-English install keeps its core translation.
     */
    public static function translationOverrides()
    {
        $custom = self::custom();
        $result = array();

        foreach (self::$overrides as $key) {
            if (! isset($custom[$key]) || ! is_scalar($custom[$key])) {
                continue;
            }

            $value = (string) $custom[$key];

            if ($value !== '' && $value !== self::$defaults[$key]) {
                // Core passes these through sprintf, so a literal % must be doubled.
                $result[self::$defaults[$key]] = str_replace('%', '%%', $value);
            }
        }

        return $result;
    }

    /** Escaped string for a key, linked to product_url when that is an http(s) URL. */
    public static function linked($key)
    {
        $text = htmlspecialchars(self::get($key), ENT_QUOTES, 'UTF-8');
        $url = self::get('product_url');

        if (preg_match('#^https?://#i', $url)) {
            return '<a href="'.htmlspecialchars($url, ENT_QUOTES, 'UTF-8').'">'.$text.'</a>';
        }

        return $text;
    }

    private static function custom()
    {
        if (self::$custom !== null) {
            return self::$custom;
        }

        self::$custom = array();
        $file = __DIR__.'/config.php';

        if (is_file($file)) {
            $values = include $file;

            if (is_array($values)) {
                self::$custom = array_merge(self::$custom, $values);
            }
        }

        // Optional override in Kanboard's data directory, which an in-app plugin update doesn't replace.
        // JSON and not PHP, so a writable data directory is never a code-execution path.
        $override = defined('DATA_DIR') ? DATA_DIR.'/NotKanboard.config.json' : '';

        if ($override !== '' && is_file($override)) {
            $values = json_decode((string) file_get_contents($override), true);

            if (is_array($values)) {
                self::$custom = array_merge(self::$custom, $values);
            }
        }

        return self::$custom;
    }
}
