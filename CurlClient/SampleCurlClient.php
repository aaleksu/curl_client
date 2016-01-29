<?php

namespace CurlClient;

use CurlClient\Result\SampleCurlResult;

class SampleCurlClient extends AbstractCurlClient
{
	public function initResult()
	{
		$this->result = new SampleCurlResult();
	}

	public function addAuth($token)
	{
		$sessionIdHeader = sprintf('Secret token: %s', $token);
		$this->addHeader($sessionIdHeader);
		$this->setHeaders();

		return $this;
	}
}
