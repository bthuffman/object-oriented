<?php
namespace bhuffman1\objectOriented;

//require_once("Author.php");
require_once(dirname(_DIR_, 1) . "/Classes/Author.php");

use Ramsey\Uuid\Uuid;

//Load the author class
// use the constructor to create a new author
$author = new Author(1,"bhuff",123,"bt_huffman@msn.com","code123","bhuff");
var_dump($author);