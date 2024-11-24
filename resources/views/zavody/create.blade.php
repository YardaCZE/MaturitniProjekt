<x-app-layout>
    <div class="container">
        <h1>Vytvořit nový závod</h1>
    </div>

    <form action="{{ route('zavody.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="mb-3">
            <label for="nazev" class="form-label">Název závodu</label>
            <input type="text" name="nazev" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="lokalita" class="form-label">Lokalita</label>
            <select name="lokalita" id="lokality" class="form-select" required>
                @foreach ($lokality as $lokalita)
                    <option value="{{ $lokalita->id }}">{{ $lokalita->nazev_lokality }}</option>
                @endforeach
                <option value="0">žádná</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="soukromost" class="inline-flex items-center text-gray-700">
                <input type="checkbox" id="soukromost" name="soukromost" value="1" class="form-checkbox text-indigo-600" />
                <span class="ml-2">Závod je soukromý</span>
            </label>
        </div>

        <div class="mb-4">
            <label for="datum_zahajeni">Datum a čas zahájení</label>
            <input type="datetime-local" id="datum_zahajeni" name="datum_zahajeni">
        </div>

        <div class="mb-4">
            <label for="datum_ukonceni">Datum a čas ukončení</label>
            <input type="datetime-local" id="datum_ukonceni" name="datum_ukonceni">
        </div>

        <x-button type="submit" class="btn btn-primary">Založit</x-button>


    </form>

</x-app-layout>
