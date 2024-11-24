<x-app-layout>
    <h1>Přidat závodníka do závodu: {{ $zavod->nazev }}</h1>

    <form action="{{ route('zavody.storeZavodnik', $zavod->id) }}" method="POST">
        @csrf
        <div>
            <label for="jmeno">Jméno</label>
            <input type="text" name="jmeno" id="jmeno" value="{{ old('jmeno') }}">
        </div>
        <div>
            <label for="prijmeni">Příjmení</label>
            <input type="text" name="prijmeni" id="prijmeni" value="{{ old('prijmeni') }}">
        </div>
        <div>
            <label for="narozeni">Datum narození</label>
            <input type="date" name="narozeni" id="narozeni" value="{{ old('narozeni') }}">
        </div>
        <button type="submit">Přidat závodníka</button>
    </form>
</x-app-layout>
