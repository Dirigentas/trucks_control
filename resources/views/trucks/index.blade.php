<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('trucks.store') }}">
            @csrf
            <label class="form-label block">Unit number</label>
            <input class="form-control form-control-lg mb-4 ps-4 block w-full" name="unit_number" value="{{ old('unit_number') }}">

            <label class="form-label block">Year</label>
            <input class="form-control form-control-lg mb-4 ps-4 block w-full" name="year" value="{{ old('year') }}">

            <label class="form-label block">Notes</label>
            <textarea name="notes" placeholder="{{ __('For example: “Available for rent”.') }}" class="block w-full">{{ old('notes') }}</textarea>

            <x-input-error :messages="$errors->get('unit_number')" class="mt-2" />
            <x-input-error :messages="$errors->get('year')" class="mt-2" />
            <x-input-error :messages="$errors->get('notes')" class="mt-2" />

            <x-primary-button class="mt-4">{{ __('Submit') }}</x-primary-button>
        </form>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($trucks as $truck)
            <div class="p-6 flex space-x-2">
                <div class="flex-1">
                    <div class='flex justify-between items-center'>
                        <small class="ml-2 text-sm text-gray-600">{{ $truck->created_at->format('Y M j, H:i') }}</small>
                        @unless ($truck->created_at->eq($truck->updated_at))
                        <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                        @endunless

                        <x-dropdown>
                            <x-slot name="trigger">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('trucks.edit', $truck)">
                                    {{ __('Edit') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('subunits.create', $truck)">
                                    {{ __('Add Subunit') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('trucks.destroy', $truck) }}">
                                    @csrf
                                    @method('delete')
                                    <x-dropdown-link :href="route('trucks.destroy', $truck)" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Delete') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>


                    <div class='row'>
                        <div class="mt-1 text-lg text-gray-900 col-4">
                            <div>Unit number:</div>
                            <div>{{ $truck->unit_number }}</div>
                        </div>
                        <div class="mt-1 text-lg text-gray-900 col">
                            <div>Year:</div>
                            <div>{{ $truck->year }}</div>
                        </div>
                        <div class="mt-1 text-lg text-gray-900 col">
                            <div>Notes:</div>
                            <div>{{ $truck->notes }}</div>
                        </div>
                    </div>
                    <hr>
                    <div>Subunits:</div>
                    @foreach($truck->subunits as $subunit)
                    <div class='row'>
                        <div class='col'>{{$subunit->main_truck}}</div>
                        <div class='col'>{{$subunit->subunit}}</div>
                        <div class='col'>{{$subunit->start_date}}</div>
                        <div class='col'>{{$subunit->end_date}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <hr>
            <hr>
            @endforeach
        </div>
    </div>
</x-app-layout>
