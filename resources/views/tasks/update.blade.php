<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('tasks.index') }}">&larr; Back</a>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form action="{{ route('tasks.update', $item->id) }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Update task') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Update task information") }}
                                </p>
                            </header>
                            <div class="mt-4">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="$item->name" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="description" :value="__('Description')" />
                                <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="$item->description" required autofocus autocomplete="description" />
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="start_time" :value="__('Start time')" />
                                <x-text-input id="start_time" name="start_time" type="date" class="mt-1 block w-full" :value="$item->start_time" autofocus autocomplete="start_time" />
                                <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="end_time" :value="__('End time')" />
                                <x-text-input id="end_time" name="end_time" type="date" class="mt-1 block w-full" :value="$item->end_time" autofocus autocomplete="end_time" />
                                <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
                            </div>
                            <div class="mt-8 flex flex-row items-center">
                                <x-input-label for="priority" :value="__('Priority')" />
                                <x-dropdown-search 
                                    class="ml-4"
                                    placeholder="Select priority" 
                                    inputName="priority" 
                                    selectedId="{{ $item->priority }}"
                                    selectedName="{{ $item->priorities[$item->priority] }}"
                                    :options="$item->priorities" />
                            </div>
                            <div class="mt-8 flex flex-row items-center">
                                <x-input-label for="status" :value="__('Status')" />
                                <x-dropdown-search
                                    class="ml-4" 
                                    placeholder="Select status" 
                                    inputName="status"
                                    selectedId="{{ $item->status }}"
                                    selectedName="{{ $item->statuses[$item->status] }}" 
                                    :options="$item->statuses" />
                            </div>
                            <div class="mt-8 flex flex-row items-center">
                                <x-input-label for="project" :value="__('Project')" />
                                <x-dropdown-search
                                    class="ml-4" 
                                    placeholder="Select project" 
                                    inputName="project" 
                                    onSelect="getPersonsOfProject({{ $item->person->id }})" 
                                    selectedId="{{ $item->project->id }}"
                                    selectedName="{{ $item->project->name }}"
                                    :options="$item->projects" 
                                />
                            </div>
                        </section>
                    </div>
                    <div class="mt-10">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Assignee') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Assignee of this task") }}
                                </p>
                            </header>
                            <table id="projectPersons" class="mt-4 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>@foreach (['ID', 'Full name', 'Birthdate', 'Phone number', 'Accessible'] as $col)
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
                                    @foreach ($item->project->persons as $person)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th class="px-6 py-4">{{ $person->id }}</th>
                                            <td class="px-6 py-4">{{ $person->full_name }}</td>
                                            <td class="px-6 py-4">{{ $person->birthdate }}</td>
                                            <td class="px-6 py-4">{{ $person->phone_number }}</td>
                                            <td class="px-6 py-4"><input {{ $person->id === $item->person->id ? 'checked' : '' }} type="radio" name="person" value="{{ $person->id }}"></td>   
                                        </tr>        
                                    @endforeach
                                </tbody>
                            </table>
                        </section>
                    </div>
                    <div class="flex items-center gap-4">
                        <x-primary-button id="submit-button" class="hidden">{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function enableSubmitButton() {
        const submitBtn = document.getElementById('submit-button');
        if (submitBtn.classList.contains('hidden')) {
            submitBtn.classList.remove('hidden');
        }
    }

    const projectSelectElement = document.querySelector('input[name="project"]');
    projectSelectElement.addEventListener('change', enableSubmitButton);

    const personSelectElement = document.querySelector('input[name="person"]');
    personSelectElement.addEventListener('change', enableSubmitButton);

    function getPersonsOfProject(assignedPersonId) {
        return function (projectId) {
            axios.get(`/projects/${projectId}/persons`).then(function(response) {
                const persons = response.data;
                document.querySelector('#projectPersons tbody').innerHTML = persons.map((person, i) => `
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4">${person.id}</th>
                        <td class="px-6 py-4">${person.full_name}</td>
                        <td class="px-6 py-4">${person.birthdate}</td>
                        <td class="px-6 py-4">${person.phone_number}</td>
                        <td class="px-6 py-4">
                            <input ${assignedPersonId == person.id ? 'checked' : ''} type="radio" name="person" value="${person.id}">
                        </td>   
                    </tr>                              
                `).join('\n');
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    }
</script>