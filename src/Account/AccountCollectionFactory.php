<?php

namespace h4kuna\Fio\Account;

use h4kuna\Fio\InvalidArgumentException;

/**
 * @author Milan Matějček
 */
class AccountCollectionFactory
{

	/**
	 * @param array $accounts
	 * @return AccountCollection
	 */
	public static function create(array $accounts)
	{
		$accountCollection = new AccountCollection;
		foreach ($accounts as $alias => $info) {
			if (!isset($info['token'])) {
				throw new InvalidArgumentException("Key 'token' is required for $alias.");
			} elseif (!isset($info['account'])) {
				throw new InvalidArgumentException("Key 'account' is required for $alias.");
			}
			$accountCollection->addAccount($alias, new FioAccount($info['account'], $info['token']));
		}
		return $accountCollection;
	}

}
