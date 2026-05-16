@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold">Detalles del Earning</h1>
        </div>
    </header>

    <div class="bg-white shadow-md rounded-lg p-8 mt-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Usuario</h2>
            <p class="text-gray-700">
                @if($earnings->user)
                    <a href="{{ route('userCRUD.show', $earning->user->id) }}" class="text-blue-500 hover:underline">
                        {{ $earning->user->name }} ({{ $earning->user->email }})
                    </a>
                @else
                    <span class="text-gray-500">N/A</span>
                @endif
            </p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Post</h2>
            <p class="text-gray-700">
                @if($earnings->post)
                    <a href="{{ route('postCRUD.show', $earnings->post->id) }}" class="text-blue-500 hover:underline">
                        {{ substr($earnings->post->content, 0, 100) }}...
                    </a>
                @else
                    <span class="text-gray-500">N/A</span>
                @endif
            </p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <h3 class="text-sm font-semibold text-gray-600">Fecha de Creación</h3>
                <p class="text-gray-900">{{ $earnings->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-600">Última Actualización</h3>
                <p class="text-gray-900">{{ $earnings->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

    </div>
</div>
@endsection
