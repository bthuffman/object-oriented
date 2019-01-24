<?php
/**
 *PSR-4 Compliant Autoloader
 *
 * This SHOULD dynamically load classes by resolving the prefix and class name This is the method that frameworks such as
 * Laravel and Composer automatically resolve class names and load them. To use it, simply set the configurable parameters
 * inside the closure which I take to mean the requie_once line of code you see near the top of files.
 * This example is taken from PHP-FIG, referenced below.
 *
 * @param string $class fully qualified class name to load
 * @see http://www.php-fig.org/psr/psr-4/examples/ PSR-4 Example Autoloader
 */
spl_autoload_register(function($class){
	/**
	 * CONFIGURABLE PARAMETERS
	 * prefix: the prefix for all the classes (i.e., the namespace)
	 * baseDir: the base directory for all classes (default = current directory)
	 */
	$prefix = "BHuffman1\\ObjectOriented";
	$baseDir = __DIR__;

	// does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !==0) {
		//no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$className = substr($class, $len);

	// replace the namespace prefix with the base directory, replace namespace separators with directory
	//separators in the relative class name, append with .php
	$file = $baseDir . str_replace("\\","/", $className) . ".php";

	// if the file exists, require it
	if(file_exists($file)) {
		require_once($file);
	}
})
