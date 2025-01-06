<x-app-layout>
    <div class="py-12">
        <div class="container mx-auto">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <div class="flex items-center space-x-2">
                    <a href="{{ route('skupiny.show', $prispevek->id_skupiny) }}"
                       class="bg-primarni text-white px-3 py-2 rounded-lg hover:bg-primarniDarker shadow">Zpět do skupiny</a>
                </div>
                <div class="mb-6 text-center">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $prispevek->nadpis }}</h1>
                    <p class="text-gray-500 mt-2"> Autor: {{ $prispevek->autor->name }}</p>
                </div>


                <div class="mb-6">
                    <p class="text-lg text-gray-700 leading-relaxed">{{ $prispevek->text }}</p>
                </div>


                @if($prispevek->obrazky->isNotEmpty())
                    <div class="mb-8">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Obrázky</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($prispevek->obrazky as $obrazek)
                                <div class="relative group cursor-pointer" onclick="showModal('{{ asset('storage/' . $obrazek->cesta_k_obrazku) }}')">
                                    <img src="{{ asset('storage/' . $obrazek->cesta_k_obrazku) }}" alt="Obrázek" class="rounded-lg shadow-md w-full h-48 object-cover">
                                    <div class="absolute inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                        <span class="text-white text-lg font-semibold">Zobrazit</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif


                <div class="text-center mb-10">
                    <x-button onclick="toggleCommentForm()" class="px-6 py-3 bg-primarni hover:bg-primarniDarker text-white rounded shadow">
                        Přidat komentář
                    </x-button>
                </div>

                <!-- Komentáře -->
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Komentáře</h3>
                    @forelse($prispevek->komentare->whereNull('parent_id') as $komentar)
                        <div class="border-b pb-4 mb-4">
                            <div class="flex justify-between">
                                <p class="text-gray-800 font-semibold">{{ $komentar->uzivatel->name }}
                                    <span class="text-sm text-gray-500">({{ $komentar->created_at->format('d.m.Y H:i') }})</span>
                                </p>
                            </div>
                            <p class="text-gray-700 mt-2">{{ $komentar->text }}</p>
                            <x-button onclick="setReplyId({{ $komentar->id }}, '{{ $komentar->uzivatel->name }}')" class="mt-2 bg-primarni text-blue-600">
                                Odpovědět
                            </x-button>

                            @if($komentar->odpovedi->isNotEmpty())
                                <div class="ml-6 mt-4">
                                    @include('partials.comments', ['odpovedi' => $komentar->odpovedi])
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">Zatím zde nejsou žádné komentáře. Buďte první!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="imageModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <img id="modalImage" src="" class="w-full h-auto rounded-lg" alt="Zvětšený obrázek">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay pro formulář  -->
    <div id="commentFormOverlay" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white w-full sm:w-3/4 lg:w-1/2 p-8 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold mb-4">Přidat komentář</h3>
            <form action="{{ route('prispevky.komentar', $prispevek->id) }}" method="POST">
                @csrf
                <textarea name="text" class="form-control mb-4" placeholder="Napište svůj komentář..." required></textarea>
                <input type="hidden" name="parent_id" id="parent_id" value="">
                <div class="flex justify-between">
                    <button type="button" onclick="toggleCommentForm()" class="btn btn-outline-secondary">Zrušit</button>
                    <x-button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white">
                        Odeslat
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            $('#imageModal').modal('show');
        }

        function toggleCommentForm() {
            document.getElementById('commentFormOverlay').classList.toggle('hidden');
        }

        function setReplyId(parentId, userName) {
            document.getElementById('parent_id').value = parentId;
            document.querySelector('textarea[name="text"]').value = `@${userName} `;
            toggleCommentForm();
        }
    </script>
</x-app-layout>
