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
    protected $signature = 'generate:datatable {model} {indentifier=name}';

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
        $this->files=$files;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model=ucfirst(strtolower($this->argument('model')));
        $identifier=strtolower($this->argument('indentifier'));
        $model_lowercase = strtolower($model);
        $pluralize_model = pluralize(2,$model_lowercase);

        $controller_file = "{$model}Table.php";
        $view_file = "{$model_lowercase}-table.blade.php";

        $app_path = app_path();
        $resource_path = resource_path();

        $controller_path = "{$app_path}/Http/Livewire/Admin/Table/{$controller_file}";
        $view_path = "{$resource_path}/views/livewire/admin/table/{$view_file}";
        
        if(file_exists($controller_path))
            return $this->error('⚠️ ' . $controller_path.' file already exists!');

        if(file_exists($view_path))
            return $this->error('⚠️ ' . $view_path.' file already exists!');

        $view_content='<div class="data-table overflow-x-auto">
<div class="top">
    <div class="flex justify-between mb-2">
        <div class="flex space-x-2">
            <div class="input-group">
                <input wire:model="search" class="" type="text" placeholder="Search">
            </div>
            <div class="input-group">
                <select class="" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            </div>
        </div>
        <div>
            <x-jet-button wire:click="create'.$model.'" wire:loading.attr="disabled">
                Create
                <span wire:loading wire:target="create'.$model.'"
                    class="ml-2 animate-spin rounded-full h-3 w-3 border-t-2 border-b-2 border-white">
                </span>
            </x-jet-button>
        </div>

    </div>
</div>
<div class="bottom">
    <table class="min-w-full">
        <thead>
            <tr>
                <th class="text-left">
                    <a wire:click.prevent="sortBy(\'id\')" role="button">ID</a>
                    @include(\'admin.partials.sort-icon\', [\'field\'=>\'id\'])
                </th>
                <th class="text-left">
                    <a wire:click.prevent="sortBy(\'name\')" role="button">Name</a>
                    @include(\'admin.partials.sort-icon\', [\'field\'=>\'name\'])
                </th>

                <!--Add column header here-->

                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($'.$pluralize_model.' as $'.$model_lowercase.')
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap border-b">
                        <div class="flex items-center">
                            <div>
                                <div class="text-sm leading-5 text-gray-800">{{ $'.$model_lowercase.'->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="non-id">
                        {{ $'.$model_lowercase.'->'.$identifier.' }}
                    </td>

                    <!--Add column table data here-->

                    <td class="non-id">
                        <div class="flex justify-center text-gray-600">
                            <a class="mx-1 text-lg" role="button"
                                href="{{ route(\'admin.'.$pluralize_model.'.edit\', $'.$model_lowercase.'->id) }}">
                                <i class="far fa-edit"></i>
                            </a>
                            <a class="mx-1 text-lg" role="button" wire:click="showModal({{ $'.$model_lowercase.'->id }})">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between mt-4 work-sans">
        <div>
            <p class="text-sm leading-5">
                Showing
                <span class="font-medium">{{ $'.$pluralize_model.'->firstItem() }}</span>
                to
                <span class="font-medium">{{ $'.$pluralize_model.'->lastItem() }}</span>
                of
                <span class="font-medium">{{ $'.$pluralize_model.'->total() }}</span>
                results
            </p>
        </div>
        <div class="inline-block">
            {{ $'.$pluralize_model.'->links() }}
        </div>
    </div>
</div>
<x-jet-dialog-modal wire:model="modalVisible">
    <x-slot name="title">
        Delete '.$model.'
    </x-slot>

    <x-slot name="content">
        This action can not be recovered!
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle(\'modalVisible\')" wire:loading.attr="disabled">
            Cancel
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
            Delete
            <span wire:loading wire:target="delete"
                class="ml-2 animate-spin rounded-full h-3 w-3 border-t-2 border-b-2 border-white">
            </span>
        </x-jet-danger-button>
    </x-slot>
</x-jet-dialog-modal>
</div>';

        $controller_content='<?php
namespace App\Http\Livewire\Admin\Table;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\\'.$model.';

class '.$model.'Table extends Component
{
    use WithPagination;
    protected $listeners = [\'tableRefresh\' => \'$refresh\'];
    public $search = "";
    public $sortField = "id";
    public $sortAsc = true;
    public $perPage = 10;
    public $modalVisible = false;
    public $modalId;

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
        $this->modalId = $id;
    }

    public function delete()
    {
        $'.$model_lowercase.' = '.$model.'::find($this->modalId);
        $'.$model_lowercase.'->delete();
        $this->modalVisible = false;
    }

    public function create'.$model.'()
    {
        return redirect(route("admin.'.$pluralize_model.'.create"));
    }

    public function paginationView()
    {
        return "admin.partials.pagination";
    }

    public function render()
    {
        return view("livewire.admin.table.'.$model_lowercase.'-table", [
            "'.$pluralize_model.'" => '.$model.'::query()
                ->where("'.$identifier.'", "LIKE", "%{$this->search}%")
                ->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage)
        ]);
    }
}';

        if ($this->confirm("Do you wish to generate {$model_lowercase}-table.blade.php and {$model}Table.php file?")) {
            if(!$this->files->put($controller_path, $controller_content))
                return $this->error('Something went wrong!');

            if(!$this->files->put($view_path, $view_content))
                return $this->error('Something went wrong!');
                
            $this->info("{$controller_file} and {$view_file} has been generated ✌️");
            $this->info($controller_path);
            return $this->info($view_path);
        }
    }    
}
