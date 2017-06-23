<?php

namespace h4kuna\Fio\Request\Read;

use h4kuna\Fio\Response\Read;

class ReaderFactory
{

	/** @var Read\ITransactionListFactory */
	private $transactionListFactory;

	/** @var IReader[] */
	private $readerProvider = [];

	public function __construct(Read\ITransactionListFactory $transactionListFactory)
	{
		$this->transactionListFactory = $transactionListFactory;
	}

	public function getJsonMovement()
	{
		if (!isset($this->readerProvider['json.movement'])) {
			$this->readerProvider['json.movement'] = new Files\Json($this->transactionListFactory);
		}
		return $this->readerProvider['json.movement'];
	}

	public function getXmlCardMovement()
	{
		if (!isset($this->readerProvider['xml.card'])) {
			$this->readerProvider['xml.card'] = new Files\XmlCard($this->transactionListFactory);
		}
		return $this->readerProvider['xml.card'];
	}

}
