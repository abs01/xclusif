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

    <!-- Search Form -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <form action="{{ route('postCRUD.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Buscar por contenido
                    </label>
                    <input type="text" 
                           name="search" 
                           id="search" 
                           value="{{ request('search') }}"
                           placeholder="Escribe para buscar..."
                           class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

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
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Buscar
                </button>
                
                @if(request()->hasAny(['search', 'user_id']))
                    <a href="{{ route('postCRUD.index') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Limpiar filtros
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Results Count -->
    @if(request()->hasAny(['search', 'user_id']))
        <div class="mb-4 text-gray-600">
            <strong>{{ $posts->total() }}</strong> post(s) encontrado(s)
        </div>
    @endif

    <!-- Posts Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Usuario</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Contenido</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if($post->user)
                                {{ $post->user->name }}
                            @else
                                <span class="text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ Str::limit($post->content, 50) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $post->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-center text-sm">
                            <a href="{{ route('postCRUD.show', $post) }}" class="text-blue-500 hover:text-blue-700 mr-3">Ver</a>
                            <a href="{{ route('postCRUD.edit', $post) }}" class="text-green-500 hover:text-green-700 mr-3">Editar</a>
                            <form action="{{ route('postCRUD.destroy', $post) }}" method="POST" style="display:inline;" onclick="return confirm('¿Estás seguro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            No se encontraron posts
                            @if(request()->hasAny(['search', 'user_id']))
                                <br>
                                <a href="{{ route('postCRUD.index') }}" class="mt-2 inline-block text-blue-500 hover:text-blue-700">
                                    Ver todos los posts
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $posts->appends(request()->query())->links() }}
    </div>
</div>
@endsection