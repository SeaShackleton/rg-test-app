<?php


namespace Tests\Api;

use Tests\Support\ApiTester;

class GetGreenCest
{
    public function _before(ApiTester $I)
    {
		
		// to make sure data is correct for tests copy the origional csv file 
		if (!copy("data.copy.csv", "data.csv")) {
			echo "failed to copy";
		}
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
		$response = $I->sendGet('/green/3');
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
		$I->seeResponseContains('[{"id":"3","name":"Jump Stain","state":"CA","zip":"99388","amount":"56.00","qty":"3","item":"MKII4400"}]');
    }
}
