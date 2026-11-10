<?php
/**
 * Prints the PHPUnit configuration file that matches the installed version of PHPUnit.
 *
 * PHPUnit 10 changed the configuration file format, so PHPUnit 9 and earlier use
 * phpunit.xml.dist and tests/phpunit/multisite.xml, while PHPUnit 10 and later use
 * phpunit10.xml.dist and tests/phpunit/multisite10.xml.
 *
 * Pass one of those files to get its counterpart for the installed version. Any other file
 * is printed unchanged. With no argument, a local phpunit.xml is printed if one exists,
 * otherwise the single site configuration file for the installed version.
 *
 * The printed path is relative to the root of the repository.
 *
 * Usage: ./vendor/bin/phpunit -c "$(php tests/phpunit/phpunit-config.php [file])"
 */

$root = dirname( __DIR__, 2 );

$installed     = require $root . '/vendor/composer/installed.php';
$is_phpunit_10 = version_compare( $installed['versions']['phpunit/phpunit']['version'], '10', '>=' );

$swaps = array(
	'phpunit.xml.dist'            => 'phpunit10.xml.dist',
	'tests/phpunit/multisite.xml' => 'tests/phpunit/multisite10.xml',
);

if ( ! $is_phpunit_10 ) {
	$swaps = array_flip( $swaps );
}

if ( ! isset( $argv[1] ) ) {
	if ( file_exists( $root . '/phpunit.xml' ) ) {
		echo 'phpunit.xml';
	} else {
		echo $is_phpunit_10 ? 'phpunit10.xml.dist' : 'phpunit.xml.dist';
	}
	exit;
}

$config = $argv[1];
$real   = realpath( $config );

foreach ( $swaps as $from => $to ) {
	if ( false !== $real && realpath( $root . '/' . $from ) === $real ) {
		$config = $to;
		break;
	}
}

echo $config;
