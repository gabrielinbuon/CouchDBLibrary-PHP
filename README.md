# CouchDBLibrary-PHP
Simple CouchDB CURL Library : PHP

This is just a simple library for basic use. Can be extended as it goes.
If time permit me I will work on improving and from next update it will go as version 1.0 ++

Please feel free to comment and write your suggestion.


### How to create database
Do not forget to include the library ```sh require "./lib.php"; ```

You have to provide your database name in the parameter.
NOTE - replace ```sh$dbname``` with your database name to be
```sh
$obj->createDatabase($dbname);
```

### How to create document
The best way to create new document is using template (at least to my experience)
You can store your template in different file inside tpl folder and call when necessary, 
but for now we will not go deep into that. Anyway, let's look the code below :

First: we create array that holds the data of our document structure
```sh
$create_tpl = array(
		'_id' => 'uid',
		'title' => '123',
		'description' => '0',
		'author' => '0',
		'isbn' => ''
);
```
Second: we pass the template to template handler (this is mandatory or else create method will not know the document structure)
```sh
$obj->templates($create_tpl);
```
Third: just call create method to create new document
```sh
$obj->createNewDocument();
```
