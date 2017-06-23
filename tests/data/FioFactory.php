<?php

namespace h4kuna\Fio\Test;

/**
 * @author Milan Matějček
 */
class FioFactory extends \h4kuna\Fio\Utils\FioFactory
{

	public function __construct($transactionClass = NULL)
	{
		$accounts = [
			'foo' => [
				'account' => '123456789',
				'token' => 'abcdefgh'
			],
			'bar' => [
				'account' => '987654321',
				'token' => 'hgfedcba'
			]
		];
		parent::__construct($accounts, $transactionClass);
	}

	protected function createQueue()
	{
		return new Queue;
	}

	public function getXmlFile()
	{
		return $this->createXmlFile();
	}

	public function getReaderFactory()
	{
		return $this->createReaderFactory();
	}

}
