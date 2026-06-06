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

    

    <!-- Posts List -->
    <div class="grid gap-0 bg-white">
        @each('components.card-xcoin',$xcoins,'xcoin')
 
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $xcoins->appends(request()->query())->links() }}
    </div>
</div>
@endsection