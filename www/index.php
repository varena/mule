<?php

require_once '../lib/Util.php';

$problems = Model::factory('Problem')->where('status', Problem::STATUS_NORMAL)->order_by_asc('name')->find_many();

SmartyWrap::assign('pageTitle', _('Home page'));
SmartyWrap::assign('problems', $problems);
SmartyWrap::display('index.tpl');

?>
