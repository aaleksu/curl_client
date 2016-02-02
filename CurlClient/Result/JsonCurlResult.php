<?php

namespace CurlClient\Result;

class JsonCurlResult extends AbstractCurlResult
{
	public function toArray()
	{
		return json_decode($this->get(), true);
	}

	public function validate()
	{
	}
}

