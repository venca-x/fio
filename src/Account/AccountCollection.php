<?php declare(strict_types=1);

namespace h4kuna\Fio\Account;

use h4kuna\Fio\InvalidArgumentException;

/**
 * @author Tomáš Jacík
 * @author Milan Matějček
 */
class AccountCollection implements \Countable, \IteratorAggregate
{

	/** @var FioAccount[] */
	private $accounts = [];

	/**
	 * @param string
	 * @return FioAccount
	 */
	public function get($alias): FioAccount
	{
		if (isset($this->accounts[$alias])) {
			return $this->accounts[$alias];
		}
		throw new InvalidArgumentException('This account alias does not exists: ' . $alias);
	}

	public function getDefault(): ?FioAccount
	{
		$account = reset($this->accounts);
		if ($account === false) {
			return null;
		}
		return $account;
	}

	public function addAccount(string $alias, FioAccount $account): AccountCollection
	{
		if (isset($this->accounts[$alias])) {
			throw new InvalidArgumentException('This alias already exists: ' . $alias);
		}

		$this->accounts[$alias] = $account;
		return $this;
	}

	public function count(): int
	{
		return count($this->accounts);
	}

	public function getIterator(): \ArrayIterator
	{
		return new \ArrayIterator($this->accounts);
	}

}
