<?php

namespace h4kuna\Fio;

use Tester,
	Tester\Assert,
	h4kuna\Fio\Test,
	Salamium\Testinium;

$container = require_once __DIR__ . '/../bootstrap.php';

class FioReadTest extends Tester\TestCase
{

	/** @var Test\FioFactory */
	private $fioFactory;

	/** @var FioRead */
	private $fioRead;

	/** @var string */
	private $token;

	public function __construct(Test\FioFactory $fioFactory)
	{
		$this->fioFactory = $fioFactory;
	}

	protected function setUp()
	{
		$this->fioRead = $this->fioFactory->createFioRead();
		$this->token = $this->fioRead->getAccount()->getToken();
	}

	public function testMovements()
	{
		$data = $this->fioRead->movements(1420070400, '2015-04-16');
		$moveId = 7139752765;
		foreach ($data as $transaction) {
			/* @var $transaction Response\Read\Transaction */
			Assert::equal($moveId, $transaction->moveId);
			foreach ($transaction as $property => $value) {
				if ($property === 'moveId') {
					Assert::equal($moveId, $value);
					break 2;
				}
			}
		}

		Assert::equal(Fio::REST_URL . 'periods/' . $this->token . '/2015-01-01/2015-04-16/transactions.json', $this->fioRead->getRequestUrl());

		if (Request\Read\Files\Json::isJsonBug()) {
			Assert::equal(unserialize(Testinium\File::load('php7.1/2015-01-01-2015-04-16-transactions.srlz')), $data);
		} else {
			Assert::equal(unserialize(Testinium\File::load('2015-01-01-2015-04-16-transactions.srlz')), $data);
		}
	}

	public function testMovementsEmpty()
	{
		$data = $this->fioRead->movements('2011-01-01', '2011-01-02');
		if (Request\Read\Files\Json::isJsonBug()) {
			Assert::equal(unserialize(Testinium\File::load('php7.1/2011-01-01-2011-01-02-transactions.srlz')), $data);
		} else {
			Assert::equal(unserialize(Testinium\File::load('2011-01-01-2011-01-02-transactions.srlz')), $data);
		}
	}

	public function testMovementId()
	{
		$fioRead = $this->fioFactory->createFioRead('bar');
		$token = $fioRead->getAccount()->getToken();
		Assert::same('hgfedcba', $token);
		$data = $fioRead->movementId(2, 2015);

		if (Request\Read\Files\Json::isJsonBug()) {
			Assert::equal(unserialize(Testinium\File::load('php7.1/2015-2-transactions.srlz')), $data);
		} else {
			Assert::equal(unserialize(Testinium\File::load('2015-2-transactions.srlz')), $data);
		}

		Assert::equal(Fio::REST_URL . 'by-id/' . $token . '/2015/2/transactions.json', $fioRead->getRequestUrl());
	}

	public function testLastDownload()
	{
		$data = $this->fioRead->lastDownload();
		if (Request\Read\Files\Json::isJsonBug()) {
			Assert::equal(unserialize(Testinium\File::load('php7.1/last-transactions.srlz')), $data);
		} else {
			Assert::equal(unserialize(Testinium\File::load('last-transactions.srlz')), $data);
		}
		Assert::equal(Fio::REST_URL . 'last/' . $this->token . '/transactions.json', $this->fioRead->getRequestUrl());
	}

	public function testSetLastId()
	{
		$this->fioRead->setLastId(7155451447);
		Assert::equal(Fio::REST_URL . 'set-last-id/' . $this->token . "/7155451447/", $this->fioRead->getRequestUrl());
	}

	public function testSetLastDate()
	{
		$dt = new \DateTime('-1 week');
		$this->fioRead->setLastDate('-1 week');
		Assert::equal(Fio::REST_URL . 'set-last-date/' . $this->token . '/' . $dt->format('Y-m-d') . '/', $this->fioRead->getRequestUrl());
	}

}

$fioFactory = new Test\FioFactory();
(new FioReadTest($fioFactory))->run();
