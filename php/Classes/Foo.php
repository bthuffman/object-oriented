<?php
/**
 *
 * This contains the author class
 *
 * This is where information about an author can be found. Author is a top level entity for
 * various elements including two unique ones for username and email.
 *
 * @author Brandon Huffman <bt_huffman@msn.com>
 */
class author{
	/**
	 * id for the author; this is the primary key
	 */
	private $authorId;
	/**
	 * url of the author; normal state variable
	 */
	private $authorAvatarUrl;
	/**
	 * activation token of the author;
	 */
	private $authorActivationToken;
	/*
	 * email of the author; this is a unique key
	 */
	private $authorEmail;
	/**
	 * hash for the author; normal state variable
	 */
	private $authorHash;
	/**
	 * username for the author; this is a unique key
	 */
	private $authorUsername;
	/**
	 *Accessor method for authorId
	 *
	 * @return Uuid value of profile id (or null if new Profile)
	 **/
	public function getAuthorId(): Uuid {
		return ($this->authorId);
	}
	 /**
	  * Mutator method for authorId
	  *
	  * @param Uuid| string $newAuthorId value of new
	  */
}