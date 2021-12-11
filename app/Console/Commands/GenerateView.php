<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:view {path} {--t|type=ceis}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate resourceful empty view blade file.';

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
        $path = $this->argument('path');
        $path_array = explode('/', $path);
        $model_lowercase = strtolower(end($path_array));
        $type = strtolower($this->option('type'));
        $resource_path = resource_path();
        $file_path = $resource_path . "/views/" . $path;

        if (!$this->files->isDirectory($file_path)) {
            $this->files->makeDirectory($file_path);
            $this->info("{$model_lowercase} folder have been created.");
        }

        if (str_contains($type, 'c') && file_exists($file_path . '/create.blade.php')) {
            return $this->error('⚠️ ' . $file_path . '/create.blade.php file already exist');
        }
        if (str_contains($type, 'e') && file_exists($file_path . '/edit.blade.php')) {
            return $this->error('⚠️ ' . $file_path . '/edit.blade.php file already exist');
        }
        if (str_contains($type, 'i') && file_exists($file_path . '/index.blade.php')) {
            return $this->error('⚠️ ' . $file_path . '/index.blade.php file already exist');
        }
        if (file_exists(str_contains($type, 's') && $file_path . '/show.blade.php')) {
            return $this->error('⚠️ ' . $file_path . '/show.blade.php file already exist');
        }

        $index_content = '<x-layout.' . strtolower($path_array[0]) . '>
            <livewire:' . strtolower($path_array[0]) . '.' . $model_lowercase . '.' . $model_lowercase . '-table>
</x-layout.' . strtolower($path_array[0]) . '>';

        $create_content = '<x-layout.' . strtolower($path_array[0]) . '>
            <livewire:' . strtolower($path_array[0]) . '.' . $model_lowercase . '.' . $model_lowercase . '-form />
</x-layout.' . strtolower($path_array[0]) . '>
    ';

        $edit_content = '<x-layout.' . strtolower($path_array[0]) . '>
            <livewire:' . strtolower($path_array[0]) . '.' . $model_lowercase . '.' . $model_lowercase . '-form :model="$' . $model_lowercase . '" />
</x-layout.' . strtolower($path_array[0]) . '>
    ';

        $show_content = '<x-layout.' . strtolower($path_array[0]) . '>
            <livewire:' . strtolower($path_array[0]) . '.' . $model_lowercase . '.' . $model_lowercase . '-show :model="$' . $model_lowercase . '"/>
</x-layout.' . strtolower($path_array[0]) . '>
    ';

        if (str_contains($type, 'c')) {
            $this->files->put($file_path . '/create.blade.php', $create_content);
            $this->info("create file have been created.");
        }
        if (str_contains($type, 'e')) {
            $this->files->put($file_path . '/edit.blade.php', $edit_content);
            $this->info("edit file have been created.");
        }
        if (str_contains($type, 'i')) {
            $this->files->put($file_path . '/index.blade.php', $index_content);
            $this->info("index file have been created.");
        }
        if (str_contains($type, 's')) {
            $this->files->put($file_path . '/show.blade.php', $show_content);
            $this->info("show file have been created.");
        }
        return $this->info("Action complete ✌️");
    }
}
