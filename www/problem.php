<?php

require_once '../lib/Util.php';

$id = Util::getRequestParameter('id');

$p = Problem::get_by_id($id);
$user = Session::getUser();

if (!$p || ($p->status != Problem::STATUS_NORMAL)) {
  FlashMessage::add(_('Requested problem not found.'));
  Util::redirect(Util::$wwwRoot);
}

$p->statement = SmartMarkup::toHTML($p->statement);
SmartyWrap::assign('pageTitle', sprintf(_('Problem: %s'), $p->name)); // Asta se putea face mai simplu zicand 'Problem: ' . $p->name
SmartyWrap::assign('problem', $p);
SmartyWrap::assign('canEdit', canEdit($p, $user));
SmartyWrap::assign('author', User::get_by_id($p->userId));
SmartyWrap::display('problem.tpl');



function canEdit($mproblem, $uploader) {
	if($uploader == NULL) {
		return false;
	}
	return ($mproblem->userId == $uploader->id) || $uploader->admin;
}

?>
