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

            <x-button type="submit" class="btn btn-primary">Uložit</x-button>
        </form>
    </div>

    <script>
        document.getElementById('id_lokality').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const druhReviru = selectedOption.getAttribute('data-druh-reviru');
            document.getElementById('druh_reviru_display').value = druhReviru;
        });
    </script>
</x-app-layout>
