<!-- Muestra la información de un Post en particular, en modo Card -->
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        
        <h5 class="mb-2 text-xl font-medium leading-tight">{{ $sponsor->company_name ?? 'N/A' }}</h5>

        <p class="mb-4 text-base line-clamp-3">{!! Str::limit($sponsor->content, 100) !!}</p>
        <p class="mb-4 text-sm">created at: {{ $sponsor->created_at->format('M d, Y H:i') }}</p>
        <p class="mb-4 text-sm">updated at: {{ $sponsor->updated_at->format('M d, Y H:i') }}</p>
         {{-- @if ($sponsor->media)
            <p class="mb-4 text-sm">Imagen asociada al Post: 
                <a href="{{ asset('images/' . $sponsor->media->file_path) }}" class="text-blue-600 hover:text-blue-800 underline">{{ $sponsor->media->first()->file_path }}</a>
            </p>
         @endif --}}
       
        <!-- Botones de acciones -->
        <a href="{{route('sponsorCRUD.show' , ['sponsorCRUD' => $sponsor->id])}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        <a href="{{route('sponsorCRUD.edit' , ['sponsorCRUD' => $sponsor->id ])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="{{route('sponsorCRUD.destroy' , ['sponsorCRUD' => $sponsor->id ])}}" method="POST" class="float-right">
            @method('DELETE')
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('¿Estás seguro?')">Delete</button>
        </form>
    </div>
</div>
