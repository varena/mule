<?php

require_once '../lib/Util.php';


$id = Util::getRequestParameter('id');
$mround = Round::get_by_id($id);
if(!$mround)
{
  FlashMessage::add(_('Requested round not found.'));
  Util::redirect(Util::$wwwRoot);
}
else
{    
	SmartyWrap::assign('pageTitle', $mround->name);
	SmartyWrap::assign('theRound',$mround);
	SmartyWrap::assign('theCreator',User::get_by_id($mround->userId));
	SmartyWrap::assign('theProblems',Problem::getAllByRoundId($id));
	SmartyWrap::assign('timeCreated', gmdate("d-m-Y\ H:i:s\ ",$mround->startDate));
	SmartyWrap::display('round.tpl');
}
?>
