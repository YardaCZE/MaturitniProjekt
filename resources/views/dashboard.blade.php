<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6">Vítej na Dashboardu!</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


            <h2 class="text-xl font-semibold">Chceš vytvořit nový závod?</h2>
            <div class="flex justify-end mb-6">
                <a href="{{ route('zavody.create') }}">
                    <button class="bg-[#47663B] hover:bg-[#1F4529] text-[#E8ECD7] font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                        Nový závod
                    </button>
                </a>
            </div>
    <br>
                <h2 class="text-xl font-semibold">Chceš zaznamenat ulovenou rybu?</h2>
                <div class="flex justify-end mb-6">
                    <a href="{{ route('ulovky.create') }}">
                        <button class="bg-[#47663B] hover:bg-[#1F4529] text-[#E8ECD7] font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                            Nový úlovek
                        </button>
                    </a>
                </div>

                </div>

            <br>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Největší úlovky -->
                <div class="bg-white shadow-md rounded p-4">
                    <h2 class="text-xl font-semibold">3 Největší úlovky</h2>
                    @if($nejvetsiUlovky->isEmpty())
                        <p class="text-gray-500">Za posledních 24 hodin nebyla zaznamenána žádná ryba.</p>
                    @else
                        <ul>
                            @foreach($nejvetsiUlovky as $ulovek)
                                <a href="{{ route('ulovky.detail', $ulovek->id) }}" >
                                <li>{{ $ulovek->druh_ryby }} - {{$ulovek->delka }} cm</li>
                                    </a>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Nejlajkovanější úlovky -->
                <div class="bg-white shadow-md rounded p-4">
                    <h2 class="text-xl font-semibold">3 Nejlajkovanější úlovky za posledních 24h</h2>
                    @if($nejlajkovanejsiUlovky->isEmpty())
                        <p class="text-gray-500">Za posledních 24 hodin nebyla zaznamenána žádná ryba.</p>
                    @else
                        <ul>
                            @foreach($nejlajkovanejsiUlovky as $ulovek)
                                <a href="{{ route('ulovky.detail', $ulovek->id) }}" >
                                <li>{{ $ulovek->druh_ryby }} - {{ $ulovek->likes_count }} lajků</li>
                                </a>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
