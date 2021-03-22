<?php

namespace Laravel\Extracommands\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class GenrateView extends GeneratorCommand
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $name = 'make:view';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new view file';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'view';
    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function viewPath($path = '')
    {
        $view = str_replace('.', '/', $path) . '.blade.php';
        $path = "resources/views/{$view}";
        return $path;
    }

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return  app_path() . '/Stubs/view.stub';
	}

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the view.'],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $name = $this->argument('name');

        $path = $this->viewPath($name);

        $this->createDir($path);

        if ($this->files->exists($path)){
            $this->error("File {$path} already exists!");
            return;
        }
        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        $this->info($this->type.' created successfully.');
    }

      /**
     * Create view directory if not exists.
     *
     * @param $path
    */
    public function createDir($path)
    {
        $dir = dirname($path);

        if (!file_exists($dir)){
            mkdir($dir, 0777, true);
        }
    }
}

