<div>
    <a wire:click="$set('open',true)" class="btn btn-green">
        <i class="fas fa-edit"></i>
    </a>
    {{-- ventana modal --}}
    <x-jet-dialog-modal wire:model='open'>
        <x-slot name="title">
            Editar post {{ $post->title }}
        </x-slot>
        <x-slot name="content">
            <div wire:loading wire:target="image"
                class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Imagen cargando!</strong>
                <span class="block sm:inline">Por favor espere hasta que la imagen se haya procesado.</span>
            </div>
            @if ($image)
                <img class="mb-4" src="{{ $image->temporaryUrl() }}" alt="" srcset="">
            @else
                <img src="{{ Storage::url($post->image) }}" alt="" srcset="">
            @endif
            <div class="mb-4">
                <x-jet-label value="Título del post" />
                <x-jet-input wire:model="post.title" type="text" class="w-full" placeholder="Título del post" />
                <x-jet-input-error for="title" />
            </div>
            <div class="mb-4">
                <x-jet-label value="Contenido del post" />
                <textarea wire:model.defer="post.content" class="form-control w-full" name="" rows="6"></textarea>
                <x-jet-input-error for="content" />
            </div>
            <div>
                <input wire:model="image" type="file" name="" id="">
                <x-jet-input-error for="image" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open',false)">
                cancelar
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save,image"
                class="disabled:opacity-25">
                guardar
            </x-jet-danger-button>
            {{-- <span wire:loading wire:target="save">cargando...</span> --}}
        </x-slot>
    </x-jet-dialog-modal>
</div>
