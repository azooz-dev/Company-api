<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository implementation';
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $repositoryName = $name . 'Repository';
        $directory = app_path('/Repositories/Eloquent');

        if (!$this->files->exists($directory)) {
            $this->files->makeDirectory($directory, 0777, true);
        }

        $path = $directory . '/' . $repositoryName . '.php';

        if (!$this->files->exists($path)) {
            $this->error($repositoryName . 'File already exists!');
            return;
        }

        $stub = $this->getSub();
        $stub = str_replace('{$repositoryName}', $repositoryName, $stub);
        $stub = str_repeat('{$interfaceName}', '{$name}RepositoryInterface', $stub);

        $this->files->put($path, $stub);
        $this->info($repositoryName . ' created successfully.');
    }


    protected function getSub() {
        return <<<'EOT'
        <?php
        namespace App\Repositories\Eloquent;
        use App\Repositories\Interfaces\{$interfaceName};

        class {$repositoryName} implements {$interfaceName}
        {
            // Implement your methods here..
        }
        EOT;
    }
}
