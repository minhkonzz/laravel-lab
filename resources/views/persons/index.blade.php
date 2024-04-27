<x-app-layout>
    <x-slot name="header">
        <h2>Person list</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="relative overflow-x-auto shadow-md p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="pb-5 w-full flex flex-row justify-between items-center">
                    <x-table-text-search placeholder="Search persons" inputName="person-search" />
                    <x-table-add-button :href="route('persons.create')" title="New person" />
                </div>
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>@foreach (['ID', 'Full name', 'Gender', 'Birthdate', 'Actions'] as $col)
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Full name
                                    <svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                    </svg>
                                </div>
                            </th>
                        @endforeach</tr>
                    </thead>
                    <tbody>
                        @foreach ($persons as $person)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4">{{ $person->id }}</th>
                                <td class="px-6 py-4">{{ $person->full_name }}</td>
                                <td class="px-6 py-4">{{ $person->gender }}</td>
                                <td class="px-6 py-4">{{ $person->birthdate }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('persons.destroy', $person->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-table-show-button :href="route('persons.show', $person->id)" />
                                        <x-table-edit-button :href="route('persons.edit', $person->id)" />
                                        <x-table-delete-button message="Do you want to delete this person" />
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $persons->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
