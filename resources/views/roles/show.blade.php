<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('roles.index') }}">&larr; Back</a>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        @foreach([
                            ['title' => 'Role',        'value' => $role->role],
                            ['title' => 'Description', 'value' => $role->description]
                        ] as $attribute)
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __($attribute['title']) }}</h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $attribute['value'] }}</p>
                            </div>
                        @endforach                 
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
