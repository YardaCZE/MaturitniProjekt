<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 flex justify-center">
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('zavody.create') }}" class="flex-1 sm:flex-initial">
                        <button class="w-full bg-primarni hover:bg-primarniDarker text-white font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                            Nový závod
                        </button>
                    </a>
                    <a href="{{ route('ulovky.create') }}" class="flex-1 sm:flex-initial">
                        <button class="w-full bg-primarni hover:bg-primarniDarker text-white font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                            Nový úlovek
                        </button>
                    </a>
                    <a href="{{ route('skupiny.create') }}" class="flex-1 sm:flex-initial">
                        <button class="w-full bg-primarni hover:bg-primarniDarker text-white font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                            Nová skupina
                        </button>
                    </a>
                </div>
            </div>

            <!-- 3 nejnovější úlovky -->
            <h2 class="text-3xl font-bold mb-4 flex justify-center">Nejnovější úlovky</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
                @foreach($nejnovejsiUlovky as $ulovek)
                    <div class=" text-white shadow-md rounded-lg p-4">
                        <a class="text-primarni" href="{{ route('ulovky.detail', $ulovek->id) }}">
                            @if($ulovek->obrazky->isNotEmpty())
                                <img src="{{ asset('storage/' . $ulovek->obrazky->first()->cesta_k_obrazku) }}" alt="Obrázek úlovku" class="w-full h-40 object-cover rounded">
                            @else
                                <img src="{{ asset('storage/images/default-fish3.png') }}" alt="Výchozí obrázek ryby" class="w-full h-40 object-cover rounded">
                            @endif
                            <h3 class="text-lg font-semibold mt-2">{{ $ulovek->druh_ryby }}</h3>
                                <div class="flex justify-between mt-2">
                                    <p>{{ $ulovek->delka }} cm</p>
                                    <p>{{ $ulovek->vaha }} kg</p>
                                    <p>{{ $ulovek->uzivatel->name }}</p>
                                </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- 3 nejdelší úlovky -->
            <h2 class="text-3xl font-bold mt-8 mb-4 flex justify-center">Nejdelší úlovky</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($nejdelsiUlovky as $ulovek)
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <a class="text-primarni" href="{{ route('ulovky.detail', $ulovek->id) }}">
                            @if($ulovek->obrazky->isNotEmpty())
                                <img src="{{ asset('storage/' . $ulovek->obrazky->first()->cesta_k_obrazku) }}" alt="Obrázek úlovku" class="w-full h-40 object-cover rounded">
                            @else
                                <img src="{{ asset('storage/images/default-fish3.png') }}" alt="Výchozí obrázek ryby" class="w-full h-40 object-cover rounded">
                            @endif
                            <h3 class="text-lg font-semibold mt-2">{{ $ulovek->druh_ryby }}</h3>
                                <div class="flex justify-between mt-2">
                                    <p>{{ $ulovek->delka }} cm</p>
                                    <p>{{ $ulovek->vaha }} kg</p>
                                    <p>{{ $ulovek->uzivatel->name }}</p>
                                </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
