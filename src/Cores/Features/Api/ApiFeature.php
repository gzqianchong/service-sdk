<?php

namespace App\Cores\Features\Api;

use App\Cores\Features\Feature;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

abstract class ApiFeature extends Feature
{
    protected function lists(Builder $builder, $callback = null)
    {
        if ($this->getPage() || $this->getPageSize()) {
            $model = $builder->paginate($this->getPageSize(), ['*'], '', $this->getPage());
            $items = Collection::make($model->items())->toArray();
            if ($callback) {
                $items = call_user_func($callback, $items);
            }
            $this->success([
                'items' => $items,
                'total' => $model->total(),
                'pageSize' => $model->perPage(),
                'page' => $model->currentPage(),
            ]);
        } else {
            $items = $builder->get()->toArray();
            if ($callback) {
                $items = call_user_func($callback, $items);
            }
            $this->success([
                'items' => $items,
            ]);
        }
    }

    protected function getPage()
    {
        return $this->getRequest('page');
    }

    protected function getPageSize()
    {
        return $this->getRequest('pageSize');
    }

    protected function error($message = 'error', $data = [])
    {
        $this->setResponses([
            'success' => false,
            'data' => $data,
            'errorMessage' => $message,
            'errorCode' => 1,
            'showType' => 1,
        ]);
        return $this;
    }

    protected function success($data = [], $message = '')
    {
        $this->setResponses([
            'success' => true,
            'data' => $data,
            'errorMessage' => $message,
            'errorCode' => 0,
            'showType' => 0,
        ]);
        return $this;
    }

    public function getResponses($camel = true)
    {
        $data = (array) parent::getResponses();
        if ($camel) {
            $data = $this->camel($data);
        }
        return $data;
    }
}
