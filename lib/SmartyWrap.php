<?php

class SmartyWrap {
  private static $theSmarty = null;
  private static $cssFiles = array();
  private static $jsFiles = array();

  static function init($smartyClass) {
    self::$theSmarty = new Smarty();
    self::$theSmarty->template_dir = Util::$rootPath . '/templates';
    self::$theSmarty->compile_dir = Util::$rootPath . '/templates_c';
    self::assign('wwwRoot', Util::$wwwRoot);
    self::assign('user', Session::getUser());
    self::addCss('jqueryui', 'main');
    self::addJs('jquery', 'jqueryui', 'main');
  }

  static function assign($name, $value) {
    self::$theSmarty->assign($name, $value);
  }

  static function fetchEmail($templateName) {
    $result = self::$theSmarty->fetch('email/' . $templateName);
    return str_replace("\n", "\r\n", $result); // Acording to specs
  }

  static function display($templateName) {
    self::assign('cssFiles', self::$cssFiles);
    self::assign('jsFiles', self::$jsFiles);
    self::assign('templateName', $templateName);
    self::assign('flashMessage', FlashMessage::getMessage());
    self::assign('flashMessageType', FlashMessage::getMessageType());
    self::$theSmarty->display('layout.tpl');
  }

  static function addCss(/* Variable-length argument list */) {
    // Note the priorities. This allows files to be added in any order, regardless of dependencies
    foreach (func_get_args() as $id) {
      switch($id) {
      case 'jqueryui':           self::$cssFiles[1] = 'ui-lightness/jquery-ui-1.10.4.min.css'; break;
      case 'markitup':
        self::$cssFiles[2] = 'markitup/skin/style.css';
        self::$cssFiles[3] = 'markitup/set/style.css'; 
        break;
      case 'main':               self::$cssFiles[4] = 'main.css?v=1'; break;
      case 'jcrop':              self::$cssFiles[5] = 'jquery.Jcrop.min.css'; break;
      default:
        FlashMessage::add("Cannot load CSS file {$id}");
        Util::redirect(Util::$wwwRoot);
      }
    }
  }

  static function addJs(/* Variable-length argument list */) {
    // Note the priorities. This allows files to be added in any order, regardless of dependencies
    foreach (func_get_args() as $id) {
      switch($id) {
      case 'jquery':           self::$jsFiles[1] = 'jquery-1.11.0.min.js'; break; 
      case 'jqueryui':         self::$jsFiles[2] = 'jquery-ui-1.10.4.min'; break;
      case 'markitup':         
        self::$jsFiles[3] = 'jquery.markitup.js';
        self::$jsFiles[4] = 'markitup/set.js'; 
        break;
      case 'editProblem':      self::$jsFiles[5] = 'editProblem.js'; break;
      case 'main':             self::$jsFiles[6] = 'main.js?v=1'; break;
      case 'jcrop':            self::$jsFiles[7] = 'jquery.Jcrop.min.js'; break;
      default:
        FlashMessage::add("Cannot load JS script {$id}");
        Util::redirect(Util::$wwwRoot);
      }
    }
  }
}

?>
