<?php
require "./lib.php";

// update tempalte should be or should not be the same as create_tpl structure
// Based on your requirement to update, you have to provide array keys and values
// _REV is mandator - you must provide _REV details, you can always get REV data from database
// How you retrieve REV data depends on you. There are 2 ways to retrieve REV data
// 1. getDocumentByID($id) - if you know the id you want to work with
// 2. getDocuments() - and retrieve them by key or value etc.

$update_tpl = array(
		'_rev' => '3-44d1cdf01e7c45e3801a1405734041fd',
		'title' => '123',
		'description' => '0',
		'author' => '0',
		'isbn' => ''
);

$obj->templates($create_tpl);

// First parameter is ID
// Second Parameter is Template
$obj->updateDocument($id, $update_tpl);