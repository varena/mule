<?php

require_once '../../lib/Util.php';

// Get file
$file = Util::getUploadedFile('avatarFileName');
$error = '';

// Test file
if (!$file) {
  $error = 'Invalid file.';
} else if ($file['size'] > (1<<21)) {
  $error = 'Maximum file size allowed is 2 MB.';
} else if (!in_array($file['type'], array('image/gif', 'image/jpeg', 'image/png'))) {
  $error = 'Invalid file type.';
} else if ($file['error']) {
  $error = 'Error uploading file.';
}

// If error, return
if ($error) {
  FlashMessage::add($error);
  Util::redirect(Util::$wwwRoot . 'auth/account');
}

// Get user
$user = Session::getUser();
if (!$user) {
  FlashMessage::add('You must login first.');
  Util::redirect(Util::$wwwRoot);
}

// Clear old files
$oldFiles = glob(Util::$rootPath . "/www/img/user/{$user->id}_raw.*");
foreach ($oldFiles as $oldFile) {
  unlink($oldFile);
}

// Get extension and set image path
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$destFileName = Util::$rootPath . "/www/img/user/{$user->id}_raw.{$ext}";

// Move file
if (!move_uploaded_file($file['tmp_name'], $destFileName)) {
  FlashMessage::add('Error copying file.');
  Util::redirect(Util::$wwwRoot . 'auth/account');
}
chmod($destFileName, 0777);

SmartyWrap::addCss('jcrop');
SmartyWrap::addJs('jcrop', 'avatar');
SmartyWrap::assign('page_title', "Edit profile picture");
SmartyWrap::assign('rawFileName', "{$user->id}_raw.{$ext}");
SmartyWrap::display('auth/editAvatar.tpl');

?>
