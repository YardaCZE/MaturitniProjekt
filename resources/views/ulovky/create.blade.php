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
                <input type="number" name="vaha" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="id_typu_lovu" class="form-label">Typ lovu</label>
                <select name="id_typu_lovu" class="form-select" required>
                    <!-- Zde byste měli vypsat typy lovu z databáze -->
                    @foreach ($typyLovu as $typ)
                        <option value="{{ $typ->id }}">{{ $typ->druh }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_druhu_reviru">Druh revíru</label>
                <select name="id_druhu_reviru" id="id_druhu_reviru" class="form-control" required>
                    @foreach($druhyReviru as $druh)
                        <option value="{{ $druh->id }}">{{ $druh->druh }}</option>
                    @endforeach
                </select>
            </div>



            <div class="mb-3">
                <label for="id_lokality" class="form-label">Lokality</label>
                <select name="id_lokality" class="form-select" required>
                    <!-- Zde byste měli vypsat lokality z databáze -->
                    @foreach ($lokality as $lokalita)
                        <option value="{{ $lokalita->id }}">{{ $lokalita->nazev_lokality }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Nahrát obrázky</label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>

            <x-button type="submit" class="btn btn-primary">Uložit</x-button>
        </form>
    </div>
</x-app-layout>
