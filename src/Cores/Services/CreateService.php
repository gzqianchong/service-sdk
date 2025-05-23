<?php

namespace App\Cores\Services;

class CreateService extends Service
{
    protected function request()
    {
        parent::request();
        $this->isMethodPost();
    }
}
