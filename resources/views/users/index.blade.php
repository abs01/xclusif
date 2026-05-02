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
        <form action="{{ route('userCRUD.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Buscar por nombre, apellido, email, DNI o rol
                    </label>
                    <input type="text" 
                           name="search" 
                           id="search" 
                           value="{{ request('search') }}"
                           placeholder="Escribe para buscar..."
                           class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Role Filter -->
                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Filtrar por rol
                    </label>
                    <select name="role_id" 
                            id="role_id" 
                            class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Todos los roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Estado
                    </label>
                    <select name="status" 
                            id="status" 
                            class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Todos</option>
                        <option value="y" {{ request('status') == 'y' ? 'selected' : '' }}>Activos</option>
                        <option value="n" {{ request('status') == 'n' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Buscar
                </button>
                
                @if(request()->hasAny(['search', 'role_id', 'status']))
                    <a href="{{ route('userCRUD.index') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Limpiar filtros
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Results Count -->
    @if(request()->hasAny(['search', 'role_id', 'status']))
        <div class="mb-4 text-gray-600">
            <strong>{{ $users->total() }}</strong> usuario(s) encontrado(s)
        </div>
    @endif

    <!-- Users Grid -->
<div class="grid gap-0 bg-white">        
    
    @forelse($users as $user)
            @each('components.card-user',$users,'user');
        @empty
            <div class="bg-white shadow-md rounded-lg p-8 text-center">

                <p class="mt-4 text-gray-500">No se encontraron usuarios</p>
                @if(request()->hasAny(['search', 'role_id', 'status']))
                    <a href="{{ route('userCRUD.index') }}" class="mt-2 inline-block text-blue-500 hover:text-blue-700">
                        Ver todos los usuarios
                    </a>
                @endif
            </div>
    @endforelse
</div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection