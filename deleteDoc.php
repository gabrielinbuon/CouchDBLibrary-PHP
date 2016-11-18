<?php
require "./lib.php";

// Delete document requires 2 information
// First array is ID/Unique ID
// Second array is _REV ID, the revision ID 
$tpl = array(
		'19135a478262fa3399c89d40be029e28',
		'4-8199fafbf88c7d17aa142e37e826d0ad'
);


$obj->deleteDocument($tpl);