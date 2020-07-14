<?php

class SAM_Story extends SAM_ApiResource
{
  public static function constructFrom( $values, $auth=null ) {
    $class = get_class();
    return self::scopedConstructFrom( $class, $values, $auth );
  }

  public static function retrieve( $id, $auth=null ) {
    $class = get_class();
    return self::_scopedRetrieve( $class, $id, $auth );
  }
  
  public static function create( $createStoryParams, $auth=null) {
    $class = get_class();
    return self::_scopedCreate( $class, null, $createStoryParams, $auth );
  }
  
  public static function delete( $id, $auth=null ) {
    $class = get_class();
    return self::_scopedDelete( $class, $id, $auth );
  }

  public static function all( $params=null, $auth=null ) {
    $class = get_class();
    return self::_scopedAll( $class, $params, $auth );
  }
}
