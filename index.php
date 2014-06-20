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
