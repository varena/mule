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

$historyEntries = Model::factory('HistoryProblem')->where('problemId', $mProblem->id)->order_by_desc('id')->find_many();

$entryAuthor = array();
foreach ($historyEntries as $key => $oneEntry) {
  $entryAuthor[$key]=User::get_by_id($oneEntry->userId)->name;
}

SmartyWrap::assign('pageTitle', sprintf(_('History of problem %s'), $mProblem->name));
SmartyWrap::assign('historyEntries', $historyEntries);
SmartyWrap::assign('authorNames',$entryAuthor);
SmartyWrap::display('historyProblem.tpl');

?>
