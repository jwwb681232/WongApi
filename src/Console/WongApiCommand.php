<?php

namespace Jwwb681232\WongApi\Console;

use Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;

class WongApiCommand extends Command
{
    protected $model;
    protected $files;

    protected $signature = 'wong:create {model}';

    protected $description = 'Create a model endpoint';

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->files    = $filesystem;
    }

    public function handle()
    {
        $model = $this->argument('repository');
        //$this->writeRepositoryAndInterface($model);
    }

    /*private function writeRepositoryAndInterface($model)
    {
        if($this->createRepository($model)){
            $this->info('Success to make a '.ucfirst($model).' Repository and a '.ucfirst($model).'Interface Interface');
        }
    }

    private function createRepository($model)
    {
        $this->setModel($model);
        $this->createDirectory();
    }

    private function createDirectory()
    {
        $directory = $this->getDirectory();
        if(! $this->files->isDirectory($directory)){
            return $this->files->makeDirectory($directory, 0755, true);
        }
    }

    private function getDirectory()
    {
        return Config::get('wong.model_path');
    }


    public function setModel($model)
    {
        $this->model = $model;
    }*/

}


