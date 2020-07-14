<?php

/**
 * Base class for SAM test cases, provides some utility methods for creating
 * objects.
 */
abstract class SAMTestCase extends UnitTestCase
{
  /**
   * Generate a random 8-character string. Useful for ensuring
   * multiple test suite runs don't conflict
   */
  protected static function randomString() {
    $chars = "abcdefghijklmnopqrstuvwxyz";
    $str = "";
    for ( $i = 0; $i < 10; $i++ ) {
      $str .= $chars[rand( 0, strlen( $chars )-1 )];
    }
    return $str;
  }
}
