<?php

namespace h4kuna\Fio;

use Tester;
use Tester\Assert;
use Salamium\Testinium;

$container = require __DIR__ . '/../../../bootstrap.php';

/**
 * @author Milan Matějček
 */
class XMLResponseTest extends Tester\TestCase
{

	public function testResponse()
	{
		$xml = Testinium\File::load('payment/response.xml');
		$xmlResponse = new Response\Pay\XMLResponse($xml);
		Assert::true($xmlResponse->isOk());
		Assert::equal('1247458', $xmlResponse->getIdInstruction());
	}

}

(new XMLResponseTest())->run();
