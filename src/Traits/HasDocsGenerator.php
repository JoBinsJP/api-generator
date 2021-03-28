<?php

namespace Jobins\APIGenerator\Traits;

/**
 * Class HasDocsGenerator
 * @package Jobins\APIGenerator
 */
trait HasDocsGenerator
{
    /**
     * @var string
     */
    protected $d_method;

    /**
     * @var string
     */
    protected $d_url;

    /**
     * @var array
     */
    protected $d_data;

    /**
     * @var
     */
    protected $d_header;

    /**
     * @var string
     */
    protected $d_summary;

    /**
     * @var string
     */
    protected $d_operationId;

    /**
     * @var string
     */
    protected $d_request;

    /**
     * @var boolean
     */
    protected $d_ignore_request_data;

    public function setSummary($summary)
    {
        $this->d_summary = $summary;

        return $this;
    }

    public function setId($operationId)
    {
        $this->d_operationId = $operationId;

        return $this;
    }

    public function setRulesFromFormRequest($request)
    {
        $this->d_request = $request;

        return $this;
    }

    public function ignoreRequestDataAsExample()
    {
        $this->d_ignore_request_data = true;

        return $this;
    }

    public function jsond($method, $uri, array $data = [], array $headers = [])
    {
        $this->d_method = $method;

        $this->d_url = $uri;

        $this->d_data = $data;

        $this->d_header = $headers;

        return $this->json($method, $uri, $data, $headers);
    }

    public function getParams()
    {
        return [
            "summary"     => $this->d_summary,
            "operationID" => $this->d_operationId,
            "rule"        => $this->d_request,
            "data"        => $this->d_data,
            "header"      => $this->d_header,
            "url"         => $this->d_url,
            "method"      => $this->d_method,
            "ignoreData"  => $this->d_ignore_request_data,
        ];
    }
}
