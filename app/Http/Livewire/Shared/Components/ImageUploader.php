<?php

namespace App\Http\Livewire\Shared\Components;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ImageUploader extends Component
{
    use WithFileUploads;

    public $images = [];
    public $temp_images = [];
    public $model, $old_images, $multiple, $name;

    public function mount($multiple = null, $model = null, $collection = null, $name)
    {
        $this->multiple = $multiple;
        $this->name = $name;
        $this->model = $model;

        if (!is_null($this->model) && $this->model->hasMedia($collection)) {
            $this->old_images = $this->model->getMedia($collection);
        }
    }

    public function uploadImages()
    {
        $this->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if (!empty($this->temp_images)) {
            foreach ($this->temp_images as $image) {
                Storage::delete('public/image-uploader/' . $image);
            }
            $this->temp_images = array();
        }

        // if (!is_null($this->model) && $this->model->hasMedia()) {
        //     //Delete all media
        //     $this->old_images = null;
        // }

        foreach ($this->images as $image) {
            $image->store('public/image-uploader');
            array_push($this->temp_images, $image->hashName());
        }

        $this->imagesChanged();
    }

    public function removeImage($index, $old = false)
    {
        if ($old) {
            $this->old_images[$index]->delete();
            unset($this->old_images[$index]);
        } else {
            Storage::delete("public/image-uploader/" . $this->temp_images[$index]);
            unset($this->images[$index]);
            return $this->imagesChanged();
        }
    }

    public function imagesChanged()
    {
        $this->emitUp('imagesChanged', $this->name, $this->temp_images);
    }

    public function render()
    {
        return view('livewire.shared.components.image-uploader');
    }
}
