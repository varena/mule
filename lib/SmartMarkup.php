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

class SmartMarkup {
	public static function toHTML($str) {
		$html = "";
		$bold = false;
		$italic = false;
		$strike = false;
		for($i = 0; $i < strlen($str); $i++) {
			if($str[$i] == '\\') {
				$i++;
				$html .= $str[$i];
			} else {
				if($str[$i] == '*') {
					if($str[$i + 1] == '*') {
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
				} else if($str[$i] == '~' && $str[$i + 1] == '~') {
					$i++;
					if($strike)
						$html .= "</del>"; // As pune aici o verificare daca e HTML5 sau HTML4, fiindca in HTML5 <strike> e deprecated
					else $html .= "<del>";
					$strike = !$strike;
				} else if($str[$i] == '.') {
					if($str[$i + 1] == '/') {
						$i++;
						$html .= "<blockquote>";
					} else if($str[$i + 1] == '[') {
						$i++;
						$html .= "<table>";
					} else if($str[$i + 1] == '|') {
						$i++;
						$html .= "<tr>";
					} else if($str[$i + 1] == '-') {
						$i++;
						$html .= "<td>";
					}
					else $html .= $str[$i];
				} else if($str[$i] == '&') {
				} else if($str[$i] == '('){
				} else if($str[$i + 1] == '.') {
					if($str[$i] == '/') {
						$i++;
						$html .= "</blockquote>"
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
				}
				else $html .= $str[$i];
			}
		}
		return $html;
	}
};

?>