@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
  




  <div class="grid gap-0 bg-white">        
    
    @forelse($likes as $like)
            @each('components.card-like',$likes,'like');
        @empty
            <div class="bg-white shadow-md rounded-lg p-8 text-center">

                <p class="mt-4 text-gray-500">No se encontraron likes</p>
                @if(request()->hasAny(['search', 'role_id', 'status']))
                    <a href="{{ route('likeCRUD.index') }}" class="mt-2 inline-block text-blue-500 hover:text-blue-700">
                        Ver todos los likes
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
