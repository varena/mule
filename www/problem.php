<?php

require_once '../lib/Util.php';

$id = Util::getRequestParameter('id');
$user = Session::getUser();
$p = Problem::get_by_id($id);
$uploadingFile = isset($_FILES["file"]);

if (!$p || ($p->status != Problem::STATUS_NORMAL)) {
  FlashMessage::add(_('Requested problem not found.'));
  Util::redirect(Util::$wwwRoot);
}

if($uploadingFile)
  handleUpload($id,$user);

$p->statement = SmartMarkup::toHTML($p->statement);
SmartyWrap::assign('pageTitle', sprintf(_('Problem: %s'), $p->name));
SmartyWrap::assign('problem', $p);
SmartyWrap::assign('canEdit', canEdit($p, $user));
SmartyWrap::assign('author', User::get_by_id($p->userId));
SmartyWrap::display('problem.tpl');

function canEdit($mproblem, $uploader) {
	if($uploader == NULL) {
		return false;
	}
	return ($mproblem->userId == $uploader->id) || $uploader->admin;
}

function handleUpload($id,$muser){
  $ext = pathinfo($_FILES["file"]['name'],PATHINFO_EXTENSION);

  if($_FILES["file"]['name'] == '')
    FlashMessage::add(_("Select a file first!"));
  else if($ext != "c" && $ext != "cpp")
    FlashMessage::add(_("Invalid extension!"));
  else{
    $name=$_FILES["file"]["name"];
    $path="../" . Config::get('upload.path') . "/uploadedSources" . $id;
    move_uploaded_file($name,$path);

    $source=Model::factory('Source')->create();
    $source->userId = Session::getUser()->id;
    $source->problemId = $id;
    $source->extension = $ext;
    $source->evalStatus = Source::NOT_EVALUATED;
 
    FlashMessage::add(_("The source was saved."));
   }
}

?>
