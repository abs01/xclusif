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
            <h1 class="text-2xl font-bold">Xcoins by post</h1>
        </div>
    </header>




  <div class="grid gap-0 bg-white">        
    
    @forelse($xcoins as $xcoin)
            @each('components.card-xcoin',$xcoins,'xcoin');
        @empty
            <div class="bg-white shadow-md rounded-lg p-8 text-center">

                <p class="mt-4 text-gray-500">No se encontraron xcoins</p>
                @if(request()->hasAny(['search', 'role_id', 'status']))
                    <a href="{{ route('xcoinCRUD.index') }}" class="mt-2 inline-block text-blue-500 hover:text-blue-700">
                        Ver todos los xcoins
                    </a>
                @endif
            </div>
    @endforelse
</div>

    <!-- Pagination -->
    {{-- <div class="mt-6">
        {{ $likes->appends(request()->query())->links() }}
    </div> --}}
</div>
@endsection
