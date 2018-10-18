<?php

// backward compatibility
if ( ! class_exists( '\PHPUnit\Framework\TestCase' ) && class_exists( '\PHPUnit_Framework_TestCase' ) ) {
	if ( version_compare( PHP_VERSION, '5.3', '<=' ) ) {
		class_alias( '\PHPUnit_Framework_TestCase', 'PHPUnit\Framework\TestCase' );
	} else {
		class_alias( '\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase' );
	}
}

require dirname( dirname( __FILE__ ) ) . '/insert-content.php';
