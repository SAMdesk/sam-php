<?php

class SAM_User extends SAM_SingletonApiResource
{
  public static function constructFrom( $values, $auth=null ) {
    $class = get_class();
    return self::scopedConstructFrom( $class, $values, $auth );
  }

  public static function retrieve( $auth=null ) {
    $class = get_class();
    return self::_scopedSingletonRetrieve( $class, null, $auth );
  }
}

?>