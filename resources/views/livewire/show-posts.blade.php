<div wire:init='loadPosts'>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    {{-- tabla posts --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- component -->
        {{-- <body class="antialiased font-sans bg-gray-200">
        </body> --}}
        <x-table>
            {{-- {{ $search }} --}}
            {{-- slot --}}
            @if (count($posts) > 0)
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th wire:click="order('id')"
                                class="w-24 cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                id
                                {{-- sort --}}
                                @if ($sort == 'id')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-1"></i>
                                @endif
                            </th>
                            <th wire:click="order('title')"
                                class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                título
                                {{-- sort --}}
                                @if ($sort == 'title')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-1"></i>
                                @endif
                            </th>
                            <th wire:click="order('content')"
                                class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                contenido
                                {{-- sort --}}
                                @if ($sort == 'content')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-1"></i>
                                @endif
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $item)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $item->id }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ $item->title }}
                                    </p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ $item->content }}
                                    </p>
                                </td>
                                <td class="flex px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <a wire:click="edit({{ $item }})" class="btn btn-green">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a wire:click="$emit('deletePost',{{ $item->id }})" class="btn btn-red ml-2">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    {{-- @livewire('edit-post', ['post' => $post], key($post->id)) --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($posts->hasPages())
                    <div class="px-6 py-3">
                        {{ $posts->links() }}
                    </div>
                @endif
            @else
                <div class="fa-3x self-center mx-auto">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
            @endif
        </x-table>
        {{-- <p>{{ $posts }}</p> --}}
    </div>
    {{-- modal window --}}
    <x-jet-dialog-modal wire:model='open_edit'>
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
            <x-jet-secondary-button wire:click="$set('open_edit',false)">
                cancelar
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="update" wire:loading.attr="disabled" wire:target="save,image"
                class="disabled:opacity-25">
                guardar
            </x-jet-danger-button>
            {{-- <span wire:loading wire:target="save">cargando...</span> --}}
        </x-slot>
    </x-jet-dialog-modal>
    @push('js')
        <script>
            Livewire.on('deletePost', postId => {
                Swal.fire({
                    title: 'Está segur@ de eliminar este registro?',
                    text: "Los datos eliminados no podrán ser recuperados!",
                    icon: 'Advertencia',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar registro!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('show-posts', 'delete', postId)
                        Swal.fire(
                            'Eliminado!',
                            'El registro ha sido eliminado correctamente.',
                            'success'
                        )
                    }
                })
                // console.log('Evento delete capturado!!!');
            })
        </script>
    @endpush
</div>
