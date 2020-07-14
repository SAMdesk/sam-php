<?php

abstract class SAM {
  public static $auth;
  public static $apiBase = "https://api.samdesk.io";
  public static $uploadBase = "https://upload.samdesk.io";
  public static $apiVersion = 1;
  public static $verifySslCerts = false; // TODO: set this up
  const VERSION = "1.0.0";

  public static function getAuth() {
    return self::$auth;
  }

  public static function setAuth( $auth ) {
    if ( is_array( $auth ) ) {
      if ( array_key_exists( "access_token", $auth ) && !array_key_exists( "api_key", $auth ) ) {
        self::$auth = array( "access_token" => $auth["access_token"] );
      } else if ( array_key_exists( "api_key", $auth ) && !array_key_exists( "access_token", $auth ) ) {
        self::$auth = array( "api_key" => $auth["api_key"] );
      } else {
        throw new SAM_Error( "The argument to SAM::setAuth must be an array containing the key \"api_key\" or \"access_token\"." );
      }
    } else {
      throw new SAM_Error( "You must pass an array as the argument to SAM::setAuth." );
    }
  }

  public static function getApiVersion() {
    return self::$apiVersion;
  }

  public static function setApiVersion( $apiVersion ) {
    self::$apiVersion = $apiVersion;
  }

  public static function getVerifySslCerts() {
    return self::$verifySslCerts;
  }

  public static function setVerifySslCerts( $verify ) {
    self::$verifySslCerts = $verify;
  }
}
