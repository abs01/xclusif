@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
         <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h1 class="text-2xl font-bold">Show Post: {{ $postCRUD->name }}</h1>
                    </div>
    </header>

    <div class="flex justify-between items-center mb-6">
   
    </div>

    <x-card-post :post="$postCRUD" />
</div>
@endsection
