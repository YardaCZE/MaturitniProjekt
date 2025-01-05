<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <h2 class="text-xl font-semibold">Chceš vytvořit nový závod?</h2>
                <a href="{{ route('zavody.create') }}">
                    <button class="bg-[#47663B] hover:bg-[#1F4529] text-[#E8ECD7] font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                        Nový závod
                    </button>
                </a>

            <h2 class="text-xl font-semibold">Chceš zaznamenat ulovenou rybu?</h2>

                <a href="{{ route('ulovky.create') }}">
                    <button class="bg-[#47663B] hover:bg-[#1F4529] text-[#E8ECD7] font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                        Nový úlovek
                    </button>
                </a>



            <!-- 3 nejnovější úlovky -->
            <h2 class="text-xl font-semibold mb-4">Nejnovější úlovky</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($nejnovejsiUlovky as $ulovek)
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <a href="{{ route('ulovky.detail', $ulovek->id) }}">
                            @if($ulovek->obrazky->isNotEmpty())
                                <img src="{{ asset('storage/' . $ulovek->obrazky->first()->cesta_k_obrazku) }}" alt="Obrázek úlovku" class="w-full h-40 object-cover rounded">
                            @else
                                <img src="{{ asset('storage/images/default-fish.jpg') }}" alt="Výchozí obrázek ryby" class="w-full h-40 object-cover rounded">
                            @endif
                            <h3 class="text-lg font-semibold mt-2">{{ $ulovek->druh_ryby }}</h3>
                            <p class="text-gray-600">{{ $ulovek->delka }} cm</p>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- 3 nejdelší úlovky -->
            <h2 class="text-xl font-semibold mt-8 mb-4">Nejdelší úlovky</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($nejdelsiUlovky as $ulovek)
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <a href="{{ route('ulovky.detail', $ulovek->id) }}">
                            @if($ulovek->obrazky->isNotEmpty())
                                <img src="{{ asset('storage/' . $ulovek->obrazky->first()->cesta_k_obrazku) }}" alt="Obrázek úlovku" class="w-full h-40 object-cover rounded">
                            @else
                                <img src="{{ asset('storage/images/default-fish.jpg') }}" alt="Výchozí obrázek ryby" class="w-full h-40 object-cover rounded">
                            @endif
                            <h3 class="text-lg font-semibold mt-2">{{ $ulovek->druh_ryby }}</h3>
                            <p class="text-gray-600">{{ $ulovek->delka }} cm</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </>
    </div>
</x-app-layout>
