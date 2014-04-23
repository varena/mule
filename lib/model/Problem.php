<?php

class Problem extends BaseObject {

  const STATUS_NORMAL = 0;
  const STATUS_DELETED = 1;
  static $STATUS_NAMES = array(self::STATUS_NORMAL => 'normală',
                               self::STATUS_DELETED => 'ștearsă');
  static function getAllByRoundId($id) {
	$rProblems = Model::factory('Round_Problem')->where('roundId', $id)->order_by_asc('id')->find_many();
        for($i = 1; $i <= count($rProblems); $i++)
	    $nProblems[$i] = Model::factory('Problem')->where('id',$rProblems[$i]->problemId)->find_one();     
    	return $nProblems;
  }
}

?>
