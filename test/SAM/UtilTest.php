<?php

class SAM_UtilTest extends SAMTestCase
{
  public function testIsList() {
    $list = array( 5, 'nstaoush', array() );
    $this->assertTrue( SAM_Util::isList( $list ) );

    $notlist = array( 5, 'nstaoush', array(), 'bar' => 'baz' );
    $this->assertFalse( SAM_Util::isList( $notlist ) );
  }

  public function testThatPHPHasValueSemanticsForArrays() {
    $original = array( 'php-arrays' => 'value-semantics' );
    $derived = $original;
    $derived['php-arrays'] = 'reference-semantics';

    $this->assertEqual( 'value-semantics', $original['php-arrays'] );
  }
}
