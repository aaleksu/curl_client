<?php

namespace CurlClient\Result;

abstract class AbstractCurlResult implements CurlResultInterface
{
	private $result;

	public function set($result)
	{
		$this->result = $result;
	}

	public function get()
	{
		return $this->result;
	}
}
