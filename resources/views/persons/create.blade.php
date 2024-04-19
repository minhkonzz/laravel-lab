<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('persons.index') }}">&larr; Back</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Create new person') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Each person need have these information") }}
                            </p>
                        </header>
                        <form action="{{ route('persons.store') }}" method="POST" class="mt-6 space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="full_name" :value="__('Full name')" />
                                <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name')" required autofocus autocomplete="full_name" />
                                <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
                            </div>
                            <div>
                                <x-input-label for="gender" :value="__('Gender')" />
                                <x-text-input id="gender" name="gender" type="text" class="mt-1 block w-full" :value="old('gender')" />
                                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                            </div>
                            <div>
                                <x-input-label for="birthdate" :value="__('Birthdate')" />
                                <x-text-input id="birthdate" name="birthdate" type="date" class="mt-1 block w-full" :value="old('birthdate')" autofocus autocomplete="birthdate" />
                                <x-input-error class="mt-2" :messages="$errors->get('birthdate')" />
                            </div>
                            <div>
                                <x-input-label for="phone_number" :value="__('Phone number')" />
                                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number')" autofocus autocomplete="phone_number" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                            </div>
                            <div>
                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" autofocus autocomplete="address" />
                                <x-input-error class="mt-2" :messages="$errors->get('address')" />
                            </div>

                            <div class="flex items-center">
                                <x-input-label for="company" :value="__('Company')" />
                                <x-dropdown-search placeholder="Select company" :options="$companies" />
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'person-created')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Created new person.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
