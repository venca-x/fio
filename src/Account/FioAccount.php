<?php declare(strict_types=1);

namespace h4kuna\Fio\Account;

/**
 * @author Milan Matějček
 */
class FioAccount
{

	/** @var Bank */
	private $account;

	/** @var string */
	private $token;

	public function __construct(string $account, string $token)
	{
		$this->account = new Bank($account);
		$this->token = $token;
	}

	public function getAccount(): string
	{
		return $this->account->getAccount();
	}

	public function getBankCode(): string
	{
		return $this->account->getBankCode();
	}

	public function getToken(): string
	{
		return $this->token;
	}

}
