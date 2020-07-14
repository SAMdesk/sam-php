<?php

class SAM_AccountTest extends SAMTestCase
{
	public function testRetrieve() {
		authorizeFromEnv();
		$d = SAM_Account::retrieve();
		$this->assertEqual( $d->id, "52e81458170f1dad04000005" );
		$this->assertEqual( $d->name, "Trevon" );
	}
}
