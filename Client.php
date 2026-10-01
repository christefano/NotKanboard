<?php

namespace Kanboard\Plugin\NotKanboard;

use Kanboard\Core\Mail\Client as BaseClient;

class Client extends BaseClient
{
    public function getAuthorName()
    {
        $via = Strings::get('sender_name_via');

        if ($via !== '' && $this->userSession->isLogged()) {
            return str_replace('%s', $this->helper->user->getFullname(), $via);
        }

        return Strings::get('sender_name');
    }
}
