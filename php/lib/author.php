<?php
namespace BHuffman1\ObjectOriented;

//require_once("Author.php");
require_once(dirname(__DIR__, 1) . "/Classes/Author.php");

use Ramsey\Uuid\Uuid;

//Load the author class
// use the constructor to create a new author
$author = new Author("0ad8fe66-6c0b-48d5-8fcb-9a51fce5554f","bhuff", "nananananananananananananananana","bt_huffman@msn.com", "babababababababababababababababababababababababababababababababababababababababababababababababab", "bhuff");
var_dump($author);

//Not sure about this
//$author->insert(pdo);
//no mySQL database passwords on github



