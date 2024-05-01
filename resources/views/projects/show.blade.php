<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('projects.index') }}">&larr; Back</a>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        @foreach([
                            ['title' => 'Code',        'value' => $project->code],
                            ['title' => 'Name',        'value' => $project->name],
                            ['title' => 'Description', 'value' => $project->description],
                            ['title' => 'Company',     'value' => $project->company->name]
                        ] as $attribute)
                            <div class="mt-8">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Code') }}</h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $project->code }}</p>
                            </div>
                        @endforeach
                    </section>
                </div>
                <div class="mt-10">
                    <section>
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Members') }}</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("Members of this project") }}</p>
                        </div>
                        <table class="mt-4 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>@foreach (['ID', 'Full name', 'Birthdate', 'Phone number'] as $col) 
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex items-center">
                                            {{ $col }}
                                            <svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                            </svg>
                                        </div>
                                    </th>
                                @endforeach</tr>
                            </thead>
                            <tbody>
                                @foreach ($project->persons as $person)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th class="px-6 py-4">{{ $person->id }}</th>
                                        <td class="px-6 py-4">{{ $person->full_name }}</td>
                                        <td class="px-6 py-4">{{ $person->birthdate }}</td>
                                        <td class="px-6 py-4">{{ $person->phone_number }}</td>  
                                    </tr>        
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
