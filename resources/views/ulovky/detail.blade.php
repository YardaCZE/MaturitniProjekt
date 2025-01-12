<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="container mx-auto">
            <div class="card shadow-lg p-5 bg-white rounded-lg">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $ulovek->druh_ryby }}</h1>
                    <p class="text-lg text-gray-600">Rybář: <span class="font-semibold">{{ $ulovek->uzivatel->name }}</span></p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                        <h4 class="font-semibold text-gray-700">Délka</h4>
                        <p class="text-gray-600">{{ $ulovek->delka }} cm</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                        <h4 class="font-semibold text-gray-700">Váha</h4>
                        <p class="text-gray-600">{{ $ulovek->vaha }} kg</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                        <h4 class="font-semibold text-gray-700">Lokalita</h4>
                        <p class="text-gray-600">{{ $ulovek->lokalita->nazev_lokality ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                        <h4 class="font-semibold text-gray-700">Typ lovu</h4>
                        <p class="text-gray-600">{{ $ulovek->typLovu->druh ?? 'N/A' }}</p>
                    </div>
                </div>

                @if($ulovek->obrazky->isNotEmpty())
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Obrázky:</h3>
                        <div class="flex flex-wrap justify-center">
                            @foreach($ulovek->obrazky as $obrazek)
                                <div class="m-2 w-1/4 h-32 overflow-hidden rounded-lg shadow cursor-pointer"
                                     onclick="showModal('{{ asset('storage/' . $obrazek->cesta_k_obrazku) }}')">
                                    <img src="{{ asset('storage/' . $obrazek->cesta_k_obrazku) }}" alt="Obrázek" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Tlačítko pro komentování -->
                <div class="mt-6 text-center">
                    <x-button onclick="toggleCommentForm()" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow">Komentovat</x-button>
                </div>

                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-800">Komentáře:</h3>
                    @foreach($ulovek->komentare()->whereNull('parent_id')->get() as $komentar)
                        <div class="border-b py-4">
                            <div class="flex justify-between items-center">
                                <p class="font-semibold text-gray-700">{{ optional($komentar->uzivatel)->name ?? 'Neznámý uživatel' }} <span class="text-gray-500 text-sm">({{ $komentar->created_at->format('d.m.Y H:i') }})</span>:</p>
                            </div>
                            <p class="text-gray-600 mt-1">{{ $komentar->text }}</p>
                            <x-button onclick="setReplyId({{ $komentar->id }}, '{{ $komentar->uzivatel->name }}')" class="text-blue-500 mt-2">Reagovat</x-button>

                            @if($komentar->odpovedi->isNotEmpty())
                                <div class="ml-6 mt-4 border-l-2 border-gray-300 pl-4">
                                    @include('partials.comments', ['odpovedi' => $komentar->odpovedi])
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pro obrázek -->
    <div id="imageModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="modalImage" src="" class="img-fluid" alt="Zvětšený obrázek">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulář pro komentář -->
    <div id="commentFormOverlay" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white w-full sm:w-3/4 lg:w-1/2 p-8 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold mb-4">Přidat komentář</h3>
            <form action="{{ route('ulovky.komentar', $ulovek->id) }}" method="POST">
                @csrf
                <textarea name="text" class="form-control mb-4 border border-gray-300 rounded-md p-2" placeholder="Napište svůj komentář..." required></textarea>
                <input type="hidden" name="parent_id" id="parent_id" value="">
                <div class="flex justify-between">
                    <button type="button" onclick="toggleCommentForm()" class="btn btn-outline-secondary mr-2">Zrušit</button>
                    <x-button type="submit" class="bg-blue-600 text-white rounded-md py-2 px-4">Odeslat</x-button>
                </div>
            </form>
        </div>
    </div>

    <script>

        function showModal(imageSrc) {
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            $('#imageModal').modal('show');
        }


        function toggleCommentForm() {
            const overlay = document.getElementById('commentFormOverlay');
            overlay.classList.toggle('hidden');
        }


        function setReplyId(parentId, userName) {
            document.getElementById('parent_id').value = parentId;
            const textarea = document.querySelector('textarea[name="text"]');
            textarea.value = `@${userName} `;
            toggleCommentForm();
        }
    </script>
</x-app-layout>
