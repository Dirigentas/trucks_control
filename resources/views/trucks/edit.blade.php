<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('trucks.update', $truck) }}">
            @csrf
            @method('patch')
            <label class="form-label block">Unit number</label>
            <input class="form-control form-control-lg mb-4 ps-4 block w-full" name="unit_number" value="{{ old('unit_number', $truck->unit_number) }}">

            <label class="form-label block">Year</label>
            <input class="form-control form-control-lg mb-4 ps-4 block w-full" name="year" value="{{ old('year', $truck->year) }}">

            <label class="form-label block">Notes</label>
            <textarea name="notes" placeholder="{{ __('For example: “Available for rent”.') }}" class="block w-full">{{ old('notes', $truck->notes) }}</textarea>

            <x-input-error :messages="$errors->get('unit_number')" class="mt-2" />
            <x-input-error :messages="$errors->get('year')" class="mt-2" />
            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('trucks.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
