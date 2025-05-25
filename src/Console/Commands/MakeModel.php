<?php

namespace App\Console\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeModel extends GeneratorCommand
{
    use CreatesMatchingTest;

    protected $name = 'make:model';

    protected static $defaultName = 'make:model';

    protected $description = 'Create a new Eloquent model class';

    protected $type = 'Model';

    public function handle()
    {
        if (parent::handle() === false) {
            return false;
        }

        if ($this->option('migration')) {
            $this->createMigration();
        }
    }

    protected function createMigration()
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
            '--fullpath' => true,
        ]);
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/model.stub');
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return is_dir(base_path('app/Models')) ? $rootNamespace . '\\Models' : $rootNamespace;
    }

    protected function getOptions()
    {
        return [
            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model'],
        ];
    }
}
