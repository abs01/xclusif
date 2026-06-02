@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">

    <div class="bg-white shadow-md rounded-lg p-8 mt-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Usuario</h2>
            <p class="text-gray-700">
                @if($xcoinCRUD->user)
                    <a href="{{ route('userCRUD.show', $xcoinCRUD->user->id) }}" class="text-blue-500 hover:underline">
                        {{ $xcoinCRUD->user->name }} ({{ $xcoinCRUD->user->email }})
                    </a>
                @else
                    <span class="text-gray-500">N/A</span>
                @endif
            </p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Post</h2>
            <p class="text-gray-700">
                @if($xcoinCRUD->post)
                    <a href="{{ route('postCRUD.show', $xcoinCRUD->post->id) }}" class="text-blue-500 hover:underline">
                        {{ substr($xcoinCRUD->post->content, 0, 100) }}...
                    </a>
                @else
                    <span class="text-gray-500">N/A</span>
                @endif
            </p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <h3 class="text-sm font-semibold text-gray-600">Fecha de Creación</h3>
                <p class="text-gray-900">{{ $xcoinCRUD->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-600">Última Actualización</h3>
                <p class="text-gray-900">{{ $xcoinCRUD->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

    </div>
</div>
@endsection
