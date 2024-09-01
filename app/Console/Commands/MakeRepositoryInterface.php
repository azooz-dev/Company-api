<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeRepositoryInterface extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-repository-interface {name}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository interface';
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
        $this->argument('name');
        $interfaceName = $this->argument('name') . 'RepositoryInterface';
        $directory = app_path('/Repositories/Interfaces');

        if (!$this->files->exists($directory)) {
            $this->files->createDir($directory, 0777, true);
        }

        $path = $directory . '/' . $interfaceName . '.php';

        if ($this->files->exists($path)) {
            $this->error($interfaceName . 'File already exists!');
            return;
        }

        $stub = $this->getSub();
        $stub = str_replace('{$interfaceName}', $interfaceName, $stub);

        $this->files->put($path, $stub);
        $this->info($interfaceName . ' created successfully.');
    }

    protected function getSub()
    {
        return <<<'EOT'
        <?php

        namespace App\Repositories\Interfaces;

        interface {{interfaceName}}
        {
            // Define your methods here
        }
        EOT;
    }
}
