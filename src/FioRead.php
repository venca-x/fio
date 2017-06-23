<?php

namespace h4kuna\Fio;

use GuzzleHttp\Exception,
	h4kuna\Fio\Response\Read\TransactionList,
	h4kuna\Fio\Utils;

/**
 * Read from informtion Fio account
 */
class FioRead extends Fio
{

	/** @var string */
	private $requestUrl;

	/** @var Request\Read\ReaderFactory */
	private $readerFactory;

	public function __construct(Request\IQueue $queue, Account\FioAccount $account, Request\Read\ReaderFactory $readerFactory)
	{
		parent::__construct($queue, $account);
		$this->readerFactory = $readerFactory;
	}

	/**
	 * Movements in date range.
	 * @param string|int|\DateTime $from
	 * @param string|int|\DateTime $to
	 * @return TransactionList
	 */
	public function movements($from = '-1 week', $to = 'now')
	{
		$reader = $this->readerFactory->getJsonMovement();
		$data = $this->download('periods/%s/%s/%s/transactions.%s', Utils\Strings::date($from), Utils\Strings::date($to), $reader->getExtension());
		return $reader->create($data);
	}

	/**
	 * List of movemnts.
	 * @param int $id
	 * @param int|string|NULL $year format YYYY, NULL is current
	 * @return IFile
	 */
	public function movementId($id, $year = NULL)
	{
		if ($year === NULL) {
			$year = date('Y');
		}
		$reader = $this->readerFactory->getJsonMovement();
		$data = $this->download('by-id/%s/%s/%s/transactions.%s', $year, $id, $reader->getExtension());
		return $reader->create($data);
	}

	/**
	 * Movements in date of card or terminal.
	 * @param string|int|\DateTime $from
	 * @param string|int|\DateTime $to
	 * @return TransactionList
	 */
	public function movementCard($from = '-1 week', $to = 'now')
	{
		$reader = $this->readerFactory->getXmlCardMovement();
		try {
			$data = $this->download('merchant/%s/%s/%s/transactions.%s', Utils\Strings::date($from), Utils\Strings::date($to), $reader->getExtension());
		} catch (Exception\ClientException $e) {
			if ($e->getCode() !== \Nette\Http\IResponse::S404_NOT_FOUND) {
				throw $e;
			}
			throw new FioCurrentAccountException('This function require Fio Business Account.');
		}
		return $reader->create($data);
	}

	/**
	 * Last movements from last breakpoint.
	 * @return IFile
	 */
	public function lastDownload()
	{
		$reader = $this->readerFactory->getJsonMovement();
		$data = $this->download('last/%s/transactions.%s', $reader->getExtension());
		return $reader->create($data);
	}

	/**
	 * Set break point to id.
	 * @param int $moveId
	 * @return void
	 */
	public function setLastId($moveId)
	{
		$this->download('set-last-id/%s/%s/', $moveId);
	}

	/**
	 * Set breakpoint to date.
	 * @param mixed $date
	 * @return void
	 */
	public function setLastDate($date)
	{
		$this->download('set-last-date/%s/%s/', Utils\Strings::date($date));
	}

	/**
	 * Last request url for read. This is for tests.
	 * @return string
	 */
	public function getRequestUrl()
	{
		return $this->requestUrl;
	}

	private function download($apiUrl /* ... params */)
	{
		$args = func_get_args();
		$args[0] = $token = $this->account->getToken();
		$this->requestUrl = self::REST_URL . vsprintf($apiUrl, $args);
		return $this->queue->download($token, $this->requestUrl);
	}

}
