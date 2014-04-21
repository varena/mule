<?php

class SmartMarkup {
	function toHTML($str) {
		string $html;
		bool bold;
		bool italic;
		bool strike;
		for($i = 1; $i < sizeof($str); $i++) {
			if($str[i] == '\\') {
				$i++;
				$html .= $str[i]
			} else {
				if($str[i] == '*') {
					if($str[i + 1] == '*') {
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
				} else if($str[i] == '~' && str[i + 1] == '~') {
					$i++;
					if($strike)
						$html .= "</del>"; // As pune aici o verificare daca e HTML5 sau HTML4, fiindca in HTML5 <strike> e deprecated
					else $html .= "<del>";
					$strike = !$strike;
				}
			}
		}
		return $html
	}
}

?>