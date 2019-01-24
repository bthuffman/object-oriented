<?php
namespace BHuffman1\ObjectOriented;

//require_once("Author.php");
require_once(dirname(__DIR__, 1) . "/Classes/Author.php");

use Ramsey\Uuid\Uuid;

//Load the author class
// use the constructor to create a new author
$author = new Author(1,"bhuff",123,"bt_huffman@msn.com","code123","bhuff");
var_dump($author);