<?php

/*
  Written by Vlad-Alexandru "StelarCF" Sănduleac
  Distributed under the same licence as the varena project http://github.com/varena/varena
  Written 21.04.2014
*/

// Format SmartMarkup:
// *text* - bold
// **text** - italic
// ~~text~~ - strikethrough
// ./text/. - blockquote (as pune ." "., dar mi-e frica ca apoi o sa intre in locurile unde ar vrea sa fie un quote inline)
// .[text]. - tabel
/// .|text|. - linie de tabel
/// .-text-. - cell in cadrul liniei
/// [text](URL) - link (ca in Markup)
// &[size]text& - schimba marimea textului (de exemplu pt headere)
// .(URL) - afiseaza imaginea aflata la URL

class SmartMarkup {
  public static function toHTML($str) {
    $html = "";
    $bold = false;
    $italic = false;
    $strike = false;
    //$str .= "  "; // un mic tabulator la sfarsit ca sa prevenim out of bound.
    for($i = 0; $i < strlen($str); $i++) {
      $next = ($i < strlen($str) - 1) ? $str[$i + 1] : null;
      if($str[$i] == '\\') {
        $i++;
        $html .= $str[$i];
      } else {
        if($str[$i] == '*') {
          if($next == '*') {
            $i++;
            if($italic)
              $html .= "</i>";
            else $html .= "<i>";
            $italic = !$italic;
          } else {
            if($bold)
              $html .= "</b>";
            else $html .= "<b>";
            $bold = !$bold;
          }
        } else if($str[$i] == '~' && $next == '~') {
          $i++;
          if($strike)
            $html .= "</del>"; // As pune aici o verificare daca e HTML5 sau HTML4, fiindca in HTML5 <strike> e deprecated
          else $html .= "<del>";
          $strike = !$strike;
        } else if($str[$i] == '.') {
          if($next == '/') {
            $i++;
            $html .= "<blockquote>";
          } else if($next == '[') {
            $i++;
            $html .= "<table border=\"1\">";
          } else if($next == '|') {
            $i++;
            $html .= "<tr>";
          } else if($next == '-') {
            $i++;
            $html .= "<td>";
          } else if($next == '(') {
            $url = "";
            $complete = false;
            for($j = $i + 2; $j < strlen($str); $j++)
              if($str[$j] == '\"')
                $url .= "\\\"";
              else if($str[$j] == ')') {
                $complete = true;
                break;
              } else $url .= $str[$j];
            if(!$complete) {
              $html .= $str[$i];
              continue;
            }
            $i += strlen($url) + 2;
            $html .= "<img src=\"" . $url . "\"\\>";
          }
          else $html .= $str[$i];
        } else if($str[$i] == '&') {
          if($next == '[') {
            $texts = "";
            $size = 0;
            $text = "";
            $complete = false;
            for($j = $i + 2; $j < strlen($str); $j++)
              if($str[$j] == ']') {
                $complete = true;
                break;
              }
              else $texts .= $str[$j];
            if(!$complete) {
              $html .= $str[$i];
              continue;
            }
            $size = intval($texts); // facem conversia ca sa prevenim insertie de cod
            $complete = false;
            for($j++; $j < strlen($str); $j++)
              if($str[$j] == '\\') {
                $text .= $str[$j + 1];
                $j++;
                continue;
              } else if($str[$j] == '&') {
                $complete = true;
                break;
              }
              else $text .= $str[$j];
            if(!$complete) {
              $html .= $str[$i];
              continue;
            }
            $i += strlen($texts . $text) + 3; // sari peste sectiunea dinauntru
            $html .= "<span style=\"font-size:" . $size . "px\">" . self::toHTML($text) . "</span>"; // folosim <span> deoarece <size> e deprecat in HTML5
          }
          else $html .= $str[$i];
        } else if($str[$i] == '['){
          $text = "";
          $url = "";
          $complete = false;
          for($j = $i + 1; $j < strlen($str); $j++)
            if($str[$j] == '\\') {
              $j++;
              $text .= $str[$j];
            } else if($str[$j] == ']') {
              $complete = true;
              break;
            } else $text .= $str[$j];
          if(!$complete || $str[$j + 1] != '(') {
            $html .= $str[$i];
            continue;
          }
          $complete = false;
          for($j += 2; $j < strlen($str); $j++)
            if($str[$j] == '\\') {
              $j++;
              $url .= $str[$j];
            } else if($str[$j] == ')') {
              $complete = true;
              break;
            } else $url .= $str[$j];
          if(!$complete) {
            $html .= $str[$i];
            continue;
          }
          $i += strlen($text . $url) + 3;
          $html .= "<a href=\"" . $url . "\">" . self::toHTML($text) . "</a>";
        } else if($next == '.') {
          if($str[$i] == '/') {
            $i++;
            $html .= "</blockquote>";
          } else if($str[$i] == ']') {
            $i++;
            $html .= "</table>";
          } else if($str[$i] == '|') {
            $i++;
            $html .= "</tr>";
          } else if($str[$i] == '-') {
            $i++;
            $html .= "</td>";
          }
          else $html .= $str[$i];
        } else if($str[$i] == '<')
          $html .= "&lt"; // prevenim HTML insertion
        else if($str[$i] == '>')
          $html .= "&gt"; // aidoma
        else if($str[$i] == '\n')
          if($next == '\n') {
            $html .= "<p>";
            $i++;
          } else $html .= "<br>";
        else $html .= $str[$i];
      }
    }
    return $html;
  }
};

?>
