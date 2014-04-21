<?php

require_once '../lib/Util.php';

$id = Util::getRequestParameter('id');
if($id==null)
{
  $uName=Util::getRequestParameter('name');
  $muser = User::get_by_username($uName);
}
else
  $muser = User::get_by_id($id);
if(!$muser)
{
  	FlashMessage::add(_('Requested user not found.'));
	Util::redirect(Util::$wwwRoot);
	exit();
}

$problems = Model::factory('Problem')->where('userId', $id)->where('status', Problem::STATUS_NORMAL)->order_by_asc('name')->find_many();

SmartyWrap::assign('pageTitle', sprintf(_('Profil %s'), $muser->getDisplayName()));
SmartyWrap::assign('theUser',$muser);
SmartyWrap::assign('theProblems',$problems);
SmartyWrap::display('user.tpl');

?>
