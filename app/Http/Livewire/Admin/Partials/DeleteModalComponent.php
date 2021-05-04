<?php

namespace App\Http\Livewire\Admin\Partials;

use App\Models\User;

use Livewire\Component;

class DeleteModalComponent extends Component
{
    public $type;

    protected $listeners = [
        'delete',
        'onTrashIcon'
    ];

    public function onTrashIcon($id, $type)
    {
        $this->type = $type;
        $this->emit('triggerConfirmationModal', $id);
    }

    public function delete($id)
    {
        switch ($this->type) {
            case 'user':
                $user = User::find($id);
                $user->delete();
                break;
            default:
                # code...
                break;
        }

        $this->emitUp('tableRefresh');
    }

    public function render()
    {
        return view('livewire.admin.partials.delete-modal-component');
    }
}
