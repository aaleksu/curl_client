<?php

namespace CurlClient;

abstract class AbstractCurlClient
{
	private $ch;
	private $url;
	private $postData = [];
	private $headers = []; 
	private $error;
	private $beforeCallback;
	protected $result;

	abstract public function initResult();

	public function __construct()
	{
		$this->initResult();
	}

	public function ch()
	{
		if($this->ch == null) {
			$this->ch = curl_init();
		}

		return $this->ch;
	}

	public function exec()
	{
		if($this->beforeCallback != null) {
			call_user_func($this->beforeCallback);
		}

		$this->validate();

		if(!empty($this->postData)) {
			$this->asPost();
		}

		curl_setopt_array($this->ch(), [
			CURLOPT_URL, $this->getUrl(),
			CURLOPT_RETURNTRANSFER => true,
		]);

		$result = curl_exec($this->ch());
		$this->result->set($result);
		$this->error = curl_error($this->ch());

		curl_close($this->ch());
		$this->clear();

		return $this;
	}

	public function result()
	{
		return $this->result;
	}

	public function setUrl($url)
	{
		$this->url = $url;
		curl_setopt($this->ch(), CURLOPT_URL, $url);

		return $this;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function setPostData($postData = [])
	{
		$this->postData = $postData;

		return $this;
	}

	public function getPostData()
	{
		return $this->postData;
	}

	public function asPost($postData = [])
	{
		if(!empty($postData)) {
			$this->setPostData($postData);
		}

		$this->setOption(CURLOPT_POST, true);

		$postFields = http_build_query($this->getPostData());
		$this->setOption(CURLOPT_POSTFIELDS, $postFields);

		return $this;
	}

	public function setOption($option, $value)
	{
		curl_setopt($this->ch(), $option, $value);

		return $this;
	}

	public function addHeader($header)
	{
		if(!is_string($header)) {
			throw new \Exception('Wrong header format: should be a string');
		}

		$this->headers[] = $header;
	}

	public function setHeaders()
	{
		curl_setopt($this->ch(), CURLOPT_HTTPHEADER, $this->headers);
	}

	public function clear()
	{
		$this->ch = null;
		$this->postData = [];
		$this->headers = [];
	}

	protected setBeforeCallback($callback)
	{
		$this->beforeCallback = $callback;
	}

	private function validateBeforeCallback()
	{
		if(!is_callable($this->beforeCallback)) {
			throw new \Exception('Wrong callback; beforeCallback must be callable');
		}
	}

	private function validate()
	{
		if(empty($this->url)) {
			throw new \Exception('Empty curl url. Can\'t send request nowhere');
		}

		if($this->ch == null) {
			throw new \Exception('Curl handler should not be null');
		}
	}
}

