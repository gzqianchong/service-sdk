<?php

namespace App\Cores\Services;

class DeleteService extends Service
{
    protected function request()
    {
        parent::request();
        $this->isMethodDelete();
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
