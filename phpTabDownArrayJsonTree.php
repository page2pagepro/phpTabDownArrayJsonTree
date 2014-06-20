<?php

// original code: http://www.daveperrett.com/articles/2008/03/11/format-json-with-php/
// adapted to allow native functionality in php version >= 5.4.0
// https://github.com/GerHobbelt/nicejson-php
/**
 * Format a flat JSON string to make it more human-readable
 *
 * @param string $json The original JSON string to process
 *        When the input is not a string it is assumed the input is RAW
 *        and should be converted to JSON first of all.
 * @return string Indented version of the original JSON string
 */

function json_format($json) {
	if (!is_string($json)) {
		if (phpversion() && phpversion() >= 5.4) {
			return json_encode($json, JSON_PRETTY_PRINT);
		}

		$json = json_encode($json);
	}
	$result = '';
	$pos = 0; // indentation level
	$strLen = strlen($json);
	$indentStr = "\t";
	$newLine = "\n";
	$prevChar = '';
	$outOfQuotes = true;
	for ($i = 0; $i < $strLen; $i++) {
		// Grab the next character in the string
		$char = substr($json, $i, 1);
		// Are we inside a quoted string?
		if ($char == '"' && $prevChar != '\\') {
			$outOfQuotes = !$outOfQuotes;
		}
		// If this character is the end of an element,
		// output a new line and indent the next line
		else
		if (($char == '}' || $char == ']') && $outOfQuotes) {
			$result.= $newLine;
			$pos--;
			for ($j = 0; $j < $pos; $j++) {
				$result.= $indentStr;
			}
		}
		// eat all non-essential white-space in the input as we do our own here and it would only mess up our process
		else
		if ($outOfQuotes && false !== strpos(" \t\r\n", $char)) {
			continue;
		}
		// Add the character to the result string
		$result.= $char;
		// always add a space after a field colon:
		if ($char == ':' && $outOfQuotes) {
			$result.= ' ';
		}
		// If the last character was the beginning of an element,
		// output a new line and indent the next line
		if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
			$result.= $newLine;
			if ($char == '{' || $char == '[') {
				$pos++;
			}
			for ($j = 0; $j < $pos; $j++) {
				$result.= $indentStr;
			}
		}
		$prevChar = $char;
	}
	return $result;
}

// http://stackoverflow.com/questions/8881037/indented-list-to-multidimensional-array
function tabDown($list, $indentation = "\t") {
	$result = array();
	$path = array();
	// Line Endings: Make M$ Windows "\r\n" match Unix "\n" by remove the
	// carriage return effectively leaving the line feed.
	$list = preg_replace('[\r]', '', $list);
	foreach(explode("\n", $list) as $line) {
		// get depth and label
		$depth = 0;
		while (substr($line, 0, strlen($indentation)) === $indentation) {
			$depth+= 1;
			$line = substr($line, strlen($indentation));
		}
		// truncate path if needed
		while ($depth < sizeof($path)) {
			array_pop($path);
		}
		// keep label (at depth)
		$path[$depth] = $line;
		// traverse path and add label to result
		$parent = & $result;
		foreach($path as $depth => $key) {
			if (!isset($parent[$key])) {
				$parent[$line] = array();
				break;
			}
			$parent = & $parent[$key];
		}
	}
	// return
	return $result;
}
?>
