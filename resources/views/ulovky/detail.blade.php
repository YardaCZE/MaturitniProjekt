<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="container mx-auto">
            <div class="card shadow-lg p-5 bg-white rounded-lg">
                @if(auth()->user()->isAdmin() || auth()->user()->id === $ulovek->id_uzivatele)
                    <form action="{{ route('ulovky.destroy', $ulovek->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-pozor text-white px-3 py-2 rounded-lg shadow hover:bg-red-600"
                                onclick="return confirm('Opravdu chcete smazat tento úlovek?')">Smazat</button>
                    </form>
                @endif

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
                        <div id="custom-controls-gallery" class="relative w-full" data-carousel="slide">
                            <!-- Carousel wrapper -->
                            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                <!-- Item 1 -->
                                @foreach($ulovek->obrazky as $obrazek)
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        <img src="{{ asset($obrazek->cesta_k_obrazku) }}" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="obrazek">
                                    </div>
                                @endforeach


                                <!-- Modal for larger image -->
                                @foreach($ulovek->obrazky as $obrazek)
                                    <div class="modal fade" id="imageModal{{ $obrazek->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $obrazek->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ asset($obrazek->cesta_k_obrazku) }}" class="w-full h-auto" alt="obrazek">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Show navigation buttons only if more than 1 image -->
                            @if($ulovek->obrazky->count() > 1)
                                <div class="flex justify-center items-center pt-4">
                                    <button type="button" class="flex justify-center items-center me-4 h-full cursor-pointer group focus:outline-none" data-carousel-prev>
                    <span class="text-gray-400 hover:text-gray-900 dark:hover:text-white group-focus:text-gray-900 dark:group-focus:text-white">
                        <svg class="rtl:rotate-180 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                                    </button>
                                    <button type="button" class="flex justify-center items-center h-full cursor-pointer group focus:outline-none" data-carousel-next>
                    <span class="text-gray-400 hover:text-gray-900 dark:hover:text-white group-focus:text-gray-900 dark:group-focus:text-white">
                        <svg class="rtl:rotate-180 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                                    </button>
                                </div>
                            @endif
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
