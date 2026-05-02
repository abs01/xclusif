@extends('layouts.app')

@section('content')
<div class="w-full py-8">
    <header class="bg-white shadow">
        <div class="w-full py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold">Edit Post</h1>
        </div>
    </header>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 mx-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('postCRUD.update', $postCRUD) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="user_id">
                User
            </label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="user_id" name="user_id" >
                <option value="">Select a user</option>
                @if(isset($users))
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $postCRUD->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="content">
                Content
            </label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                      id="content" name="content" rows="6">{{ old('content', $postCRUD->content) }}</textarea>
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                    type="submit">
                Update Post
            </button>
        </div>
    </form>
</div>
@endsection