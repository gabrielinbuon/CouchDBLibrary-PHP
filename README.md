# CouchDBLibrary-PHP
Simple CouchDB CURL Library : PHP

A simple library for basic use.


### How to create database
Do not forget to include the library ``` require "./lib.php"; ```

You have to provide your database name in the parameter.
NOTE - replace ``` $dbname``` with your database name to be
```sh
$obj->createDatabase($dbname);
```

### How to create document
The best way to create new document is using template (at least to my experience)
You can store your template in different file inside tpl folder and call when necessary, 
but for now we will not go deep into that. Anyway, let's look the code below :

- Step 1
	we create array that holds the data of our document structure
	```sh
	$create_tpl = array(
		'_id' => 'uid',
		'title' => '123',
		'description' => '0',
		'author' => '0',
		'isbn' => ''
	);
	```
	NOTE : Do not change the code ``` '_id' => 'uid'``` the template method will generate UNIQUE ID and will change it automatically. It is mandatory to have this code in your document structure.

- Step 2
	we pass the template to template handler (this is mandatory or else create method will not know the document structure) so that UNIQUE ID can be created by template handler.
	```sh
	$obj->templates($create_tpl);
	```
- Step 3
	just call create method to create new document
	```sh
	$obj->createNewDocument();
	```
