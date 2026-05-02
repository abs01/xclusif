@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold">Post Details</h1>
        </div>
    </header>

    <div class="bg-white shadow-md rounded-lg p-8 mt-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Usuario</h2>
            <p class="text-gray-700">
                @if($postCRUD->user)
                    {{ $postCRUD->user->name }} ({{ $postCRUD->user->email }})
                @else
                    <span class="text-gray-500">N/A</span>
                @endif
            </p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Contenido</h2>
            <p class="text-gray-700 whitespace-pre-wrap">{{ $postCRUD->content }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <h3 class="text-sm font-semibold text-gray-600">Fecha de Creación</h3>
                <p class="text-gray-900">{{ $postCRUD->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-600">Última Actualización</h3>
                <p class="text-gray-900">{{ $postCRUD->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('postCRUD.edit', $postCRUD) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Editar
            </a>
            <form action="{{ route('postCRUD.destroy', $postCRUD) }}" method="POST" style="display:inline;" onclick="return confirm('¿Estás seguro?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Eliminar
                </button>
            </form>
            <a href="{{ route('postCRUD.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </div>
</div>
@endsection
