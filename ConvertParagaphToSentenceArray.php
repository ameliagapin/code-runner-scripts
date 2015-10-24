<?php
/**
* Takes a given string and spits out a copy-and-pasteable PHP array of the sentences.
*
*
*/

//Make sure this is already escaped. Use something like http://www.freeformatter.com/javascript-escape.html
$string = "";

$result = split_sentences($string);
print_to_array($result);

function split_sentences($str, $end_of_sentence_characters = '.') {
	$inside_quotes = false;
	$buffer = "";
	$result = array();
	for ($i = 0; $i < strlen($str); $i++) {
		$buffer .= $str[$i];
		if ($str[$i] === '"') {
			$inside_quotes = !$inside_quotes;
		}
		if (!$inside_quotes) {
			if (preg_match("/[$end_of_sentence_characters]/", $str[$i])) {
				$result[] = $buffer;
				$buffer = "";
			}
		}
	}
	return $result;
}

function print_to_array($result) {
	echo 'array(', PHP_EOL;
	foreach($result as $line) {
		echo '    \'' . trim($line) . '\',', PHP_EOL;
	}
	echo ')';
}
?>