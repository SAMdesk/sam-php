<?php

class SAM_Upload extends SAM_ApiResource
{
  public static function constructFrom( $values, $auth=null ) {
    $class = get_class();
    return self::scopedConstructFrom( $class, $values, $auth );
  }
  
  /*
   * NOTE: This function expects an absolute filepath as the second parameter.
   *
   */
  public static function upload( $params, $file, $auth=null ) {
    if( !file_exists( $file ) )
      throw new SAM_Error( "No such file exists: \"$file\". Please check the path and filename." );
    if( !is_readable( $file ) )
      throw new SAM_Error( "Could not read file \"$file\". Please check your system permissions." );
    
    // Determine how many parts we need and start the upload.
    $params["size"] = filesize( $file );
    $params["parts"] = ceil( $params["size"] / SAM_Util::CHUNK_SIZE );
    $upload_init = self::start( $params, $auth );
    
    $media_id = $upload_init["media_id"];
    $part_index = 1;
    $fh = fopen( $file, "rb" ); // Opens file in read-mode and binary safe for Windows servers
    while( !feof( $fh ) ) {
      $part = fread( $fh, SAM_Util::CHUNK_SIZE );
      
      $append_params = array( "body" => $part, "part" => $part_index );
      $append_res = self::append( $media_id, $append_params, $auth );
      
      $part_index++;
    }
    
    fclose( $fh );
    
    self::complete( $media_id, $auth );
    
    return array( "media_id" => $media_id );
  }
  
  public static function start( $params, $auth=null ) {
    $requestor = new SAM_UploadRequestor( $auth );
    $base = "/1/upload";
    list( $response, $auth ) = $requestor->request( "post", $base, null, $params );
    return SAM_Util::convertToSAMObject( $response, $auth );
  }
  
  public static function append( $media_id, $params, $auth=null ) {
    $requestor = new SAM_UploadRequestor( $auth );
    $base = "/1/upload/$media_id/append";
    $headers = array( "Content-Type: application/octet-stream" );
    $query = array( "part" => $params["part"] );
    list( $response, $auth ) = $requestor->uploadChunk( $base, $query, $params["body"], $headers );
  }
  
  public static function complete( $media_id, $auth=null ) {
    $requestor = new SAM_UploadRequestor( $auth );
    $base = "/1/upload/$media_id/complete";
    list( $response, $auth ) = $requestor->request( "post", $base, null, null );
  }
}