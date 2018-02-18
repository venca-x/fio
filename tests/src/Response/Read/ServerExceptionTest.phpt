<?php

namespace h4kuna\Fio;

use Tester;
use Tester\Assert;
use Salamium\Testinium;

$container = require __DIR__ . '/../../../bootstrap.php';

/**
 * @author Martin Pecha
 */
class ServerExceptionTest extends Tester\TestCase
{

	public function testResponse()
	{
		$xml = Testinium\File::load('server-exception.xml');
		$xmlResponse = new Response\Pay\XMLResponse($xml);
		Assert::false($xmlResponse->isOk());
	}

}

(new ServerExceptionTest())->run();
