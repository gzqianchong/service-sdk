<?php

namespace App\Cores\Services\Base\Category;

use App\Cores\Services\GetService;

class CategoryGetService extends GetService
{
    protected function request()
    {
        parent::request();
        $this->setPath('/service-base/api/category');
    }
}
