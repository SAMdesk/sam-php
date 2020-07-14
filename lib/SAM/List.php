<?php

class SAM_List extends SAM_Object
{
  public static function constructFrom( $values, $auth=null ) {
    $class = get_class();
    return self::scopedConstructFrom( $class, $values, $auth );
  }

  public function all( $params=null ) {
    $requestor = new SAM_ApiRequestor( $this->_auth );
    list( $response, $auth ) = $requestor->request( 'get', $this['url'], $params );
    return SAM_Util::convertToSAMObject( $response, $auth );
  }

  public function create( $params=null ) {
    $requestor = new SAM_ApiRequestor( $this->_auth );
    list( $response, $auth ) = $requestor->request( 'post', $this['url'], $params );
    return SAM_Util::convertToSAMObject( $response, $auth );
  }

  public function retrieve( $id, $params=null ) {
    $requestor = new SAM_ApiRequestor( $this->_auth );
    $base = $this['url'];
    $id = SAM_ApiRequestor::utf8( $id );
    $extn = urlencode( $id );
    list( $response, $auth ) = $requestor->request( 'get', "$base/$extn", $params );
    return SAM_Util::convertToSAMObject( $response, $auth );
  }

}
