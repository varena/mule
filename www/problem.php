<?php

require_once '../lib/Util.php';

$id = Util::getRequestParameter('id');

$p = Problem::get_by_id($id);

if (!$p || ($p->status != Problem::STATUS_NORMAL)) {
  FlashMessage::add(_('Requested problem not found.'));
  Util::redirect(Util::$wwwRoot);
}

SmartyWrap::assign('pageTitle', sprintf(_('Problem: %s'), $p->name));
SmartyWrap::assign('problem', $p);
SmartyWrap::assign('author', User::get_by_id($p->userId));
SmartyWrap::display('problem.tpl');

?>
