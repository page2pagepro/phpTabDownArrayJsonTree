phpTabDownArrayJsonTree
=======================

A tab-structured tree markup language. Convert outline, unordered lists, organizational charts, etc. into php Array and/or JSON string.

*Inspired by Javascript tabdown:*
https://github.com/freshdried/tabdown

**Credits:**
  * Dave Perrett
    * PHP &lt; 5.4 Json "indent" (prettify, json_format) concept
    * http://www.daveperrett.com/articles/2008/03/11/format-json-with-php/
  * "Yoshi" (http://stackoverflow.com/users/697154/yoshi)
    * PHP Plain Text (Not HTML DOM) "Indented List To Multidimensional Array"
    * http://stackoverflow.com/questions/8881037/indented-list-to-multidimensional-array
  * Improvements upon Dave Perret's Code:
    * https://github.com/Keeguon/nicejson-php
    * https://github.com/GerHobbelt/nicejson-php


**Hierarchical organization _Input_**
```PHP
<?php

$org_chart = <<<HEREDOC
Constitution
	Legislative Branch
		Congress
			Senate
			House of Representatives
	Executive
		President
			Vice President
			Cabinet
	Judicial
		Supreme Court
		Other Federal Courts
HEREDOC;

@(include_once("phpTabDownArrayJsonTree.php")) OR die ("Failed to include phpTabDownArrayJsonTree.php");

// Convert to Array
$tabDown = tabDown($org_chart);

// Make Json
$json = json_format(json_encode($tabDown));

// Show Output
header('Content-type: application/json');
echo $json;

?>
```

**Hierarchical organization _Output_**
```json
{
	"Constitution\r": {
		"Legislative Branch\r": {
			"Congress\r": {
				"Senate\r": [
					
				],
				"House of Representatives\r": [
					
				]
			}
		},
		"Executive\r": {
			"President\r": {
				"Vice President\r": [
					
				],
				"Cabinet\r": [
					
				]
			}
		},
		"Judicial\r": {
			"Supreme Court\r": [
				
			],
			"Other Federal Courts": [
				
			]
		}
	}
}
```
