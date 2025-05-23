<?php

namespace App\Cores\Services;

use App\Cores\Units\Unit;
use Exception;
use Illuminate\Support\Facades\Http;

abstract class Service extends Unit
{
    /**
     * @throws Exception
     */
    protected function execute()
    {
        $url = $this->getUrl();
        switch ($this->data->getItem('method')) {
            case 'post':
                $http = Http::post($url, $this->getRequestBody());
                break;
            case 'put':
                $http = Http::put($url, $this->getRequestBody());
                break;
            case 'delete':
                $http = Http::delete($url, $this->getRequestBody());
                break;
            default:
                $http = Http::get($url, $this->getRequestBody());
                break;
        }
        $this->setHttpResponses($http->json());
    }

    /**
     * @throws Exception
     */
    protected function getUrl()
    {
        $host = 'https://' . config('app.env') . '-apigateway.qcyyds.com';
        $path = $this->data->getItemRequired('path');
        return trim($host, '/') . '/' . trim($path, '/');
    }

    protected function setPath($path = '')
    {
        $this->data->setItem('path', $path);
        return $this;
    }

    protected function isMethodPost()
    {
        $this->data->setItem('method', 'post');
        return $this;
    }

    protected function isMethodPut()
    {
        $this->data->setItem('method', 'put');
        return $this;
    }

    protected function isMethodDelete()
    {
        $this->data->setItem('method', 'delete');
        return $this;
    }

    protected function isMethodGet()
    {
        $this->data->setItem('method', 'get');
        return $this;
    }

    public function setRequestOrganizationId($organizationId)
    {
        $this->setRequest('organizationId', $organizationId);
        return $this;
    }

    public function setRequestBody($body)
    {
        $this->setRequest('body', $body);
        return $this;
    }

    protected function getRequestBody()
    {
        return (array) $this->getRequest('body');
    }

    protected function setHttpResponses($responses)
    {
        $this->setResponse('httpResponses', $responses);
        return $this;
    }

    protected function getHttpResponses()
    {
        return $this->getResponse('httpResponses');
    }

    public function isSuccess()
    {
        return $this->data->getItem('httpResponses.success');
    }

    public function getErrorMessage()
    {
        return $this->data->getItem('httpResponses.errorMessage');
    }

    public function getData()
    {
        return $this->camel((array) $this->data->getItem('httpResponses.data'));
    }
}
