<?php

namespace Kanboard\Plugin\NotKanboard;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
        $this->container['emailClient'] = function ($c) {
            $mailer = new Client($c);
            $mailer->setTransport('smtp', '\Kanboard\Core\Mail\Transport\Smtp');
            $mailer->setTransport('sendmail', '\Kanboard\Core\Mail\Transport\Sendmail');
            $mailer->setTransport('mail', '\Kanboard\Core\Mail\Transport\Mail');
            return $mailer;
        };

        $this->template->setTemplateOverride('notification/footer', 'NotKanboard:notification/footer');
        $this->template->setTemplateOverride('user_invite/email', 'NotKanboard:user_invite/email');
        $this->template->setTemplateOverride('password_reset/email', 'NotKanboard:password_reset/email');
    }

    /** Layout file NotKanboard's layout wraps: core's, or another plugin's override of it. */
    public static $layoutFile = '';

    /** Runs after every plugin's initialize() and after core loads the current language. */
    public function onStartup()
    {
        foreach (Strings::translationOverrides() as $original => $replacement) {
            Translator::$locales[$original] = $replacement;
        }

        if (Strings::enabled('page_title_prefix')) {
            $current = $this->template->getTemplateFile('layout');
            $own = $this->template->getTemplateFile('NotKanboard:layout');

            if ($current !== $own) {
                self::$layoutFile = $current;
                $this->template->setTemplateOverride('layout', 'NotKanboard:layout');
            }
        }
    }

    public function getPluginName()
    {
        return 'NotKanboard';
    }

    public function getPluginDescription()
    {
        return t('Replaces "Kanboard" in outgoing emails, page titles, and a few interface strings with strings from config.php');
    }

    public function getPluginAuthor()
    {
        return 'Christefano Reyes';
    }

    public function getPluginVersion()
    {
        return '1.1.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/christefano/NotKanboard';
    }

    public function getCompatibleVersion()
    {
        return '>=1.2.20';
    }
}
