<?php

namespace App\Cores\Services;

class DetailService extends Service
{
    protected function request()
    {
        parent::request();
        $this->isMethodGet();
    }

    public function setRequestId($id)
    {
        $this->setRequest('id', $id);
        return $this;
    }

    public function getRequestId()
    {
        return $this->getRequest('id');
    }
}
