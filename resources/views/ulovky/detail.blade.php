<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="container mx-auto">
            <div class="card shadow-lg p-5 bg-white rounded-lg">
                <h1 class="text-3xl font-bold text-gray-800 leading-tight">{{ $ulovek->druh_ryby }}</h1>
                <p class="text-lg text-gray-600 mt-2">Rybář: <span class="font-semibold">{{ $ulovek->uzivatel->name }}</span></p>

                <div class="mt-5">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
                        <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="py-2 px-4 text-left">Délka</th>
                            <th class="py-2 px-4 text-left">Váha</th>
                            <th class="py-2 px-4 text-left">Lokalita</th>
                            <th class="py-2 px-4 text-left">Typ lovu</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-t">{{ $ulovek->delka }}</td>
                            <td class="py-2 px-4 border-t">{{ $ulovek->vaha }}</td>
                            <td class="py-2 px-4 border-t">{{ $ulovek->lokalita->nazev_lokality ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-t">{{ $ulovek->typLovu->druh ?? 'N/A' }}</td>
                        </tr>
                        </tbody>
                    </table>
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

                <x-button onclick="toggleCommentForm()" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg shadow">Komentovat</x-button>

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
