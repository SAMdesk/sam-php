<?php

class SAM_AuthenticationErrorTest extends UnitTestCase
{
  public function testInvalidCredentials() {
    SAM::setApiKey( 'invalid' );
    SAM::setApiSecret( 'invalid' );
    try {
      SAM_Account::retrieve();
    } catch ( SAM_AuthenticationError $e ) {
      $this->assertEqual( 401, $e->getHttpStatus() );
    }
  }
}
