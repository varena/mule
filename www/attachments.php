<?php

require_once '../lib/Util.php';

Util::requireLoggedIn();

$problemId = Util::getRequestParameter('id');
$attachmentId = Util::getRequestParameter('download');
$uploader = Session::getUser(); 
$uploadingFile = isset($_FILES["file"]);

if($problemId != null && !$uploadingFile) { //View problem
  $p = Problem::get_by_id($problemId);

  $attaches = Model::factory('Attachment')->where('probId', $problemId)->order_by_asc('created')->find_many();

  SmartyWrap::addJs('timeago');

  SmartyWrap::assign('pageTitle', sprintf(_('Attachments: %s'), $p->name));
  SmartyWrap::assign('problem', $p);
  SmartyWrap::assign('attaches', $attaches);
  SmartyWrap::assign('showAttach', canAttach($p));
  SmartyWrap::assign('posUploads', getUploadAccess());

  SmartyWrap::display('attachments.tpl');

}  else if($attachmentId != null) { //Download file 
  $attach = Attachment::get_by_id($attachmentId);
  $probId = $attach->probId;
  if(!canDownload($attach, $probId)) {
    FlashMessage::add(_('You can\'t download this file.'));
    Util::redirect(Util::$wwwRoot);
  }

  $actualFile = $attach->getPath();
  if (file_exists($actualFile)) {
   header('Content-Description: File Transfer');
   header('Content-Type: application/octet-stream');
   header('Content-Disposition: attachment; filename='.basename($actualFile));
   header('Content-Transfer-Encoding: binary');
   header('Expires: 0');
   header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
   header('Pragma: public');
   header('Content-Length: ' . filesize($actualFile));
   ob_clean();
   flush();
   readfile($actualFile);
 } else {
  FlashMessage::add(_('File not found'));
  Util::redirect(Util::$wwwRoot);
}
} else if($uploadingFile) //Upload file
{
  $p = Problem::get_by_id($problemId);
  $at = (int) $_POST["access_type"];
  if(!canUpload($p, $at)) {
      FlashMessage::add(_("You can\'t upload this file, nice try though!")); //Can't normally get here
      Util::redirect(Util::$wwwRoot);
    }

    $newpathdir = Attachment::getDirectoryForId($problemId);
    $temp = array();
    foreach ($_FILES['file'] as $key => $value) {
      foreach($value as $index => $val){
        $temp[$index][$key] = $val;
      }
    }

    if($temp[0]['name'] == '') {
      FlashMessage::add(_("Select a file first!"));
      Util::redirect(Util::$wwwRoot . "attachments?id=" . $problemId);
      return;
    }

    $goodFiles = 0;
    for ($i = 0; $i < count($temp); $i++) {
      $eachfile = $temp[$i];
      $newpath = Attachment::getPathForArguments($problemId, $eachfile["name"]);

      if (!file_exists($newpathdir)) {
        mkdir($newpathdir, 0755, true); 
      }
      if (file_exists($newpath))
      {
        FlashMessage::add(sprintf(_("File %s already exists!"), $eachfile["name"]));
      }
      else
      {
        move_uploaded_file($eachfile["tmp_name"],$newpath);
        $entry = Model::factory('Attachment')->create();
        $entry->file = $eachfile["name"];
        $entry->probId = $problemId;
        $entry->userId=$uploader->id;
        $entry->access = $at;
        $entry->save();
        $goodFiles++;
      }
    }
    $msg = sprintf(_('%d file(s) uploaded successfully'), $goodFiles);
    FlashMessage::add($msg, 'info');
    Util::redirect(Util::$wwwRoot . "attachments?id=" . $problemId);
  } else {
    FlashMessage::add(_("Invalid data"));
    Util::redirect(Util::$wwwRoot);
  } 


//Methods

  function canAttach($problem) {
    global $problemId, $uploader;
    $author = $problem->userId == $uploader->id;
    $admin = $uploader->admin == 1;
    return $author || $admin;
  }

  function canUpload($problem, $type) {
    if(!canAttach($problem)) {
      return false;
    }
    global $problemId, $uploader;
    $author = $problem->userId == $uploader->id;
    $admin = $uploader->admin;
    if($type == Attachment::ACCESS_PUBLIC || $type == Attachment::ACCESS_AUTHOR) {
      return true;
    }
    if($admin && $type = Attachment::ACCESS_ADMIN) {
      return true;
    }
    return false;
  }

  function getUploadAccess() {
    global $problemId, $uploader;
    $problem = Problem::get_by_id($problemId);
    $author = $problem->userId == $uploader->id;
    $admin = $uploader->admin;
    if($admin) {
      return array(Attachment::$ACCESS_NAMES[Attachment::ACCESS_PUBLIC],Attachment::$ACCESS_NAMES[Attachment::ACCESS_AUTHOR], Attachment::$ACCESS_NAMES[Attachment::ACCESS_ADMIN]);
    }
    if($author) {
      return array(Attachment::$ACCESS_NAMES[Attachment::ACCESS_PUBLIC],Attachment::$ACCESS_NAMES[Attachment::ACCESS_AUTHOR]);
    }
    return array();

  }

  function canDownload($attachment, $problemId) { 
    global $uploader;
    $problem = Problem::get_by_id($problemId);
    $author = $problem->userId == $uploader->id;
    $admin = $uploader->admin;
    if($admin) {
      return true;
    }
    if($attachment->access == Attachment::ACCESS_PUBLIC) {
      return true;
    }
    if($author && $attachment->access == Attachment::ACCESS_AUTHOR) {
      return true;
    }
    return false;
  }

  ?>
