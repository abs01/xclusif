<!-- Muestra la información de un Comentario en particular, en modo Card -->
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        
        <h5 class="mb-2 text-xl font-medium leading-tight">{{ $comment->user->name ?? 'N/A' }}</h5>

        <p class="mb-4 text-sm text-gray-600">en: <span class="font-semibold">{{ substr($comment->post->content ?? 'N/A', 0, 40) }}...</span></p>
        <p class="mb-4 text-base line-clamp-3">{!! Str::limit($comment->content, 100) !!}</p>
        <p class="mb-4 text-sm">created at: {{ $comment->created_at->format('M d, Y H:i') }}</p>

        <!-- Botones de acciones -->
        <a href="{{route('commentCRUD.show' , ['commentCRUD' => $comment->id])}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        <form action="{{route('commentCRUD.destroy' , ['commentCRUD' => $comment->id ])}}" method="POST" class="float-right">
            @method('DELETE')
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('¿Estás seguro?')">Delete</button>
        </form>
    </div>
</div>
