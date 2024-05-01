<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('companies.index') }}">&larr; Back</a>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Create new country') }}</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("Each country need have these information") }}</p>
                        </header>
                        <form action="{{ route('countries.store') }}" method="POST" class="mt-6 space-y-6">
                            @csrf
                            @foreach([
                                ['name' => 'code',        'title' => 'Code',        'value' => old('code')],
                                ['name' => 'name',        'title' => 'Name',        'value' => old('name')],
                                ['name' => 'description', 'title' => 'Description', 'value' => old('description')]
                            ] as $field)
                                <div>
                                    <x-input-label :for="{{ $field['name']" :value="__($field['title'])" />
                                    <x-text-input :id="$field['name']" :name="$field['name']" type="text" class="mt-1 block w-full" :value="$field['value']" required autofocus :autocomplete="$field['name']" />
                                    <x-input-error class="mt-2" :messages="$errors->get($field['name'])" />
                                </div>
                            @endforeach
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
