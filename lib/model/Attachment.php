<?php

class Attachment extends BaseObject {

  const ACCESS_PUBLIC = 1;
  const ACCESS_AUTHOR = 2;
  const ACCESS_ADMIN = 3;
  static $ACCESS_NAMES = [];

  static function init() {
    self::$ACCESS_NAMES[self::ACCESS_PUBLIC] = _("Public");
    self::$ACCESS_NAMES[self::ACCESS_AUTHOR] = _("Author");
    self::$ACCESS_NAMES[self::ACCESS_ADMIN] = _("Admin");
  }

  function getPath() {
  	$probId = $this->probId;
  	return Attachment::getPathForArguments($probId, $this->file);
  }

  static function getPathForArguments($problemId, $file) {
  	return Attachment::getDirectoryForId($problemId) . $file;
  }

  static function getDirectoryForId($problemId) {
  	return "../" . Config::get('upload.path') . "/p" . $problemId . "/";
  }

}

Attachment::init();

?>
