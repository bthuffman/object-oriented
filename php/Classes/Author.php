<?php
namespace BHuffman1\ObjectOriented;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 *
 * This contains the author class
 *
 * This is where information about an author can be found. Author is a top level entity for
 * various elements including two unique ones for username and email.
 *
 * @author Brandon Huffman <bt_huffman@msn.com>
 */
class author implements \JsonSerializable {
	/**
	 * Refers to the ValidateUuid.php
	 */
	use ValidateUuid;
	use ValidateDate;
	/**
	 * id for the author; this is the primary key
	 * @var Uuid $authorId
	 */
	private $authorId;
	/**
	 * url of the author avatar; normal state variable
	 * @var string $authorAvatarUrl
	 */
	private $authorAvatarUrl;
	/**
	 * activation token of the author;
	 * @var string $authorActivationToken
	 */
	private $authorActivationToken;
	/*
	 * email of the author; this is a unique key
	 * @var string $authorEmail
	 */
	private $authorEmail;
	/**
	 * hash for the author; normal state variable
	 * @var string $authorHash
	 */
	private $authorHash;
	/**
	 * username for the author; this is a unique key
	 * @var string $authorUsername
	 */
	private $authorUsername;
	/**
	 * Constructor for this author
	 *
	 * @param Uuid newAuthorId new author id
	 * @param string newAuthorAvatarUrl new author avatar url
	 * @param string newAuthorActivationToken new author activation token
	 * @param string newAuthorEmail new author email
	 * @param string newAuthorHash new author hash
	 * @param string newAuthorUsername new author username
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 * @Documentation http://php.net/manual/en/language.oop5.decon.php
	*/
	//note all magic methods start with two underbars __
	public function __construct($newAuthorId, string $newAuthorAvatarUrl, string $newAuthorActivationToken, string $newAuthorEmail, string $newAuthorHash, string $newAuthorUsername) {
	try {
		$this->setAuthorId($newAuthorId);
		$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
		$this->setAuthorActivationToken($newAuthorActivationToken);
		$this->setAuthorEmail($newAuthorEmail);
		$this->setAuthorHash($newAuthorHash);
		$this->setAuthorUsername($newAuthorUsername);
	}catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
	// determine the exception type that was thrown
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
}
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
	  * @throws \TypeError if the author id is not the "uuid" or string type
	  */
	 public function setAuthorId( $newAuthorId) : void {
	 	try {
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
		//verify activation token is secure
		$newAuthorActivationToken = trim($newAuthorActivationToken);
		$newAuthorActivationToken = filter_var($newAuthorActivationToken, FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorActivationToken) === true) {
			throw(new \InvalidArgumentException("Activation Token is empty or insecure"));
	}

		//verify the author activation token will fit in the database
		if(strlen($newAuthorActivationToken) > 32) {
			throw(new \RangeException("Activation Token is more than 32 characters"));
		}
		//store the activation token
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
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL,FILTER_FLAG_NO_ENCODE_QUOTES);
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
//		//enforce the hash is really an Argon hash
//		$authorHashInfo = password_get_info($newAuthorHash);
//		if($authorHashInfo["algoName"] !== "argon2i") {
//			throw(new \InvalidArgumentException("author hash is not a valid hash"));
//		}
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
	 * @return string value of author username
	 */
	public function getAuthorUsername(): string {
		return ($this->authorUsername);
	}
	/**
	 * mutator method for at handle
	 *
	 * @param string $newAuthorUsername new value of username
	 * @throws \InvalidArgumentException if $newAuthorUsername is not a string or insecure
	 * @throws \RangeException if $newAuthorUsername is > 32 characters
	 * @throws \TypeError if $newAuthorUsername is not a string
	 */
	public function setAuthorUsername(string $newAuthorUsername) : void {
		// verify the at handle is secure
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorUsername) === true) {
			throw(new \InvalidArgumentException("Author username is empty or insecure"));
		}
		// verify that author username will fit in the database
		if(strlen($newAuthorUsername) > 32) {
			throw(new \RangeException("Author username is too large"));
		}
		// store the new author username
		$this->authorUsername = $newAuthorUsername;
	}

	/**
	 * inserts this author into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername) VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, :authroUsername)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl->getBytes(), "authorActivationToken" => $this->authorActivationToken->getBytes(), "authorEmail" => $this->authorEmail->getBytes(), "authroHash" => $this->authorHash->getBytes(), "authorUsername" => $this->authorUsername->getBytes()];
		$statement->execute($parameters);
	}


	/**
	 * deletes this author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this author in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE author SET authorAvatarUrl = :authorAvatarUrl, authorActivationToken = :authorActivationToken, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl->getBytes(), "authorActivationToken" => $this->authorActivationToken->getBytes(), "authorEmail" => $this->authorEmail->getBytes(), "authroHash" => $this->authorHash->getBytes(), "authorUsername" => $this->authorUsername->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return Author|null author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?author {
		// sanitize the authorId before searching
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the author id to the place holder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);

		// grab the author from mySQL
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$author = new Author($row["authorId"], $row["authorAvatarUrl"], $row["authorActivationToken"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($author);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();
		$fields["authorAvatarUrl"] = $this->authorAvatarUrl->toString();

		return($fields);
	}
}