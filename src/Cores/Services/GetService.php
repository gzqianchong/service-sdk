<?php

namespace App\Cores\Services;

class GetService extends Service
{
    protected function request()
    {
        parent::request();
        $this->isMethodGet();
    }

    public function setRequestPage($page)
    {
        $this->setRequest('page', $page);
        return $this;
    }

    public function setRequestPageSize($pageSize)
    {
        $this->setRequest('pageSize', $pageSize);
        return $this;
    }

    public function getResponseItems()
    {
        return $this->data->getItem('httpResponses.data.items');
    }

    public function getResponsePage()
    {
        return $this->data->getItem('httpResponses.data.page');

    }

    public function getResponsePageSize()
    {
        return $this->data->getItem('httpResponses.data.pageSize');

    }

    public function getResponseTotalPage()
    {
        return $this->data->getItem('httpResponses.data.totalPage');
    }

    public function getResponseTotal()
    {
        return $this->data->getItem('httpResponses.data.total');
    }
}
