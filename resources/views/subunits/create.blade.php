<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('subunits.store', $truck) }}">
            @csrf
            <label class="form-label block">main truck</label>
            <select class="form-control form-control-lg mb-4 ps-4 block w-full" name='main_truck'>
                <option value="{{$truck->unit_number}}">{{$truck->unit_number}}</option>
            </select>

            <label class="form-label block">subunit</label>
            <select class="form-control form-control-lg mb-4 ps-4 block w-full" name='subunit'>
                <option selected></option>
                @foreach($trucks as $each_truck)
                @if($each_truck->id !== $truck->id)
                <option value="{{$each_truck->unit_number}}">{{$each_truck->unit_number}}</option>
                @endif
                @endforeach
            </select>

            <label class="form-label block">start date</label>
            <input class="form-control form-control-lg mb-4 ps-4 block w-full" type='date' name="start_date" value="{{ old('start_date') }}">

            <label class="form-label block">end date</label>
            <input class="form-control form-control-lg mb-4 ps-4 block w-full" type='date' name="end_date" value="{{ old('end_date') }}">

            {{-- <x-input-error :messages="$errors->get('unit_number')" class="mt-2" />
            <x-input-error :messages="$errors->get('year')" class="mt-2" />
            <x-input-error :messages="$errors->get('notes')" class="mt-2" /> --}}
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('trucks.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
