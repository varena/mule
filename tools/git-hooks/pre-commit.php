#!/usr/bin/php
<?php

   /**
    * Checks whether the developer modified mule.conf
    * If they did, they should push the same changes to mule.conf.sample.
    * Specifically, we check whether
    * - there are new sections in mule.conf
    * - there are new variables in mule.conf
    * - some variables changed type in mule.conf
    */

   // We should already be at the root of the client
if (($muleConf = parse_ini_file('mule.conf', true)) === false) {
  error('Cannot read mule.conf');
}
if (($muleConfSample = parse_ini_file('mule.conf.sample', true)) === false) {
  error('Cannot read mule.conf');
}

foreach ($muleConf as $sectionTitle => $sectionVars) {
  // Check that no new sections are defined
  if (!array_key_exists($sectionTitle, $muleConfSample)) {
    error("The section *** [$sectionTitle] *** is defined in mule.conf, but not in mule.conf.sample. Please add it to mule.conf.sample.");
  }

  foreach ($sectionVars as $key => $value) {
    // Check that no new variables are defined
    if (!array_key_exists($key, $muleConfSample[$sectionTitle])) {
      error("The variable *** [$sectionTitle].$key *** is defined in mule.conf, but not in mule.conf.sample. Please add it to mule.conf.sample.");
    }

    // Check that variable types haven't changed
    $type = gettype($value);
    $typeSample = getType($muleConfSample[$sectionTitle][$key]);
    if ($type != $typeSample) {
      error("The variable *** [$sectionTitle].$key *** has type '$type' in mule.conf, but type '$typeSample' in mule.conf.sample. Please reconcile them.");
    }
  }
}

/***************************************************************************/

function error($msg) {
  print "The pre-commit hook encountered an error.\n";
  print "If you know what you are doing, you can bypass this error by using the -n (--no-verify) flag:\n";
  print "\n";
  print "    git commit -n\n";
  print "\n";
  print "The error message was:\n";
  print $msg . "\n";
  exit(1);
}

?>
