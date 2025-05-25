<?php

namespace App\Cores\Features;

use App\Cores\Core;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class Feature extends Core
{
    public function run()
    {
        DB::beginTransaction();;
        try {
            parent::run();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            $this->exception($exception);
        }
        return $this;
    }

    protected function exception(Exception $exception)
    {
        $this->error($exception->getMessage());
    }

    protected function filters(Builder $builder)
    {
        $filters = (array) $this->getRequest('filter');
        if (empty($filters)) {
            return $builder;
        }
        foreach ($filters as $filter) {
            $builder = $this->filter($builder, $filter[0], $filter[1], $filter[2]);
        }
        return $builder;
    }

    protected function filter(Builder $builder, $field, $option, $value)
    {
        switch ($option) {
            case 'in':
                $builder->whereIn($field, (array) $value);
                break;
            case 'between':
                $builder->whereBetween($field, (array) $value);
                break;
            default:
                $builder->where($field, $option, $value);
                break;
        }
        return $builder;
    }

    protected function lists(Builder $builder, $callback = null)
    {
        $builder = $this->filters($builder);
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

    public function getHttpResponses($camel = true)
    {
        $data = (array) parent::getResponses();
        if ($camel) {
            $data = $this->camel($data);
        }
        return $data;
    }
}
