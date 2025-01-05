<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Vytvořit nový příspěvek</h1>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ulovky.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Druh ryby -->
            <div class="mb-4">
                <label for="druh_ryby" class="block text-lg font-medium text-gray-700">Druh ryby</label>
                <input type="text" name="druh_ryby" class="form-input mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Délka -->
            <div class="mb-4">
                <label for="delka" class="block text-lg font-medium text-gray-700">Délka (cm)</label>
                <input type="number" name="delka" class="form-input mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" step="0.01" required>
            </div>

            <!-- Váha -->
            <div class="mb-4">
                <label for="vaha" class="block text-lg font-medium text-gray-700">Váha (kg)</label>
                <input type="number" name="vaha" class="form-input mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" step="0.01" required>
            </div>

            <!-- Typ lovu -->
            <div class="mb-4">
                <label for="id_typu_lovu" class="block text-lg font-medium text-gray-700">Typ lovu</label>
                <select name="id_typu_lovu" class="form-select mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    @foreach ($typyLovu as $typ)
                        <option value="{{ $typ->id }}">{{ $typ->druh }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Lokalita -->
            <div class="mb-4">
                <label for="id_lokality" class="block text-lg font-medium text-gray-700">Lokalita</label>
                <select name="id_lokality" id="id_lokality" class="form-select mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="" disabled selected>Vyberte lokalitu</option>
                    @foreach ($lokality as $lokalita)
                        <option value="{{ $lokalita->id }}" data-druh-reviru="{{ $lokalita->druh }}">{{ $lokalita->nazev_lokality }}</option>
                    @endforeach
                </select>
            </div>

            <!-- druh revíru -->
            <div class="mb-4">
                <label class="block text-lg font-medium text-gray-700">Druh revíru (automaticky)</label>
                <input type="text" id="druh_reviru_display" class="form-input mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" readonly>
            </div>

            <!-- Nahrát obrázky -->
            <div class="mb-4">
                <label for="images" class="block text-lg font-medium text-gray-700">Nahrát obrázky</label>
                <input type="file" name="images[]" class="form-input mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" multiple>
            </div>

            <!-- Checkbox pro soukromí -->
            <div class="mb-4">
                <label for="soukroma" class="inline-flex items-center text-gray-700">
                    <input type="checkbox" id="soukroma" name="soukroma" value="1" class="form-checkbox text-indigo-600" />
                    <span class="ml-2">Úlovek je soukromý</span>
                </label>
            </div>

            <!-- Soukromí volby pro skupinu a osobu -->
            <div id="soukromi-volby" class="hidden mb-4">
                <div class="mb-4">
                    <label for="souk_skup" class="inline-flex items-center text-gray-700">
                        <input type="checkbox" id="souk_skup" name="souk_skup" value="1" class="form-checkbox text-indigo-600" />
                        <span class="ml-2">Úlovek je soukromý pro skupinu</span>
                    </label>
                </div>

                <div id="skupina-select" class="mb-4 hidden">
                    <label for="soukSkupID" class="block text-lg font-medium text-gray-700">Vyberte skupinu</label>
                    <select name="soukSkupID" id="soukSkupID" class="form-select mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Vyberte skupinu</option>
                        @foreach ($vsechnySkupiny as $skupina)
                            <option value="{{ $skupina->id }}">{{ $skupina->nazev_skupiny }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="soukOsob" class="inline-flex items-center text-gray-700">
                        <input type="checkbox" id="soukOsob" name="soukOsob" value="1" class="form-checkbox text-indigo-600" />
                        <span class="ml-2">Úlovek je soukromý pouze pro uživatele</span>
                    </label>
                </div>
            </div>

            <!-- Tlačítko pro odeslání -->
            <x-button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg">Uložit</x-button>
        </form>
    </div>

    <script>
        // Zobrazení/skrytí soukromí volby na základě checkboxu
        document.getElementById('soukroma').addEventListener('change', function() {
            const soukromiVolby = document.getElementById('soukromi-volby');
            soukromiVolby.style.display = this.checked ? 'block' : 'none';
        });

        document.getElementById('souk_skup').addEventListener('change', function() {
            const skupinaSelect = document.getElementById('skupina-select');
            skupinaSelect.style.display = this.checked ? 'block' : 'none';
        });

        document.getElementById('id_lokality').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const druhReviru = selectedOption.getAttribute('data-druh-reviru');
            document.getElementById('druh_reviru_display').value = druhReviru;
        });
    </script>
</x-app-layout>
