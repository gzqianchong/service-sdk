<?php

namespace App\Cores\Services\Base\Category;

use App\Cores\Services\CreateService;

class CategoryCreateService extends CreateService
{
    protected function request()
    {
        parent::request();
        $this->setPath('/service-base/api/category');
    }
}
