<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Task extends Command
{
    protected $signature = 'task {name} {--p=}';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $name = Str::studly($name);
        $class = 'App\Cores\Tasks\\' . Str::replace('/', '\\', $name);
        $class = call_user_func([$class, 'init']);
        $p = $this->option('p');
        if (!empty($p)) {
            $param = [];
            $p = explode(',', $p);
            foreach ($p as $value) {
                $parse = explode(':', $value);
                Arr::set($param, Arr::first($parse), Arr::last($parse));
            }
            $class = $class->setRequests($param);
        }
        $class->run();
        return true;
    }
}
