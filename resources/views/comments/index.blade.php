@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    @if ($message = Session::get('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ $message }}
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ $message }}
        </div>
    @endif

    <header class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Comentarios</h1>
        </div>
    </header>

    <!-- Search Form -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <form action="{{ route('commentCRUD.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- User Filter -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Filtrar por usuario
                    </label>
                    <select name="user_id" 
                            id="user_id" 
                            class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Todos los usuarios</option>
                        @if(isset($users))
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Post Filter -->
                <div>
                    <label for="post_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Filtrar por post
                    </label>
                    <select name="post_id" 
                            id="post_id" 
                            class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Todos los posts</option>
                        @if(isset($posts))
                            @foreach($posts as $post)
                                <option value="{{ $post->id }}" {{ request('post_id') == $post->id ? 'selected' : '' }}>
                                    {{ substr($post->content, 0, 50) }}...
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Buscar
                </button>
                
                @if(request()->hasAny(['user_id', 'post_id']))
                    <a href="{{ route('commentCRUD.index') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Limpiar filtros
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Results Count -->
    @if(request()->hasAny(['user_id', 'post_id']))
        <div class="mb-4 text-gray-600">
            <strong>{{ count($comments) }}</strong> comentario(s) encontrado(s)
        </div>
    @endif

    <!-- Comments Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($comments as $comment)
            <x-card-comment :comment="$comment" />
        @empty
            <div class="col-span-full bg-white shadow-md rounded-lg p-8 text-center">
                <p class="text-gray-500">No hay comentarios registrados</p>
                @if(request()->hasAny(['user_id', 'post_id']))
                    <a href="{{ route('commentCRUD.index') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-700">
                        Ver todos los comentarios
                    </a>
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection
