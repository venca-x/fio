<?php declare(strict_types=1);

namespace h4kuna\Fio\Response\Pay;

/**
 * @author Milan Matějček
 */
interface IResponse
{

	function isOk(): bool;

	/** @return mixed */
	function getError();

	function getErrorCode(): int;
}
