<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;
    public $open = false;
    public $title, $content, $image, $identificador;
    protected $rules = [
        'title' => 'required|max:10',
        'content' => 'required',
        'image' => 'required|image|max:2048'
    ];
    public function render()
    {
        // $this->content = "Hola mundo!!!";
        return view('livewire.create-post');
    }
    public function mount()
    {
        $this->identificador = rand();
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function save()
    {
        $image = $this->image->store('public/posts');
        $this->validate();
        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $image
        ]);
        $this->reset(['open', 'title', 'content', 'image']);
        $this->identificador = rand();
        $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El post se ha creado satisfactoriamente!');
    }
}
