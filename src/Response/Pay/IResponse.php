<?php

namespace h4kuna\Fio\Response\Pay;

/**
 * @author Milan Matějček
 */
interface IResponse
{

	/** @return bool */
	function isOk();

	/** @return mixed */
	function getError();

	/** @return int */
	function getErrorCode();
}
