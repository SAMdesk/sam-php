<?php

echo "Running the SAM PHP bindings test suite.\n".
  "If you're trying to use the SAM PHP bindings you'll probably want ".
  "to require('lib/SAM.php'); instead of this file\n";

function authorizeFromEnv() {
  $apiKey = getenv( 'SAM_API_KEY' );
  if ( !$apiKey )
    $apiKey = "key";
  SAM::setApiKey( $apiKey );

  $apiSecret = getenv( 'SAM_API_SECRET' );
  if ( !$apiSecret )
    $apiSecret = "secret";
  SAM::setApiSecret( $apiSecret );
}

$ok = @include_once dirname( __FILE__ ).'/simpletest/autorun.php';
if ( !$ok ) {
  $ok = @include_once dirname( __FILE__ ).'/../vendor/vierbergenlars/simpletest/autorun.php';
}
if ( !$ok ) {
  echo "MISSING DEPENDENCY: The SAM API test cases depend on SimpleTest. ".
    "Download it at <http://www.simpletest.org/>, and either install it ".
    "in your PHP include_path or put it in the test/ directory.\n";
  exit( 1 );
}

// Throw an exception on any error
function exception_error_handler( $errno, $errstr, $errfile, $errline ) {
  throw new ErrorException( $errstr, $errno, 0, $errfile, $errline );
}
set_error_handler( 'exception_error_handler' );
error_reporting( E_ALL | E_STRICT );

require_once dirname( __FILE__ ) . '/../lib/SAM.php';

require_once dirname( __FILE__ ) . '/SAM/TestCase.php';

require_once dirname( __FILE__ ) . '/SAM/AccountTest.php';
require_once dirname( __FILE__ ) . '/SAM/AssetTest.php';
require_once dirname( __FILE__ ) . '/SAM/ApiRequestorTest.php';
require_once dirname( __FILE__ ) . '/SAM/AuthenticationErrorTest.php';
require_once dirname( __FILE__ ) . '/SAM/Error.php';
require_once dirname( __FILE__ ) . '/SAM/ObjectTest.php';
require_once dirname( __FILE__ ) . '/SAM/StoryTest.php';
require_once dirname( __FILE__ ) . '/SAM/UtilTest.php';
