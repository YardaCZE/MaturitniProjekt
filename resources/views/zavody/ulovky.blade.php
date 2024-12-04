<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Úlovky závodníka</h1>

        @if ($ulovky->isEmpty())
            <p class="text-gray-600">Tento závodník zatím žádné úlovky nezaznamenal.</p>
        @else
            <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Druh ryby</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Délka (cm)</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Váha (kg)</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Body</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($ulovky as $ulovek)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $ulovek->druh_ryby }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $ulovek->delka ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $ulovek->vaha ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $ulovek->body }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        <a href="{{ route('zavody.detail', $zavod->id) }}" class="text-white">
            <x-button>
                zpět na přehled
            </x-button>
        </a>
    </div>
</x-app-layout>
