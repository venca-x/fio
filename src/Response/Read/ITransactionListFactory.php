<?php

namespace h4kuna\Fio\Response\Read;

/**
 * @author Milan Matějček
 */
interface ITransactionListFactory
{

	/** @return TransactionAbstract */
	function createTransaction($data, $dateFormat);

	/** @return \stdClass */
	function createInfo($data, $dateFormat);

	/** @return TransactionList */
	function createTransactionList($info);
}
