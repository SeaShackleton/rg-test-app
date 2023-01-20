<?php


namespace Tests\Api;

use Tests\Support\ApiTester;

class UpdateValFailGreenCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
		
		// test failure to enter all of the needed variables to edit a green
		$response = $I->sendPost('/green/5/update', [
			'name' => 'Jolly Green',
			'state' => 'NY'
		]);
		$I->seeResponseCodeIs(422);
	}
}
