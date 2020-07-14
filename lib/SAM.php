<?php

// Tested on PHP 5.2, 5.3

// This snippet (and some of the curl code) due to the Facebook SDK.
if ( !function_exists( "curl_init" ) ) {
	throw new Exception( "SAM needs the CURL PHP extension." );
}
if ( !function_exists( "json_decode" ) ) {
	throw new Exception( "SAM needs the JSON PHP extension." );
}
if ( !function_exists( "mb_detect_encoding" ) ) {
	throw new Exception( "SAM needs the Multibyte String PHP extension." );
}

// SAM singleton
require dirname( __FILE__ ) . "/SAM/SAM.php";

// Utilities
require dirname( __FILE__ ) . "/SAM/Util.php";
require dirname( __FILE__ ) . "/SAM/Util/Set.php";

// Errors
require dirname( __FILE__ ) . "/SAM/Error.php";
require dirname( __FILE__ ) . "/SAM/ApiError.php";
require dirname( __FILE__ ) . "/SAM/ApiConnectionError.php";
require dirname( __FILE__ ) . "/SAM/AuthenticationError.php";
require dirname( __FILE__ ) . "/SAM/InvalidRequestError.php";

// Plumbing
require dirname( __FILE__ ) . "/SAM/Object.php";
require dirname( __FILE__ ) . "/SAM/ApiRequestor.php";
require dirname( __FILE__ ) . "/SAM/ApiResource.php";
require dirname( __FILE__ ) . "/SAM/SingletonApiResource.php";
require dirname( __FILE__ ) . "/SAM/AttachedObject.php";
require dirname( __FILE__ ) . "/SAM/List.php";

// SAM API Resources
require dirname( __FILE__ ) . "/SAM/Account.php";
require dirname( __FILE__ ) . "/SAM/Asset.php";
require dirname( __FILE__ ) . "/SAM/Story.php";
require dirname( __FILE__ ) . "/SAM/User.php";
require dirname( __FILE__ ) . "/SAM/Upload.php";
