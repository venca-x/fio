<?php

namespace h4kuna\Fio\Request\Read\Files;

use h4kuna\Fio\Response\Read;

class XmlCard implements \h4kuna\Fio\Request\Read\IReader
{

	/** @var Read\ITransactionListFactory */
	private $transactionListFactory;

	public function __construct(Read\ITransactionListFactory $transactionListFactory)
	{
		$this->transactionListFactory = $transactionListFactory;
	}

	public function create($data)
	{
		// @todo
		throw new \Nette\NotImplementedException;
	}

	public function getExtension()
	{
		return \h4kuna\Fio\Request\Read\IReader::XML;
	}

}
