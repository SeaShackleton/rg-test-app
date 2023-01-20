<?php


namespace Tests\Api;

use Tests\Support\ApiTester;

class InsertGreenCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
		$I->haveHttpHeader('Content-Type', 'application/json');
		$response = $I->sendPost('/green', [
			'name' => 'Jolly Green',
			'state' => 'NY',
			'zip' => '10017',
			'amount' => '66.37',
			'qty' => '1',
			'item' => 'JGG001'
		]);
		$I->seeResponseCodeIs(201);
		$I->seeResponseIsJson();
		$I->seeResponseContains('[{"id":"1","name":"Liquid Saffron","state":"NY","zip":"08998","amount":"25.43","qty":"7","item":"XCD45300"},{"id":"2","name":"Mostly Slugs","state":"PA","zip":"19008","amount":"13.30","qty":"2","item":"AAH6748"},{"id":"3","name":"Jump Stain","state":"CA","zip":"99388","amount":"56.00","qty":"3","item":"MKII4400"},{"id":"4","name":"Scheckled Sherlock","state":"WA","zip":"88990","amount":"987.56","qty":"1","item":"TR909"},{"id":"5","name":"Jolly Green","state":"NY","zip":"10017","amount":"66.37","qty":"1","item":"JGG001"}]');		
    }
}
