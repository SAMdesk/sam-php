<?php

abstract class SAM_Util {
  
  const CHUNK_SIZE = 5242880; // 5MB
  
  public static function isList( $array ) {
    if ( !is_array( $array ) )
      return false;

    // TODO: this isn"t actually correct in general, but it"s correct given SAM"s responses
    foreach ( array_keys( $array ) as $k ) {
      if ( !is_numeric( $k ) )
        return false;
    }
    return true;
  }

  public static function convertSAMObjectToArray( $values ) {
    $results = array();
    foreach ( $values as $k => $v ) {
      // FIXME: this is an encapsulation violation
      if ( $k[0] == "_" ) {
        continue;
      }
      if ( $v instanceof SAM_Object ) {
        $results[$k] = $v->__toArray( true );
      }
      else if ( is_array( $v ) ) {
          $results[$k] = self::convertSAMObjectToArray( $v );
        }
      else {
        $results[$k] = $v;
      }
    }
    return $results;
  }

  public static function convertToSAMObject( $resp, $auth ) {
    $types = array(
      "asset" => "SAM_Asset",
      "story" => "SAM_Story"
    );
    if ( self::isList( $resp ) ) {
      $mapped = array();
      foreach ( $resp as $i )
        array_push( $mapped, self::convertToSAMObject( $i, $auth ) );
      return $mapped;
    } else if ( is_array( $resp ) ) {
        if ( isset( $resp["object"] ) && is_string( $resp["object"] ) && isset( $types[$resp["object"]] ) )
          $class = $types[$resp["object"]];
        else
          $class = "SAM_Object";
        return SAM_Object::scopedConstructFrom( $class, $resp, $auth );
      } else {
      return $resp;
    }
  }

  public static function endsWith( $haystack, $needle ) {
    return $needle === "" || substr( $haystack, -strlen( $needle ) ) === $needle;
  }
}
