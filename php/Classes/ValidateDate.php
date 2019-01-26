<?php
/**
 *
 * Validates Dates/Datetimes
 *
 * Created by PhpStorm.
 * User: bhuff
 * Date: 1/23/2019
 * Time: 12:00 PM
 */
namespace BHuffman1\ObjectOriented;
/**
 * Trait to validate a mySQL date
 *
 * This trait will inject a private method to validate a mySWL style date (i.e. Y-m-d H-i-s.u). It will
 * create a string representation to a DateTime Object or throw an exception
 *
 * @author Brandon Huffman <bt_huffman@msn.com>
 * @version 7.2.12
 */
trait ValidateDate {
	/**
	 * custom filter for mySQL date
	 *
	 * Converts a string to a DateTime object; this is designed to be used within a mutator method.
	 *
	 * @param \DateTime|string $newDate date to validate
	 * @return \DateTime DateTime object containing the validated date
	 * @see http://php.net/manual/class.datetime.php PHP's class
	 * @throws \InvalidArgumentException if the date is in an invalid format
	 * @throws \RangeException if the date is not a Gregorian date
	 * @throws \TypeError when type hints fail
	 */
	private static function validateDate($newDate) : \DateTime {
		// base case: if the date is a Datetime object, there's no work to be done
		if(is_object($newDate) === true && get_class($newDate) === "DateTime") {
			return ($newDate);
		}
		//treat the date as a mySQL date string: Y-m-d
		$newDate = trim($newDate);
		if((preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $newDate, $matches)) !== 1) {
			throw(new \InvalidArgumentException("date is not a valid date"));
		}
		// verify the date is really a valid calendar date
		$year = intval($matches[1]);
		$month = intval($matches[2]);
		$day = intval($matches[3]);
		if(checkdate($month, $day, $year) === false) {
			throw(new \RangeException("date is not a Gregorian date"));
		}
		//if we got here, the date is clean
		$newDate = \DateTime::createFromFormat("Y-m-d H:i:s", $newDate . "00:00:00");
		return($newDate);
	}
/**
 * custom filter for mySQL style dates
 *
 * Converts a string to a DateTime Object; this is designed to be used within a mutator method
 *
 * @param mixed $newDateTime date to validate
 * @return \DateTime DateTime ojbect containing the validated date
 * @see http://php.net/manual/en/class.datetime.php PHP's DateTime class
 * @throws \InvalidArgumentException if the date is in an invalid format
 * @throws \RangeException if the date is not a Gregorian date
 * @throws \TypeError when type hints fail
 * @throws \Exception if some other error occurs
 */
	private static function validateDateTime($newDateTime) : \DateTime {
		// base case: if the date is a DateTime object, there's no work to be done
		if(is_object($newDateTime) === true && get_class($newDateTime) === "DateTime") {
			return ($newDateTime);
		}
		try {
			list($date, $time) = explode("", $newDateTime);
			$date = self::validateDate($date);
			$time = self::validateTime($time);
			list($hour, $minute, $second) = explode(":", $time);
			list($second, $microseconds) = explode(":", $second);
			$date->setTime($hour, $minute, $second, $microseconds);
			return($date);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
}
/**
 *Custom filter for mySQl style times
 *
 * validates a time string; this is designed to gbe used within a mutator method.
 *
 * @param string $newTime time to validate
 * @return string validated time as a string H:i:s[.u]
 * @see http://php.net/manual/en/class.datetime.php PHP's DateTime class
 * @throws \InvalidArgumentException if the date is in an invalid format
 * @throws \RangeException if the date is not a Gregorian date
 */
	private static function validateTime($newTime) : string {
		// treat the date as a mySQL date string: H:i:s[.u]
		$newTime = trim($newTime);
		if((preg_match("/^(\d{2}):(\d{2}):(\d{2})(?(?=\.)\.(\d{1,6}))$/", $newTime, $matches)) !== 1) {
		throw(new \InvalidArgumentException("time is not a valid time"));
		}
		// verify the date is really a valid calender date
		$hour = intval($matches[1]);
		$minute = intval($matches[2]);
		$second = intval($matches[3]);
		// vefity the time is really a valid wall clock time
		if($hour < 0 || $hour >= 24 || $minute < 0 | $minute >= 60 | $second < 0 | $second >= 60) {
			throw(new \RangeException("Date is not a valid wall clock time"));
		}
		// put a placeholder for microseconds if they do not exist
		$microseconds = $matches[4] ?? "0";
		$newTime = "$hour, $minute:$second.$microseconds";
		//if we get to here, the date is clean Hooray!
		return($newTime);
	}
}