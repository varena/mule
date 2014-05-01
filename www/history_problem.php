<?php

require_once '../lib/Util.php';

$id = Util::getRequestParameter('id');

if ($id==null) {
  $pName=Util::getRequestParameter('name');
  $mProblem = Problem::get_by_name($pName);
} else {
  $mProblem = Problem::get_by_id($id);
}

if (!$mProblem) {
  FlashMessage::add(_('Requested problem not found.'));
  Util::redirect(Util::$wwwRoot);
}

$historyEntries = Model::factory('History_Problem')->where('problemId', $mProblem->id)->order_by_desc('id')->find_many();
$i = 0;
foreach($historyEntries as $oneEntry)
{
   $entryAuthor[$i]=User::get_by_id($oneEntry->userId)->name;
   $date[$i]=gmdate("H:i\ d-m-Y",$oneEntry->created);
   $i = $i + 1;
}
SmartyWrap::assign('date',$date);
SmartyWrap::assign('pageTitle', sprintf(_('History of problem %s'), $mProblem->name));
SmartyWrap::assign('theProblem', $mProblem);
SmartyWrap::assign('sizeOfEntries',count($historyEntries));
SmartyWrap::assign('theHistoryEntries', $historyEntries);
SmartyWrap::assign('authorNames',$entryAuthor);
SmartyWrap::display('history_problem.tpl');

?>
