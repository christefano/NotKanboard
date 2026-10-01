<?php
// Prefixes the browser title with sender_name, then renders the layout this override replaced
// (core's own, or another plugin's), so no copy of core's layout lives here.
// Only $page_title changes. $title still feeds the page header unchanged.

$__nk_name = \Kanboard\Plugin\NotKanboard\Strings::get('sender_name');

if (isset($page_title)) {
    $__nk_base = (string) $page_title;
} elseif (isset($title)) {
    $__nk_base = (string) $title;
} else {
    $__nk_base = '';
}

if ($__nk_name === '') {
    $__nk_name = 'Kanboard';
}

$page_title = $__nk_base === '' ? $__nk_name : $__nk_name.': '.$__nk_base;
unset($__nk_name, $__nk_base);

include \Kanboard\Plugin\NotKanboard\Plugin::$layoutFile;
