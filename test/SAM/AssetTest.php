<?php

class SAM_AssetTest extends SAMTestCase
{
  public function testAll() {
    authorizeFromEnv();
    $d = SAM_Asset::all( '52e9897fdd5b84450600000a' );
    $this->assertTrue( count( $d ) > 0 );
  }

  public function testRetrieve() {
    authorizeFromEnv();
    $d = SAM_Asset::retrieve( '52e9897fdd5b84450600000a', '52f7c21ce30ae9da1c000044' );
    $this->assertEqual( $d->id, "52f7c21ce30ae9da1c000044" );
  }
}
