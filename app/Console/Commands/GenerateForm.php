<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateForm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:form {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate livewire component form for specific model in admin panel.';

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
        $path = strtolower($this->argument('path'));

        $path_array = explode('/', $path);
        $folder = $path_array[0];
        $folder_uppercase = ucfirst($path_array[0]);

        $model_lowercase = end($path_array);
        $model = ucfirst($model_lowercase);
        $pluralize_model = pluralize(2,$model_lowercase);
    
        $fillable = app("App\Models\\".$model)->getFillable();
        $controller_file = "{$model}Form.php";
        $view_file = "{$model_lowercase}-form.blade.php";

        $app_path = app_path();
        $resource_path = resource_path();

        $controller_path = "{$app_path}/Http/Livewire/{$folder_uppercase}/Form/{$controller_file}";
        $view_path = "{$resource_path}/views/livewire/{$folder}/form/{$view_file}";

        if(file_exists($controller_path))
            return $this->error('⚠️ ' . $controller_path.' file already exists!');

        if(file_exists($view_path))
            return $this->error('⚠️ ' . $view_path.' file already exists!');

        $rules = "";
        foreach ($fillable as $val) {
            if (end($fillable) === $val) {
                $rules .= "\"{$model_lowercase}.{$val}\" => \"required\"
                ";
            } else {
                $rules .= "\"{$model_lowercase}.{$val}\" => \"required\",
                ";
            }
        }

        // $variables = "";
        // foreach ($fillable as $val) {
        //     if (end($fillable) === $val) {
        //         $variables .= " \${$val};";
        //     } else {
        //         $variables .= " \${$val},";
        //     }
        // }

        $input_sections = ""; 
        foreach ($fillable as $val) {
            $input_sections .= '
        <section>
            <div class="input-group">
                <label for="'.$val.'">'.$this->getLabel($val).' <span class="text-red-500">*</span></label>
                <input wire:model.defer="'.$model_lowercase.'.'.$val.'" type="text">
                @error("'.$model_lowercase.'.'.$val.'") <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </section>
';
        }

        $view_content='<div class="flex-1 flex justify-center overflow-y-hidden">
<div class="card w-full max-w-xl">
    <div class="card-header">
        <p>{{ $buttonText }} '.$model.'</p>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="submit" class="flex-none flex flex-col justify-between">
        '.$input_sections.'   
            <div>
                <x-jet-button type="button" wire:click.prevent="submit()" wire:loading.attr="disabled" class="">
                    {{ $buttonText }}
                    <span wire:loading wire:target="submit"
                    class="ml-2 animate-spin rounded-full h-3 w-3 border-t-2 border-b-2 border-white">
                    </span>
                </x-jet-button>
            </div>
        </form>
    </div>
    </div>
</div>';

$controller_content='<?php

namespace App\Http\Livewire\Admin\Form;

use App\Http\Traits\Alert;
use Livewire\Component;
use App\Models\\'.$model.';

class '.$model.'Form extends Component
{
    use Alert;

    public $'.$model_lowercase.';

    public $edit = false;

    public $buttonText = "Create";

    protected $rules = ['
        .$rules.
    '];

    public function mount($model = null)
    {
        
        if (isset($model)) {
            $this->edit = true;
            $this->'.$model_lowercase.' = $model;
            $this->buttonText = "Update";
        } else {
            $this->'.$model_lowercase.' = new '.$model.'();
        }
    }

    public function submit()
    {
        $this->validate();

        $this->'.$model_lowercase.'->save();

        if ($this->edit) {
            return $this->alert([
                "type" => "success",
                "message" => "'.$model.' has been successfully updated."
            ]);
        } else {
            $this->alert([
                "type" => "success",
                "message" => "'.$model.' has been successfully created.",
                "session" => true
            ]);
            return redirect()->route("admin.'.$pluralize_model.'.edit", $this->'.$model_lowercase.'->id);
        }
    }

    public function render()
    {
        return view("livewire.admin.form.'.$model_lowercase.'-form");
    }
}';
        
        if(!$this->files->put($controller_path, $controller_content))
            return $this->error('Something went wrong!');

        if(!$this->files->put($view_path, $view_content))
            return $this->error('Something went wrong!');
            
        $this->info("{$controller_file} and {$view_file} has been generated ✌️");
        $this->info($controller_path);
        return $this->info($view_path);
        
    }

    public function getLabel($string){
        $string_array = explode ("_", $string);
        $label = "";
        if (sizeof($string_array) == 1) {
            $label = ucfirst(strtolower($string_array[0]));
        } else {
            foreach ($string_array as $string) {
                $label .= ucfirst(strtolower($string)) . " ";
            }
        }

        return $label;
    }
}
