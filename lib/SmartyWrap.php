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

    self::$theSmarty->registerPlugin('modifier', 'vdf', array('SmartyWrap', 'modifier_vdf'));
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
      case 'timeago':         
        self::$jsFiles[5] = 'jquery.timeago.js';
        self::$jsFiles[6] = 'enable.timeago.js';
        break;
      case 'editProblem':      self::$jsFiles[7] = 'editProblem.js'; break;
      case 'main':             self::$jsFiles[8] = 'main.js?v=1'; break;
      case 'jcrop':            self::$jsFiles[9] = 'jquery.Jcrop.min.js'; break;
      case 'avatar':
        self::$jsFiles[10] = 'avatar/addAvatar.js';
        self::$jsFiles[11] = 'avatar/editAvatar.js';
        break;
      default:
        FlashMessage::add("Cannot load JS script {$id}");
        Util::redirect(Util::$wwwRoot);
      }
    }
  }

  static function modifier_vdf($timestamp, $format=TimeUtil::FORMAT_SECOND, $short = true) {
    if($format == TimeUtil::FORMAT_FUZZY) {
        $isoTimestamp = date('c', $timestamp);
        return '<time class="timeago" datetime="' . $isoTimestamp . '">Loading...</time>';
    } else if($format == TimeUtil::FORMAT_DAY) {
        $theFormat = Config::get('time.dayformat');
    } else if($format == TimeUTIL::FORMAT_MINUTE) {
        $theFormat = Config::get('time.minuteformat');
    } else if($format == TimeUTIL::FORMAT_SECOND) {
        $theFormat = Config::get('time.secondformat');
    } else {
        return "Date Format error";
    }
    if($short == false) {
        $theFormat = str_replace("%E", "%e", strtoupper($theFormat));
    }
    return strftime($theFormat, $timestamp);
}

}

?>
