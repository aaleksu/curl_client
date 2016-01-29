<?php

namespace CurlClient\Result;

class SampleCurlResult extends AbstractCurlResult
{
	public function toArray()
	{
		return json_decode($this->get(), true);
	}

	public function validate()
	{
	}
}
