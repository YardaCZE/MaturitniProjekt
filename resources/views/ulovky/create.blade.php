<x-app-layout>
    <div class="container">
        <h1>Vytvořit nový příspěvek</h1>

        <form action="{{ route('ulovky.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="druh_ryby" class="form-label">Druh ryby</label>
                <input type="text" name="druh_ryby" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="delka" class="form-label">Délka</label>
                <input type="number" name="delka" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="vaha" class="form-label">Váha</label>
                <input type="number" name="vaha" class="form-control" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="id_typu_lovu" class="form-label">Typ lovu</label>
                <select name="id_typu_lovu" class="form-select" required>
                    @foreach ($typyLovu as $typ)
                        <option value="{{ $typ->id }}">{{ $typ->druh }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="id_lokality" class="form-label">Lokalita</label>
                <select name="id_lokality" id="id_lokality" class="form-select" required>
                    @foreach ($lokality as $lokalita)
                        <option value="{{ $lokalita->id }}" data-druh-reviru="{{ $lokalita->druh }}">{{ $lokalita->nazev_lokality }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Druh revíru (automaticky)</label>
                <input type="text" id="druh_reviru_display" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Nahrát obrázky</label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>

            <!-- Checkbox pro soukromí -->
            <div class="mb-4">
                <label for="soukroma" class="inline-flex items-center text-gray-700">
                    <input type="checkbox" id="soukroma" name="soukroma" value="1" class="form-checkbox text-indigo-600" />
                    <span class="ml-2">Úlovek je soukromý</span>
                </label>
            </div>

            <!-- Checkbox pro soukromí pro skupinu a osobu -->
            <div id="soukromi-volby" class="hidden">
                <div class="mb-4">
                    <label for="souk_skup" class="inline-flex items-center text-gray-700">
                        <input type="checkbox" id="souk_skup" name="souk_skup" value="1" class="form-checkbox text-indigo-600" />
                        <span class="ml-2">Úlovek je soukromý pro skupinu</span>
                    </label>
                </div>

                <div id="skupina-select" class="mb-4 hidden">
                    <label for="soukSkupID" class="block text-gray-700 font-medium mb-2">Vyberte skupinu</label>
                    <select name="soukSkupID" id="soukSkupID" class="form-select w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
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

            <x-button type="submit" class="btn btn-primary">Uložit</x-button>
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
