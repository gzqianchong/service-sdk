<?php

namespace App\Cores\Services;

class UpdateService extends Service
{
    protected function request()
    {
        parent::request();
        $this->isMethodPut();
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
