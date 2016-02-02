<?php

namespace CurlClient;

use CurlClient\Result\JsonCurlResult;

class JsonCurlClient extends AbstractCurlClient
{
	public function initResult()
	{
		$this->result = new JsonCurlResult();
	}

	public function addAuth($token)
	{
		$sessionIdHeader = sprintf('Secret token: %s', $token);
		$this->addHeader($sessionIdHeader);
		$this->setHeaders();

		return $this;
	}
}

