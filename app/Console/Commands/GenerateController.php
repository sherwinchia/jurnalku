<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:controller {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate restful controller with scalffolding.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = ucfirst(strtolower($this->argument('path')));
        $path_array = explode('/', $path);
        $path_array = array_map('ucfirst', $path_array);
        $file_path = implode('/', $path_array);
        $model_lowercase = strtolower(end($path_array));
        $model = ucfirst($model_lowercase);
        $app_path = app_path();

        if (file_exists($app_path . '/Http/Controllers/' . $file_path . 'Controller.php')) {
            return $this->error('⚠️ ' . $app_path . '/Http/Controllers/Admin/' . $model . 'Controller.php file already exist.');
        }

        $content = '<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\\' . $model . ';

class ' . $model . 'Controller extends Controller{

    const PATH = "admin.' . $model_lowercase . '.";

    public function index()
    {
        return view(self::PATH . "index");
    }

    public function create()
    {
        return view(self::PATH . "create");
    }

    public function show(' . $model . ' $' . $model_lowercase . ')
    {
        return view(self::PATH . "show", compact("' . $model_lowercase . '"));
    }

    public function edit(' . $model . ' $' . $model_lowercase . ')
    {
        return view(self::PATH . "edit", compact("' . $model_lowercase . '"));
    }
}
        ';

        $this->files->put($app_path . '/Http/Controllers/Admin/' . $model . 'Controller.php', $content);

        $this->info($model . "Controller.php has been generated.");
        return $this->info($app_path . '/Http/Controllers/Admin/' . $model . 'Controller.php');
    }
}
