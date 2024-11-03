<x-app-layout>
    <div class="py-12">
        <div class="container">
            <div class="card shadow-lg p-5">
                <h1 class="text-2xl font-bold text-gray-800 leading-tight">{{ $prispevek->nadpis }}</h1>
                <p class="text-lg text-gray-700 mt-4">{{ $prispevek->text }}</p>

                @if($prispevek->obrazky->isNotEmpty())
                    <div class="mt-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Obrázky:</h3>
                        <div class="d-flex flex-wrap justify-content-center">
                            @foreach($prispevek->obrazky as $obrazek)
                                <div class="m-2" style="width: 200px; height: 150px; overflow: hidden; border-radius: 10px; cursor: pointer;"
                                     onclick="showModal('{{ asset('storage/' . $obrazek->cesta_k_obrazku) }}')">
                                    <img src="{{ asset('storage/' . $obrazek->cesta_k_obrazku) }}" alt="Obrázek" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <x-button onclick="toggleCommentForm()" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded shadow">Komentovat</x-button>

                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-800">Komentáře:</h3>
                    @foreach($prispevek->komentare->whereNull('parent_id') as $komentar)
                        <div class="border-b py-4">
                            <div class="flex justify-between items-center">
                                <p class="font-semibold text-gray-700">{{ $komentar->uzivatel->name }} <span class="text-gray-500 text-sm">({{ $komentar->created_at->format('d.m.Y H:i') }})</span>:</p>
                            </div>
                            <p class="text-gray-600 mt-1">{{ $komentar->text }}</p>
                            <x-button onclick="setReplyId({{ $komentar->id }}, '{{ $komentar->uzivatel->name }}')" class="text-blue-500 mt-2">Reagovat</x-button>

                            @if($komentar->odpovedi->isNotEmpty())
                                <div class="ml-6 mt-4">
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
            <form action="{{ route('prispevky.komentar', $prispevek->id) }}" method="POST">
                @csrf
                <textarea name="text" class="form-control mb-4" placeholder="Napište svůj komentář..." required></textarea>
                <input type="hidden" name="parent_id" id="parent_id" value="">
                <div class="d-flex justify-between">
                    <button type="button" onclick="toggleCommentForm()" class="btn btn-outline-secondary mr-2">Zrušit</button>
                    <x-button type="submit" class="btn btn-primary">Odeslat</x-button>
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
