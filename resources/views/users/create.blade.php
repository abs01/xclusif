@extends('layouts.app')

@section('content')
        <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h1 class="text-2xl font-bold">Create User</h1>
                    </div>
                 </header>
<div class="container mx-auto py-8">

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('userCRUD.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-10xl">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="name" type="text" name="name" value="{{ old('name') }}" >
        </div>
     <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="lastname">
                Last Name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="lastname" type="text" name="lastname" value="{{ old('lastname') }}">

        </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="dni">
                DNI
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="dni" type="text" name="dni" value="{{ old('dni') }}" >
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Email
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="email" type="email" name="email" value="{{ old('email') }}" >
        </div>


        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="role_id">
                Role
            </label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="role_id" name="role_id" >
                <option value="">Select a role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="tier_id">
                    Tier
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="tier_id" name="tier_id" >
                    <option value="">Select a tier</option>
                    @foreach($tiers as $tier)
                        <option value="{{ $tier->id }}" {{ old('tier_id') == $tier->id ? 'selected' : '' }}>
                            {{ $tier->name }}
                        </option>
                    @endforeach
                </select>

   
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="password" type="password" name="password" >
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                Confirm Password
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="password_confirmation" type="password" name="password_confirmation" >
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                    type="submit">
                Create User
            </button>
          
        </div>
    </form>
</div>
@endsection

