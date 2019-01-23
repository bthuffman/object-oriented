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
	use ValidateUuid;
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
	 * @return Uuid value of author id (or null if new author)
	 **/
	public function getAuthorId(): Uuid {
		return ($this->authorId);
	}
	 /**
	  * Mutator method for authorId
	  *
	  * @param Uuid| string $newAuthorId value of new author id
	  * @throws \RangeException if $newAuthorId is not positive
	  * @throws \TypeError if the author id is not the "uuid" type
	  */
	 public function setAuthorId( ): void {
	 	try {$newAuthorId
	 		$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
	 		$exceptionType = get_class($exception);
	 		throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the author id
		 $this->authorId = $uuid;
	 }
	 /**
	  * Accessor method for author's Avatar Url
	  *
	  * @return string value of the author's Avatar Url
	  */
	 public function getAuthorAvatarUrl() : string {
	 	return ($this->authorAvatarUrl);
	 }
	 /**
	  * Mutator method for author's Avatar Url
	  *
	  * @param string $newAuthorAvatarUrl
	  * @throws \InvalidArgumentException if the $newAuthorAvatarUrl is not a string or insecure
	  * @throws \RangeException if $newAuthorAvatarUrl is > 255 characters
	  * @throws \TypeError if $newAuthorAvatarUrl is not a string
	  */
	 public function setAuthorAvatarUrl(string $newAuthorAvatarUrl) : void {
	 	//verify the avatar url is secure
		 $newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		 $newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		 if(empty($newAuthorAvatarUrl) === true) {
		 	throw(new \InvalidArgumentException("Author Avatar Url is empty or insecure"));
		 }
		 // verify the at handle will fit in the database
		 if(strlen($newAuthorAvatarUrl) > 255) {
		 	throw(new \RangeException("Avatar Url at Author Avatar Url is too large"));
		 }
		 // store the new author avatar url
		 $this->authorAvatarUrl = $newAuthorAvatarUrl;
	 }
	/**
	 * accessor method for account activation token
	 *
	 * @return string value of the activation token
	 */
	public function getAuthorActivationToken() : string {
		return ($this->authorActivationToken);
	}
	/**
	 * mutator method for account activation token
	 *
	 * @param string $newAuthorActivationToken
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setAuthorActivationToken(string $newAuthorActivationToken): void {
		if($newAuthorActivationToken === null) {
			$this->authorActivationToken = null;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newAuthorActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}
	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 **/
	public function getAuthorEmail(): string {
		return $this->authorEmail;
	}
	/**
	 * mutator method for email
	 *
	 * @param string $newAuthorEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 **/
	public function setAuthorEmail(string $newAuthorEmail): void {
		// verify the email is secure
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newAuthorEmail) === true) {
			throw(new \InvalidArgumentException("author email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newAuthorEmail) > 128) {
			throw(new \RangeException("author email is too large"));
		}
		// store the email
		$this->authorEmail = $newAuthorEmail;
	}
	/**
	 * accessor method for authorHash
	 *
	 * @return string value of hash
	 */
	public function getAuthorHash(): string {
		return $this->authorHash;
	}
	/**
	 * mutator method for author hash password
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 97 characters
	 * @throws \TypeError if author hash is not a string
	 */
	public function setAuthorHash(string $newAuthorHash): void {
		//enforce that the hash is properly formatted
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new \InvalidArgumentException("author password hash empty or insecure"));
		}
		//enforce the hash is really an Argon hash
		$authorHashInfo = password_get_info($newAuthorHash);
		if($authorHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("author hash is not a valid hash"));
		}
		//enforce that the hash is exactly 97 characters.
		if(strlen($newAuthorHash) !== 97) {
			throw(new \RangeException("author hash must be 97 characters"));
		}
		//store the hash
		$this->authorHash = $newAuthorHash;
	}
	/**
	 * accessor method for author username
	 *
	 * @return author username
	 */
}