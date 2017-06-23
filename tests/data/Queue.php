<?php

namespace h4kuna\Fio\Test;

use h4kuna\Fio,
	Salamium\Testinium;

/**
 * @author Milan Matějček
 */
class Queue implements Fio\Request\IQueue
{

	public function download($token, $url)
	{
		$file = '';
		if (preg_match('~transactions\.\w+$~', $url, $find)) {
			preg_match('~((?:/[^/]+){3})$~U', $url, $find);
			$file = str_replace(['/', '-' . $token], ['-', ''], ltrim($find[1], '/'));
		}

		if ($file) {
			return Testinium\File::load($file);
		}
		return $file;
	}

	public function upload($url, $token, array $post, $filename)
	{
		return file_get_contents($filename);
	}

}
