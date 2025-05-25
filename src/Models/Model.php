<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Model extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    public static $uniqueKeys = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::orderedUuid()->toString();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    final public static function init()
    {
        return new static();
    }

    public static function add($data = [])
    {
        $model = static::withTrashed()
            ->withoutGlobalScopes()
            ->firstOrNew(Arr::only($data, static::$uniqueKeys));
        $model->fill(Arr::whereNotNull($data));
        $model->save();
        return $model;
    }

    public static function edit($data = [])
    {
        $model = static::withTrashed()
            ->withoutGlobalScopes()
            ->findOrFail(Arr::get($data, 'id'));
        $model->fill(Arr::whereNotNull($data));
        $model->save();
        return $model;
    }

    public static function lists($data = [], $callback = null)
    {
        $model = static::query();
        $page = Arr::get($data, 'page');
        $pageSize = Arr::get($data, 'page_size');
        if ($page || $pageSize) {
            $model = $model->paginate(Arr::get($data, 'page'), ['*'], '', $pageSize);
            $items = Collection::make($model->items())->toArray();
            if ($callback) {
                $items = call_user_func($callback, $items);
            }
            return [
                'items' => $items,
                'total' => $model->total(),
                'pageSize' => $model->perPage(),
                'page' => $model->currentPage(),
            ];
        } else {
            $items = $model->get()
                ->toArray();
            if ($callback) {
                $items = call_user_func($callback, $items);
            }
            return [
                'items' => $items,
            ];
        }
    }
}
