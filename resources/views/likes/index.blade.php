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
            <h1 class="text-2xl font-bold">Likes</h1>
        </div>
    </header>




    <!-- Likes Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($likes as $like)
            <x-card-like :like="$like" />
        @empty
            <div class="col-span-full bg-white shadow-md rounded-lg p-8 text-center">
                <p class="text-gray-500">No hay likes registrados</p>
                @if(request()->hasAny(['user_id', 'post_id']))
                    <a href="{{ route('likeCRUD.index') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-700">
                        Ver todos los likes
                    </a>
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection
