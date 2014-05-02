<?php

require_once '../lib/Util.php';
$diffId = Util::getRequestParameter('id');
$entry = HistoryProblem::get_by_id($diffId);

if ($entry== null) {
  FlashMessage::add(_('Requested history entry not found.'));
  Util::redirect(Util::$wwwRoot);
}

$prevEntry = Model::factory('HistoryProblem')->where('problemId', $entry->problemId)->where_lt('created', $entry->created)->order_by_desc('created')->find_one();
if ($prevEntry) {
  $opcodes = FineDiff::getDiffOpcodes($prevEntry->statement, $entry->statement,FineDiff::$wordGranularity);
  $diffRender = FineDiff::renderDiffToHTMLFromOpcodes($prevEntry->statement, $opcodes);
}
else {
  $diffRender=$entry->statement;
}

SmartyWrap::assign('pageTitle', sprintf(_('History difference %s'), $entry->id));
SmartyWrap::assign('diffText', $diffRender);
SmartyWrap::display('historyDiff.tpl');
?>
