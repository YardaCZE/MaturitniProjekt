<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg p-8">
                <h1 class="text-2xl font-bold text-gray-800 leading-tight">{{ $prispevek->nadpis }}</h1>
                <p class="text-lg text-gray-700 mt-4">{{ $prispevek->text }}</p>

                @if($prispevek->obrazky->isNotEmpty())
                    <div class="mt-8 relative">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Obrázky:</h3>
                        <div id="carouselExample" class="relative w-full" data-carousel="slide">
                            <div class="carousel-inner relative w-full overflow-hidden rounded-lg shadow-md">
                                @foreach($prispevek->obrazky as $index => $obrazek)
                                    <div class="carousel-item {{ $index === 0 ? 'block' : 'hidden' }} duration-700 ease-in-out" data-carousel-item>
                                        <img src="{{ asset('storage/' . $obrazek->cesta_k_obrazku) }}" alt="Obrázek {{ $index + 1 }}" class="w-full h-auto object-cover rounded-lg">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Carousel Controls -->
                            <x-button class="absolute top-1/2 left-2 transform -translate-y-1/2 z-30" onclick="prevSlide()">
                                <span class="text-white">&larr;</span>
                            </x-button>
                            <x-button class="absolute top-1/2 right-2 transform -translate-y-1/2 z-30" onclick="nextSlide()">
                                <span class="text-white">&rarr;</span>
                            </x-button>
                        </div>
                    </div>
                @endif

                <x-button onclick="toggleCommentForm()" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded shadow">Komentovat</x-button>

                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-800">Komentáře:</h3>
                    @foreach($prispevek->komentare->whereNull('parent_id') as $komentar)
                        <div class="border-b py-4">
                            <p class="font-semibold text-gray-700">{{ $komentar->uzivatel->name }}:</p>
                            <p class="text-gray-600">{{ $komentar->text }}</p>
                            <x-button onclick="setReplyId({{ $komentar->id }})" class="text-blue-500 mt-2">Reagovat</x-button>

                            @if($komentar->odpovedi->isNotEmpty())
                                <div class="ml-6 mt-4">
                                    @foreach($komentar->odpovedi as $odpoved)
                                        <p class="border-l pl-4 text-sm text-gray-500">
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

    <div id="commentFormOverlay" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white w-full sm:w-3/4 lg:w-1/2 p-8 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold mb-4">Přidat komentář</h3>
            <form action="{{ route('prispevky.komentar', $prispevek->id) }}" method="POST">
                @csrf
                <textarea name="text" class="w-full border rounded p-4 mb-4 text-gray-700" placeholder="Napište svůj komentář..." required></textarea>
                <input type="hidden" name="parent_id" id="parent_id" value="">
                <div class="flex justify-between">
                    <x-button type="button" onclick="toggleCommentForm()" class="px-4 py-2 bg-gray-300 text-black rounded">Zrušit</x-button>
                    <x-button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Odeslat</x-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentSlide = 0;

        function showSlide(index) {
            const items = document.querySelectorAll('[data-carousel-item]');
            items.forEach((item, i) => {
                item.classList.toggle('block', i === index);
                item.classList.toggle('hidden', i !== index);
            });
        }

        function nextSlide() {
            const items = document.querySelectorAll('[data-carousel-item]');
            currentSlide = (currentSlide + 1) % items.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            const items = document.querySelectorAll('[data-carousel-item]');
            currentSlide = (currentSlide - 1 + items.length) % items.length;
            showSlide(currentSlide);
        }

        function toggleCommentForm() {
            const overlay = document.getElementById('commentFormOverlay');
            overlay.classList.toggle('hidden');
        }

        function setReplyId(id) {
            document.getElementById('parent_id').value = id;
            toggleCommentForm();
        }
    </script>
    <script src="{{ asset('js/flowbite.min.js') }}"></script>
</x-app-layout>
