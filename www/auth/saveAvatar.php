<?php

require_once '../../lib/Util.php';

$user = Session::getUser();
if (!$user) {
  FlashMessage::add('You must login first.');
  Util::redirect(Util::$wwwRoot);
}

// Get path
define('AVATAR_RESOLUTION', 100);
define('AVATAR_QUALITY', 100);
$AVATAR_REMOTE_FILE = Util::$rootPath . "/www/img/user/{$user->id}.jpg";
$AVATAR_RAW_GLOB = Util::$rootPath . "/www/img/user/{$user->id}_raw.*";

// Get request
$x0 = Util::getRequestParameter('x0');
$y0 = Util::getRequestParameter('y0');
$side = Util::getRequestParameter('side');
$delete = Util::getRequestParameter('delete');
$discard = Util::getRequestParameter('discard');

// If delete, unlink current image
if ($delete) {
  unlink($AVATAR_REMOTE_FILE);
  FlashMessage::add('Image deleted.', 'info');
  Util::redirect(Util::$wwwRoot . 'auth/account');
}

// Get raw image path
$rawFileList = glob($AVATAR_RAW_GLOB);
if (empty($rawFileList)) {
  FlashMessage::add('Your profile picture is gone. Please reupload it.');
  Util::redirect(Util::$wwwRoot);
}
$rawFileName = $rawFileList[0];

// If discard, unlink raw image
if ($discard) {
  unlink($rawFileName);
  FlashMessage::add('Changes discarded.', 'info');
  Util::redirect(Util::$wwwRoot . 'auth/account');
}

// Create image
$canvas = imagecreatetruecolor(AVATAR_RESOLUTION, AVATAR_RESOLUTION);
$image = loadImage($rawFileName);
imagecopyresampled($canvas, $image, 0, 0, $x0, $y0, AVATAR_RESOLUTION, AVATAR_RESOLUTION, $side, $side);
sharpenImage($canvas);
imagejpeg($canvas, $AVATAR_RAW_GLOB, AVATAR_QUALITY);

// Move image
rename($AVATAR_RAW_GLOB, $AVATAR_REMOTE_FILE);
// Unlink raw image
unlink($rawFileName);

// Success
FlashMessage::add('Image saved.', 'info');
Util::redirect(Util::$wwwRoot . 'auth/account');

/* Load an image by its (supported) type */
function loadImage($file) {
  $size = getimagesize($file);
  switch ($size['mime']) {
    case 'image/jpeg': return imagecreatefromjpeg($file);
    case 'image/gif': return imagecreatefromgif($file);
    case 'image/png': return imagecreatefrompng($file);
    default: return null;
  }
}

/* Sharpen an image
 * Code courtesy of http://adamhopkinson.co.uk/blog/2010/08/26/sharpen-an-image-using-php-and-gd/
 */
function sharpenImage(&$i) {
  $sharpen = array(
    array(-1.2, -1.0, -1.2),
    array(-1.0, 22.0, -1.0),
    array(-1.2, -1.0, -1.2)
  );
  $divisor = array_sum(array_map('array_sum', $sharpen));
  imageconvolution($i, $sharpen, $divisor, 0);
}
