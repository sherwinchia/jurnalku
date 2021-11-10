<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateDatatable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:datatable {path} {indentifier=id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate livewire component datatable for admin panel.';

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
        $path = strtolower($this->argument('path'));
        $identifier = strtolower($this->argument('indentifier'));

        $path_array = explode('/', $path);
        $folder = $path_array[0];
        $folder_uppercase = ucfirst($path_array[0]);

        $model_lowercase = end($path_array);
        $model = ucfirst($model_lowercase);

        $pluralize_model = pluralize(2, $model_lowercase);

        $controller_file = "{$model}Table.php";
        $view_file = "{$model_lowercase}-table.blade.php";

        $app_path = app_path();
        $resource_path = resource_path();

        $controller_folder_path =  "{$app_path}/Http/Livewire/{$folder_uppercase}/{$model}";
        $view_folder_path = "{$resource_path}/views/livewire/{$folder}/{$model_lowercase}";

        $controller_path = "{$controller_folder_path}/{$controller_file}";
        $view_path = "{$view_folder_path}/{$view_file}";

        if (!$this->files->isDirectory($controller_folder_path)) {
            $this->files->makeDirectory($controller_folder_path);
            $this->info("{$model} folder have been created.");
        }
        if (!$this->files->isDirectory($view_folder_path)) {
            $this->files->makeDirectory($view_folder_path);
            $this->info("{$model_lowercase} folder have been created.");
        }

        if (file_exists($controller_path))
            return $this->error('⚠️ ' . $controller_path . ' file already exists!');

        if (file_exists($view_path))
            return $this->error('⚠️ ' . $view_path . ' file already exists!');

        $view_content = '<x-ui.table>
        <x-slot name="header">
            <div class="flex flex-col gap-2 lg:flex-row">
                <x-jet-input wire:model="search" class="" type="text" placeholder="Search" />
                <x-ui.select class="" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </x-ui.select>
            </div>

            @if (in_array("create", $actions))
            <div class="flex items-center">
                <x-jet-button wire:click="create' . $model . '" wire:loading.attr="disabled">
                    Create
                    <span wire:loading wire:target="create' . $model . '"
                        class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                    </span>
                </x-jet-button>
            </div>
            @endif
        </x-slot>
        <thead>
            <x-ui.table-row>
                @foreach ($columns as $column)
                    @if ( array_key_exists("sortable", $column) && $column["sortable"] === true)
                    <x-ui.table-header class="{{ $column[\'align\'] ?? \'\' }}>
                        <x-ui.sort-button target-field="{{ $column["field"] }}" :sort-field="$sortField" :sort-asc="$sortAsc"
                            class="font-medium" wire:click.prevent="sortBy(\'{{$column["field"]}}\')">
                            {{ $column["name"] }}
                        </x-ui.sort-button>
                    </x-ui.table-header>
                    @else
                    <x-ui.table-header class="{{ $column[\'align\'] ?? \'\' }}>
                        {{ $column["name"] }}
                    </x-ui.table-header>
                    @endif
                @endforeach
            </x-ui.table-row>
        </thead>

        <tbody>
            @foreach ($' . $pluralize_model . ' as $' . $model_lowercase . ')
            <x-ui.table-row>
                @foreach ($columns as $column)
                @if (array_key_exists("field", $column) && $column["field"] === "action")
                <x-ui.table-data class="{{ $column[\'align\'] ?? \'\' }}>
                    <div class="flex text-gray-600">
                        @foreach ($actions as $action)
                        @if ($action === "show")
                        <a class="mx-1 text-lg" role="button" href="{{ route(\'admin.' . $pluralize_model . '.show\', $' . $model_lowercase . '->id)
                            }}">
                            <x-icon.eye class="w-5 h-5" />
                        </a>
                        @elseif ($action === "edit")
                        <a class="mx-1 text-lg" role="button" href="{{ route(\'admin.' . $pluralize_model . '.edit\', $' . $model_lowercase . '->id)
                            }}">
                            <x-icon.pencil-alt class="w-5 h-5" />
                        </a>
                        @elseif ($action === "delete")
                        <a class="mx-1 text-lg" role="button" wire:click="showModal(\'{{Crypt::encrypt($' . $model_lowercase . '->id)}}\')">
                            <x-icon.trash class="w-5 h-5" />
                        </a>
                        @endif
                        @endforeach
                    </div>
                </x-ui.table-data class="{{ $column[\'align\'] ?? \'\' }}>
                @else
                <x-ui.table-data>
                    @if (array_key_exists("relation", $column) && isset($column["relation"]))
                    @if (array_key_exists("format", $column) && isset($column["format"]))
                    @if (count($column["format"]) > 1)
                    {{ $column["format"][0](data_get($' . $model_lowercase . ',$column["relation"]), implode(",",
                    array_slice($column["format"], 1))) }}
                    @else
                    {{ $column["format"][0](data_get($' . $model_lowercase . ',$column["relation"])) }}
                    @endif
                    @else
                    {{ data_get($' . $model_lowercase . ',$column["relation"]) }}
                    @endif
                    @else
                    @if (array_key_exists("format", $column) && isset($column["format"]))
                    @if (count($column["format"]) > 1)
                    {{ $column["format"][0](data_get($' . $model_lowercase . ',$column["field"]), implode(",", array_slice($column["format"],
                    1))) }}
                    @else
                    {{ $column["format"][0](data_get($' . $model_lowercase . ',$column["field"])) }}
                    @endif
                    @else
                    {{ data_get($' . $model_lowercase . ',$column["field"]) }}
                    @endif
                    @endif
                </x-ui.table-data>
                @endif
                @endforeach
            </x-ui.table-row>
            @endforeach
        </tbody>

        <x-slot name="footer">
            <div class="mt-4 sm:flex-1 sm:flex sm:items-center sm:justify-between work-sans">
                <div class="py-3">
                    <p class="text-sm leading-5">
                        Showing
                        <span class="font-medium">{{ $' . $pluralize_model . '->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $' . $pluralize_model . '->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $' . $pluralize_model . '->total() }}</span>
                        results
                    </p>
                </div>
                <div class="inline-block">
                    {{ $' . $pluralize_model . '->links() }}
                </div>
            </div>
            </div>
            <x-jet-dialog-modal wire:model="modalVisible">
                <x-slot name="title">
                    Delete ' . $model . '
                </x-slot>

                <x-slot name="content">
                    This action can not be recovered!
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle(\'modalVisible\')" wire:loading.attr="disabled">
                        Cancel
                    </x-jet-secondary-button>

                    <x-jet-danger-button class="ml-2" wire:click="$toggle(\'modalVisible\')" wire:loading.attr="disabled">
                        Delete
                        <span wire:loading wire:target="delete"
                            class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                        </span>
                    </x-jet-danger-button>
                </x-slot>
            </x-jet-dialog-modal>
        </x-slot>
    </x-ui.table>';

        $controller_content = '<?php
namespace App\Http\Livewire\\'.$folder_uppercase.'\\' . $model . ';

use App\Http\Traits\Alert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\\' . $model . ';
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class ' . $model . 'Table extends Component
{
    use WithPagination, Alert;
    protected $listeners = [\'tableRefresh\' => \'$refresh\'];
    public $search = "";
    public $sortField = "id";
    public $sortAsc = true;
    public $perPage = 10;
    public $modalVisible = false;
    public $encryptedId;
    public $actions = ["create"];
    public $columns = [
        [
            "name" => "ID",
            "field" => "id",
            "sortable" => true,
        ],
        [
            "name" => "Action",
            "field" => "action",
            "sortable" => false,
        ],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function showModal($id)
    {
        $this->modalVisible = true;
        $this->encryptedId = $id;
    }

    public function delete()
    {
        $id = $this->decrypt($this->encryptedId);
        if (isset($id)) {
            ' . $model . '::find($id)->delete();
            $this->alert([
                "type" => "success",
                "message" => "' . $model . ' has been successfully deleted."
            ]);
        }
        $this->modalVisible = false;
    }

    private function decrypt(string $string)
    {
        try {
            return Crypt::decrypt($string);
        } catch (\Exception $e) {
            $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function create' . $model . '()
    {
        return redirect(route("admin.' . $pluralize_model . '.create"));
    }

    public function paginationView()
    {
        return "admin.partials.pagination";
    }

    public function render()
    {
        return view("livewire.'.$folder.'.' . $model_lowercase . '.' . $model_lowercase . '-table", [
            "' . $pluralize_model . '" => ' . $model . '::query()
                ->where("' . $identifier . '", "ILIKE", "%{$this->search}%")
                ->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage)
        ]);
    }
}';

        // if ($this->confirm("Do you wish to generate {$model_lowercase}-table.blade.php and {$model}Table.php file?")) {}
        if (!$this->files->put($controller_path, $controller_content))
            return $this->error('Something went wrong!');

        if (!$this->files->put($view_path, $view_content))
            return $this->error('Something went wrong!');

        $this->info("{$controller_file} and {$view_file} has been generated ✌️");
        $this->info($controller_path);
        return $this->info($view_path);
    }
}
