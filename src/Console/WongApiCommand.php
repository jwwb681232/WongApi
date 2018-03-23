<?php

namespace Jwwb681232\WongApi\Console;

use Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class WongApiCommand extends Command
{
    private   $bar;
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

        $this->files = $filesystem;
    }

    public function handle()
    {
        $this->setBar();

        $model = $this->argument('model');

        $this->createDir();

        $stub = $this->getStub();

        $stubData = $this->getStubData($model);

        $this->replaceStub($stub, $stubData);

        $this->bar->finish();

    }

    private function setBar(){
        $this->bar = $this->output->createProgressBar(2);
    }


    private function createDir()
    {
        $dir = [
            'stub_model' => app_path().DIRECTORY_SEPARATOR.'Models',
            'stub_provider' => app_path().DIRECTORY_SEPARATOR.'AuthProvider',
        ];

        foreach ($dir as $key => $value) {
            if ( ! $this->files->isDirectory($value)) {
                $this->files->makeDirectory($value, 0755, true);
            }
        }
        return true;
    }

    private function getStub()
    {
        try {
            $stub = [
                'stub_model'=>$this->files->get(app()->basePath('vendor\jwwb681232\wongapi\src\Stubs\model.stub')),
                'stub_provider'=>$this->files->get(app()->basePath('vendor\jwwb681232\wongapi\src\Stubs\provider.stub'))
            ];
        } catch (FileNotFoundException $e) {
            return $e->getMessage();
        }

        return $stub;

    }

    private function getStubData($model)
    {
        return ['stub_model' => $model,'stub_provider'=>$model];
    }

    private function replaceStub($stub, $stubData)
    {
        foreach ($stubData as $search => $replace) {
            $newFile = str_replace('$'.$search, $replace, $stub[$search]);
            if ($search == 'stub_model'){
                $this->files->put(app_path().DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR.$replace.'.php', $newFile);
            }
            if ($search == 'stub_provider'){
                $this->files->put(app_path().DIRECTORY_SEPARATOR.'AuthProvider'.DIRECTORY_SEPARATOR.'Eloquent'.$replace.'Provider.php', $newFile);
            }
            $this->bar->advance();
        }

        return true;
    }
}


