<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-4xl font-semibold text-gray-800 leading-tight">{{ $prispevek->nadpis }}</h1>
                <h2 class="text-2xl font-semibold text-gray-800 leading-tight">{{ $prispevek->text }}</h2>

                <!-- Obrázky -->
                @if($prispevek->obrazky->isNotEmpty())
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-800">Obrázky:</h3>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            @foreach($prispevek->obrazky as $obrazek)
                                <div>
                                    <img src="{{ asset('storage/' . $obrazek->cesta_k_obrazku) }}" alt="Obrázek" class="w-full h-auto rounded-md">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Tlačítko pro zobrazení formuláře komentáře -->
                <x-button onclick="toggleCommentForm()" class="mt-6 px-4 py-2 bg-blue-500 text-white rounded">Komentovat</x-button>

                <!-- Výpis komentářů -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800">Komentáře:</h3>
                    @foreach($prispevek->komentare->whereNull('parent_id') as $komentar)
                        <div class="border-b py-4">
                            <p>{{ $komentar->uzivatel->name }}: {{ $komentar->text }}</p>
                            <x-button onclick="setReplyId({{ $komentar->id }})" class="text-blue-500 mt-2">Reagovat</x-button>

                            <!-- Odpovědi na komentář -->
                            @if($komentar->odpovedi->isNotEmpty())
                                <div class="ml-6 mt-4">
                                    @foreach($komentar->odpovedi as $odpoved)
                                        <p class="border-l pl-4 text-sm text-gray-600">
                                            @if($odpoved->parent && $odpoved->parent->uzivatel)
                                                Odpověď uživateli '{{ $odpoved->parent->uzivatel->name }}':
                                            @endif
                                            {{ $odpoved->uzivatel->name }}: {{ $odpoved->text }}
                                        </p>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modální okno (overlay) pro formulář komentáře -->
    <div id="commentFormOverlay" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-end justify-center">
        <div class="bg-white w-full sm:w-3/4 lg:w-1/2 p-6 rounded-t-lg">
            <h3 class="text-xl font-semibold mb-4">Přidat komentář</h3>
            <form action="{{ route('prispevky.komentar', $prispevek->id) }}" method="POST">
                @csrf
                <textarea name="text" class="w-full border rounded p-2 mb-4" placeholder="Napište svůj komentář..." required></textarea>
                <input type="hidden" name="parent_id" id="parent_id" value="">
                <div class="flex justify-between">
                    <x-button type="button" onclick="toggleCommentForm()" class="px-4 py-2 bg-gray-300 text-black rounded">Zrušit</x-button>
                    <x-button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Odeslat</x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript pro zobrazení/skrytí formuláře komentáře -->
    <script>
        function toggleCommentForm() {
            const overlay = document.getElementById('commentFormOverlay');
            overlay.classList.toggle('hidden');
        }

        function setReplyId(id) {
            document.getElementById('parent_id').value = id;
            toggleCommentForm(); // Otevře formulář pro odpověď
        }
    </script>
</x-app-layout>
