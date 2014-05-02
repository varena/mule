<?php


require_once '../lib/Util.php';

Util::requireLoggedIn();
$id = Util::getRequestParameter('id');
$problemStatement = Util::getRequestParameter('problemStatement');
$problemName = Util::getRequestParameter('problemName');
$mproblem = Problem::get_by_id($id);
$uploader = Session::getUser(); 
$uploading = $_SERVER['REQUEST_METHOD'] === 'POST';


if($id != null && !$uploading) {

  if (!$mproblem) {
    FlashMessage::add(_('Requested problem not found.'));
    Util::redirect(Util::$wwwRoot);
  }
  if(!canEdit()) {
    FlashMessage::add(_('You do not have permission to edit this problem.'));
    Util::redirect(Util::$wwwRoot);
  }

  SmartyWrap::addJs('editProblem');
  SmartyWrap::addJs('markitup');
  SmartyWrap::addCss('markitup');
  SmartyWrap::assign('pageTitle', sprintf(_("Editing Problem: %s"), $mproblem->name));
  SmartyWrap::assign('problem', $mproblem);
  SmartyWrap::assign('canEditName', $uploader->admin);
  SmartyWrap::display('editProblem.tpl');
} else if($uploading) {
  if(!canEdit()) {
    FlashMessage::add(_('You are not allowed to do this.'));
    Util::redirect(Util::$wwwRoot);
  }
  $mproblem->statement = trim($problemStatement);

  if($uploader->admin) {
    $namecand = $problemName;
    $got = Problem::get_by_name($namecand);
    if($got && $got->id != $id) {
      FlashMessage::add(_('That problem name is already taken!'));
      Util::redirect('problem?id=' . $id);
    } else {
      $mproblem->name = $namecand;
    }
  }
  $mproblem->save();
  FlashMessage::add(_('Updated problem successfully!'), 'info');
  Util::redirect('problem?id=' . $id);

} else {
  FlashMessage::add(_('Invalid data.'));
  Util::redirect(Util::$wwwRoot);
}

function canEdit() {
  global $mproblem, $uploader;
  return ($mproblem->userId == $uploader->id) || $uploader->admin;
}

?>
