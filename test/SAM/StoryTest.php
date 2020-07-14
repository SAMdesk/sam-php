<?php

class SAM_StoryTest extends SAMTestCase
{
  public function testAll() {
    authorizeFromEnv();
    $d = SAM_Story::all();
    $this->assertTrue( count( $d ) > 0 );
  }

  public function testRetrieve() {
    authorizeFromEnv();
    $d = SAM_Story::retrieve( '52e9897fdd5b84450600000a' );
    $this->assertEqual( $d->id, "52e9897fdd5b84450600000a" );
    $this->assertEqual( $d->name, "Test" );
  }
}
