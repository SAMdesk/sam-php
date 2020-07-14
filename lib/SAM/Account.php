<?php

class SAM_Account extends SAM_SingletonApiResource
{
  public static function constructFrom( $values, $auth=null ) {
    $class = get_class();
    return self::scopedConstructFrom( $class, $values, $auth );
  }

  public static function retrieve( $auth=null ) {
    $class = get_class();
    return self::_scopedSingletonRetrieve( $class, $auth );
  }
  
  public static function users( $auth=null ) {
    $class = get_class();
    return self::_scopedAll( $class, null, $auth );
  }
}
