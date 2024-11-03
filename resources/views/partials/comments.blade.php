@foreach($odpovedi as $odpoved)
    <div class="ml-6 mt-4 border-b py-4">
        <div class="flex justify-between items-center">
            <p class="font-semibold text-gray-700">
                {{ $odpoved->uzivatel->name }}:
                <span class="text-gray-500 text-sm">
                    @if($odpoved->parent && $odpoved->parent->uzivatel)
                        @if($odpoved->parent->uzivatel)
                            @php $parentName = $odpoved->parent->uzivatel->name @endphp
                            @if($parentName)
                                @if($loop->first)
                                    <span class="italic">Odpověď na: @{{ $parentName }}</span>
                                @endif
                            @endif
                        @endif
                    @endif
                </span>
            </p>
            <span class="text-gray-500 text-sm">({{ $odpoved->created_at->format('d.m.Y H:i') }})</span>
        </div>
        <p class="text-gray-600 mt-1">{{ $odpoved->text }}</p>
        <x-button onclick="setReplyId({{ $odpoved->id }}, '{{ $odpoved->uzivatel->name }}')" class="text-blue-500 mt-2">Reagovat</x-button>

        @if($odpoved->odpovedi->isNotEmpty())
            @include('partials.comments', ['odpovedi' => $odpoved->odpovedi])
        @endif
    </div>
@endforeach
