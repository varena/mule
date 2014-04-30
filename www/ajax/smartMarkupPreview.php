<?php

require_once '../../lib/Util.php';

$data = Util::getRequestParameter('data');
echo SmartMarkup::toHTML($data);

?>
