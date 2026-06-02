@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Crear Patrocinador</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <strong>Por favor revisa los errores:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('sponsorCRUD.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="company_name" class="block text-gray-700 text-sm font-bold mb-2">
                    Nombre de Empresa <span class="text-red-500">*</span>
                </label>
                <input type="text" id="company_name" name="company_name" 
                    value="{{ old('company_name') }}"
                    class="w-full px-3 py-2 border @error('company_name') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:border-blue-500"
                    placeholder="Nombre de la empresa" required>
                @error('company_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">
                    Contenido <span class="text-red-500">*</span>
                </label>
                <textarea id="content" name="content" rows="5"
                    class="w-full px-3 py-2 border @error('content') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:border-blue-500"
                    placeholder="Descripción del patrocinador" required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="file_path" class="block text-gray-700 text-sm font-bold mb-2">
                    Imagen de Publicidad
                </label>
                <input type="file" id="file_path" name="file_path" accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <p class="text-gray-600 text-xs mt-1">Formatos permitidos: JPG, PNG, GIF, WebP</p>
                @error('file_path')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="publicity_url" class="block text-gray-700 text-sm font-bold mb-2">
                    URL de Publicidad
                </label>
                <input type="url" id="publicity_url" name="publicity_url" 
                    value="{{ old('publicity_url') }}"
                    class="w-full px-3 py-2 border @error('publicity_url') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:border-blue-500"
                    placeholder="https://ejemplo.com">
                @error('publicity_url')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="is_active" class="flex items-center gap-3">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                    <span class="text-gray-700 font-bold">Activo</span>
                </label>
                @error('is_active')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Crear Patrocinador
                </button>
                <a href="{{ route('sponsorCRUD.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded text-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
