<?php

// Every string here replaces one "Kanboard" in page titles, outgoing email,
// and some other places.
//
// Delete or comment out a line to fall back to Kanboard's own string.
//
// data/NotKanboard.config.json (if present) overrides this file and survives plugin updates.

return array(

    // Optional. When set (http or https only), the sign-off name in task
    // notifications and the password reset email links here.
    'product_url' => 'https://notkanboard.org',

    // "From" name on every email.
    'sender_name' => 'NotKanboard',

    // "From" name when a logged-in user triggers the email. %s is their name.
    // An empty string means always use sender_name.
    'sender_name_via' => '',

    // Sign-off at the bottom of task and comment notifications.
    'footer_name' => 'NotKanboard',

    // Links in that footer.
    'footer_task_link'  => 'view the task on NotKanboard',
    'footer_board_link' => 'view the board on NotKanboard',

    // Invitation email.
    'invite_text'        => 'You have been invited to register on NotKanboard.',
    'invite_link'        => 'Join your team on NotKanboard',
    'invite_footer_link' => 'NotKanboard',

    // Sign-off on the password reset email.
    'password_reset_sign' => 'NotKanboard',

    // true puts sender_name in front of every browser tab title, as in
    // "NotKanboard: Login". The page header doesn't change.
    'page_title_prefix' => true,

    // Email subjects. Left at Kanboard's English wording (or deleted), core's
    // translation for the reader's language is kept.
    'password_reset_subject' => 'Password Reset for NotKanboard',
    'invite_subject'         => 'NotKanboard Invitation',

    // Interface strings.
    'plugin_directory_notice' => 'Your NotKanboard instance is not configured to install plugins from the user interface.',
    'remote_users_notice'     => 'Remote users do not store their password in NotKanboard database, examples: LDAP, Google and Github accounts.',
);
