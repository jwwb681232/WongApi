<?php

namespace Jwwb681232\WongApi\Console;

use Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

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

        $this->files = $filesystem;
    }

    public function handle()
    {
        //1、获取参数
        $model = $this->argument('model');

        //2、创建文件夹
        $this->createDir();

        //3、获取stub模板文件
        $stub = $this->getStub();

        //4、获取替换的变量
        $stubData = $this->getStubData($model);

        //4、替换模板文件内容
        $newFile = $this->replaceStub($stub, $stubData);

        //5、进行模板渲染
        return $this->files->put(
            app_path().DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR.$model.'.php',
            $newFile
        );
    }


    private function createDir()
    {
        $dir = [
            'model' => app_path().DIRECTORY_SEPARATOR.'Models',
            'provider' => app_path().DIRECTORY_SEPARATOR.'AuthProvider',
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
                'model'=>$this->files->get(app()->basePath('vendor\jwwb681232\wongapi\src\Stubs\model.stub')),
                'provider'=>$this->files->get(app()->basePath('vendor\jwwb681232\wongapi\src\Stubs\provider.stub'))
            ];
        } catch (FileNotFoundException $e) {
            return $e->getMessage();
        }

        return $stub;

    }

    private function getStubData($model)
    {
        return ['model' => $model];
    }

    private function replaceStub($stub, $stubData)
    {
        $newFile = '';
        foreach ($stubData as $search => $replace) {
            $newFile = str_replace('$'.$search, $replace, $stub);
        }

        return $newFile;
    }
}


