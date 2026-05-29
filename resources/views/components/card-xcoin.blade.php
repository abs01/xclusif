<!-- Muestra la información de un Xcoin en particular, en modo Card -->
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        
        <h5 class="mb-2 text-xl font-medium leading-tight">{{ $xcoin->user->name ?? 'N/A' }}</h5>
        {{-- Xcoin quantity --}}
        <p class="mb-4 text-sm">Xcoin: <span class="font-semibold">{{ $xcoin->amount ?? 'N/A' }}</span></p>
        <p class="mb-4 text-base line-clamp-3">{!! Str::limit($xcoin->post->content ?? 'N/A', 100) !!}</p>
        <p class="mb-2 text-sm">by: <span class="font-semibold">{{ $xcoin->post->user->name ?? 'N/A' }}</span></p>
        <p class="mb-4 text-sm">created at: {{ $xcoin->created_at->format('M d, Y H:i') }}</p>

        <!-- Botones de acciones -->
        <a href="{{route('xcoinCRUD.show' , ['xcoinCRUD' => $xcoin->id])}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
       
    </div>
</div>
