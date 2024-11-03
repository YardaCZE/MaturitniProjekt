@foreach($odpovedi as $odpoved)
    <div class="ml-6 mt-4 border-b py-4">
        <p class="font-semibold text-gray-700">{{ $odpoved->uzivatel->name }}:</p>
        <p class="text-gray-600">{{ $odpoved->text }}</p>
        <x-button onclick="setReplyId({{ $odpoved->id }})" class="text-blue-500 mt-2">Reagovat</x-button>

        @if($odpoved->odpovedi->isNotEmpty())
            @include('partials.comments', ['odpovedi' => $odpoved->odpovedi])
        @endif
    </div>
@endforeach
