<?php

require_once '../lib/Util.php';
require_once 'finediff.php';
$diffId = Util::getRequestParameter('id');
$entry = History_Problem::get_by_id($diffId);
if($entry==null)
{
 	FlashMessage::add(_('Requested history entry not found.'));
 	Util::redirect(Util::$wwwRoot);
}
$historyEntries = Model::factory('History_Problem')->where('problemId', $entry->problemId)->order_by_desc('id')->find_many();
$next = false;
$statement=null;
$poz=0;
foreach($historyEntries as $oneEntry)
{
   if($next==true)
   {
	$statement=$oneEntry->statement;
	$next=false;
   }
   if($oneEntry->id==$diffId)
	$next=true;
}
$opcodes = FineDiff::getDiffOpcodes($statement, $entry->statement,FineDiff::$wordGranularity);
$diffRender = FineDiff::renderDiffToHTMLFromOpcodes($statement, $opcodes);
SmartyWrap::assign('pageTitle', sprintf(_('History difference %s'), $entry->id));
SmartyWrap::assign('finalText', $diffRender);
SmartyWrap::assign('finalText',$diffRender);
SmartyWrap::display('history_diff.tpl');
?>
