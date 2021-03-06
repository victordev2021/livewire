<div>
    <x-jet-danger-button wire:click="$set('open',true)">
        Crear nuevo post
    </x-jet-danger-button>
    {{-- ventana modal --}}
    <x-jet-dialog-modal wire:model='open'>
        <x-slot name="title">
            Crear nuevo post
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

            @endif
            <div class="mb-4">
                <x-jet-label value="Título del post" />
                <x-jet-input wire:model="title" type="text" class="w-full" placeholder="Título del post" />
                <x-jet-input-error for="title" />
            </div>
            {{ $content }}
            <div wire:ignore class="mb-4">
                <x-jet-label value="Contenido del post" />
                <textarea wire:model.defer="content" class="form-control w-full" name="" rows="6"
                    id="editor"></textarea>
                <x-jet-input-error for="content" />
            </div>
            <div>
                <input wire:model="image" type="file" name="" id="{{ $identificador }}">
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
    @push('js')
        <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(function(editor) {
                    editor.model.document.on('change:data', () => {
                        @this.set('content', editor.getData())
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush
</div>
