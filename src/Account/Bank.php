<?php declare(strict_types=1);

namespace h4kuna\Fio\Account;

use h4kuna\Fio\InvalidArgumentException;

/**
 * @author Milan Matějček
 */
class Bank
{

	/** @var string */
	private $account;

	/** @var string */
	private $bankCode = '';

	/** @var string */
	private $prefix = '';

	/**
	 * @param string $account [prefix-]account[/code] no whitespace
	 */
	public function __construct(string $account)
	{
		if (!preg_match('~^(?P<prefix>\d+-)?(?P<account>\d+)(?P<code>/\d+)?$~', $account, $find)) {
			throw new InvalidArgumentException('Account must have format [prefix-]account[/code].');
		}

		if (strlen($find['account']) > 16) {
			throw new InvalidArgumentException('Account max length is 16 chars.');
		}

		$this->account = $find['account'];

		if (!empty($find['code'])) {
			$this->bankCode = $find['code'];
			if (strlen($this->getBankCode()) !== 4) {
				throw new InvalidArgumentException('Code must have 4 chars length.');
			}
		}

		if (!empty($find['prefix'])) {
			$this->prefix = $find['prefix'];
		}
	}

	public function getAccount(): string
	{
		return $this->prefix . $this->account;
	}

	public function getBankCode(): string
	{
		if ($this->bankCode) {
			return substr($this->bankCode, 1);
		}
		return '';
	}

	public function getPrefix(): string
	{
		if ($this->prefix) {
			return substr($this->prefix, 0, -1);
		}
		return '';
	}

	public function getAccountAndCode(): string
	{
		return $this->getAccount() . $this->bankCode;
	}

	public function __toString()
	{
		return (string) $this->getAccount();
	}

}
