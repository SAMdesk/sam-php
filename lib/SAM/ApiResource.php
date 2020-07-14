<?php

abstract class SAM_ApiResource extends SAM_Object
{
  protected static function _scopedRetrieve( $class, $id, $auth=null ) {
    $instance = new $class( $id, $auth );
    $instance->refresh();
    return $instance;
  }

  public function refresh() {
    $auth = self::_validateCall( "all", null, $this->_auth );
    $requestor = new SAM_ApiRequestor( $auth );
    $url = $this->instanceUrl();

    list( $response, $auth ) = $requestor->request( "get", $url, $this->_retrieveOptions );
    $this->refreshFrom( $response, $auth );
    return $this;
  }

  public static function className( $class ) {
    // Useful for namespaces: Foo\SAM_Account
    if ( $postfix = strrchr( $class, "\\" ) )
      $class = substr( $postfix, 1 );
    if ( substr( $class, 0, strlen( "SAM" ) ) == "SAM" )
      $class = substr( $class, strlen( "SAM" ) );
    $class = str_replace( "_", "", $class );
    $name = urlencode( $class );
    $name = strtolower( $name );
    return $name;
  }

  public static function classUrl( $class ) {
    $base = self::_scopedLsb( $class, "className", $class );
    if ( SAM_Util::endsWith( $base, "y" ) ) {
      $base = substr_replace( $base, "ie", -1 );
    }
    return "/1/${base}s";
  }

  public function instanceUrl() {
    $id = $this["id"];
    $class = get_class( $this );
    if ( !$id ) {
      throw new SAM_InvalidRequestError( "Could not determine which URL to request: $class instance has invalid ID: $id", null );
    }
    $id = SAM_ApiRequestor::utf8( $id );
    $base = $this->_lsb( "classUrl", $class );
    $extn = urlencode( $id );
    return "$base/$extn";
  }

  private static function _validateCall( $method, $params=null, $auth=null ) {
    if ( $params && !is_array( $params ) )
      throw new SAM_Error( "You must pass an array for the \"params\" argument to SAM API method calls." );
    if ( $auth ) {
      if ( !is_array( $auth ) )
        throw new SAM_Error( "The \"auth\" argument to SAM API method calls is optional per-request API authentication, which must be an array.  (HINT: you set your global API authentication using \"SAM::setAuth( array( \"<auth_type>\" => <API key> ) )\"." );
      else if ( !array_key_exists( "api_key", $auth ) && !array_key_exists( "access_token", $auth ) )
        throw new SAM_Error( "The \"auth\" argument to SAM API method calls is optional per-request API authentication, which must be an array containing the key \"api_key\" or \"access_token\".  (HINT: you set your global API authentication using \"SAM::setAuth( array( \"<auth_type>\" => <API key> ) )\"." );
      return isset($auth["api_key"]) ? array( "api_key" => $auth["api_key"] ) : array("access_token" => $auth["access_token"]);
    }
  }

  protected static function _scopedAll( $class, $params=null, $auth=null ) {
    $auth = self::_validateCall( "all", $params, $auth );
    $requestor = new SAM_ApiRequestor( $auth );
    $url = self::_scopedLsb( $class, "classUrl", $class );
    if($class == "SAM_Account") $url .= "/users"; // hack for getting users, since it doesn't follow URL scheme
    list( $response, $auth ) = $requestor->request( "get", $url, $params );
    return SAM_Util::convertToSAMObject( $response, $auth );
  }

  protected static function _scopedCreate( $class, $params=null, $body=null, $auth=null ) {
    $auth = self::_validateCall( "create", $params, $auth );
    $requestor = new SAM_ApiRequestor( $auth );
    $url = self::_scopedLsb( $class, "classUrl", $class );
    list( $response, $auth ) = $requestor->request( "post", $url, $params, $body );
    return SAM_Util::convertToSAMObject( $response, $auth );
  }

  protected function _scopedSave( $class ) {
    self::_validateCall( "save" );
    $requestor = new SAM_ApiRequestor( $this->_auth );
    $params = $this->serializeParameters();

    if ( count( $params ) > 0 ) {
      $url = $this->instanceUrl();
      list( $response, $auth ) = $requestor->request( "post", $url, $params );
      $this->refreshFrom( $response, $auth );
    }
    return $this;
  }

  protected function _scopedDelete( $class, $id, $auth=null ) {
    self::_validateCall( "delete", null, $auth );
    $requestor = new SAM_ApiRequestor( $auth );
    $url = self::_scopedLsb( $class, "classUrl", $class ) . "/$id";
    list( $response, $auth ) = $requestor->request( "delete", $url, null );
  }
}
