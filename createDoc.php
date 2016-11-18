<?php
require "./lib.php";

// Sample Template
$create_tpl = array(
		'_id' => 'uid',
		'title' => '123',
		'description' => '0',
		'author' => '0',
		'isbn' => ''
);

// First initiate template before createNewDocument call
// This is mandatory
// $create_tpl is your data
$obj->templates($create_tpl);

// Initiate new document creation
$obj->createNewDocument();