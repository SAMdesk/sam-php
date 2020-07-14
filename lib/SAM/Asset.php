<?php

class SAM_Asset extends SAM_ApiResource
{
  public static function constructFrom( $values, $auth=null ) {
    $class = get_class();
    return self::scopedConstructFrom( $class, $values, $auth );
  }

  public static function retrieve( $storyId, $id, $auth=null ) {
    $requestor = new SAM_ApiRequestor( $auth );
    $base = SAM_Asset::getClassUrl( $storyId );
    $id = SAM_ApiRequestor::utf8( $id );
    $extn = urlencode( $id );
    list( $response, $auth ) = $requestor->request( "get", "$base/$extn" );
    return SAM_Util::convertToSAMObject( $response, $auth );
  }

  public static function all( $storyId, $params=null, $auth=null ) {
    $requestor = new SAM_ApiRequestor( $auth );
    $base = SAM_Asset::getClassUrl( $storyId );
    list( $response, $auth ) = $requestor->request( "get", $base, $params );
    return SAM_Util::convertToSAMObject( $response, $auth );
  }
  
  public static function create( $storyId, $params, $auth=null ) {
    $requestor = new SAM_ApiRequestor( $auth );
    $base = SAM_Asset::getClassUrl( $storyId );
    list( $response, $auth ) = $requestor->request( "post", $base, null, $params );
    return SAM_Util::convertToSAMObject( $response, $auth );
  }

  // TODO: handle nested objects better
  private static function getClassUrl( $storyId ) {
    $base = self::classUrl( "SAM_Story" );
    $storyId = SAM_ApiRequestor::utf8( $storyId );
    $storyExtn = urlencode( $storyId );
    return "$base/$storyExtn/assets";
  }
}
