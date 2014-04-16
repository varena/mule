<?php

class Problem extends BaseObject {

  const STATUS_NORMAL = 0;
  const STATUS_DELETED = 1;
  static $STATUS_NAMES = array(self::STATUS_NORMAL => 'normală',
                               self::STATUS_DELETED => 'ștearsă');

}

?>
