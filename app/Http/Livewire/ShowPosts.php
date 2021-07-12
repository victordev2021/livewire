<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithFileUploads;
    use WithPagination;
    // public $title;
    // public $name;
    public $post, $image, $identificador;
    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';
    public $open_edit = false;
    public $cant = '5';
    public $readyToLoad = false;
    protected $listeners = ['render', 'delete'];
    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];
    protected $queryString = [
        'cant' => ['except' => '5'],
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => '']
    ];
    public function mount()
    {
        $this->identificador = rand();
        $this->post = new Post();
    }
    public function render()
    {
        if ($this->readyToLoad) {
            # code...
            $posts = Post::where('title', 'like', '%' . $this->search . '%')
                ->orWhere('content', 'like', '%' . $this->search . '%')
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } else {
            # code...
            $posts = [];
        }
        return view('livewire.show-posts', compact('posts'));
    }
    public function loadPosts()
    {
        # code...
        $this->readyToLoad = true;
    }
    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }
    public function edit(Post $post)
    {
        $this->post = $post;
        $this->open_edit = true;
    }
    public function update()
    {
        $this->validate();
        if ($this->image) {
            Storage::delete([$this->post->image]);
            $this->post->image = $this->image->store('public/post');
        } else {
            # code...
        }

        $this->post->save();
        $this->reset(['open_edit', 'image']);
        $this->identificador = rand();
        // $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El post se ha editado correctamente!!!');
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function delete(Post $post)
    {
        $post->delete();
    }
}
