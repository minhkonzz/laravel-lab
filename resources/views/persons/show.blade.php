<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('persons.index') }}">&larr; Back</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Full name') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ $item->full_name }}
                            </p>
                        </div>
                        <div class="mt-8">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Gender') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ $item->gender }}
                            </p>
                        </div>
                        <div class="mt-8">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Birthdate') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ $item->birthdate }}
                            </p>
                        </div>
                        <div class="mt-8">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Phone number') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ $item->phone_number }}
                            </p>
                        </div>
                        <div class="mt-8">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Address') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ $item->address }}
                            </p>
                        </div>
                        
                    </section>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
