<?php

namespace h4kuna\Fio\Request\Read;

use h4kuna\Fio\Response;

/**
 * @author Milan Matějček
 */
interface IReader
{

	/** supported */
	const JSON = 'json';

	/** not supported */
	const XML = 'xml';
	const OFX = 'ofx';
	const HTML = 'html';
	const STA = 'sta';
	const GPC = 'gpc';
	const CSV = 'csv';

	function __construct(Response\Read\ITransactionListFactory $statement);

	/**
	 * File extension.
	 * @return string
	 */
	function getExtension();

	/**
	 * Prepare downloaded data before append.
	 * @param string $data
	 * @return Response\Read\TransactionList
	 */
	function create($data);
}
