<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('users.index') }}">&larr; Back</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Name') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ $item->name }}
                            </p>
                        </div>
                        <div class="mt-8">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Email') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ $item->email }}
                            </p>
                        </div>
                        <div class="mt-8">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Roles') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ implode(', ', array_column($item->roles->toArray(), 'role')) }}
                            </p>
                        </div>
                        
                    </section>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
