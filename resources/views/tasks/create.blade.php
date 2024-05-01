<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('tasks.index') }}">&larr; Back</a>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form action="{{ route('tasks.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Create new task') }}</h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("Each task need have these information") }}</p>
                            </header>
                            @foreach([
                                ['name' => 'name',        'type' => 'text', 'title' => 'Name'],
                                ['name' => 'description', 'type' => 'text', 'title' => 'Description'],
                                ['name' => 'start_time',  'type' => 'date', 'title' => 'Start time'],
                                ['name' => 'end_time',    'type' => 'date', 'title' => 'End time']
                            ] as $field)
                                <div class="mt-4">
                                    <x-input-label :for="$field['name']" :value="__($field['title'])" />
                                    <x-text-input :id="$field['name']" :name="$field['name']" :type="$field['type']" class="mt-1 block w-full" :value="old($field['name'])" required autofocus :autocomplete="$field['name']" />
                                    <x-input-error class="mt-2" :messages="$errors->get($field['name'])" />
                                </div>
                            @endforeach

                            @foreach([
                                ['inputName' => 'priority', 'title' => 'Priority', 'placeholder' => 'Select priority', 'options' => $priorities],
                                ['inputName' => 'status',   'title' => 'Status',   'placeholder' => 'Select status',   'options' => $statuses],
                                ['inputName' => 'project',  'title' => 'Project',  'placeholder' => 'Select project',  'options' => $projects, 'onSelect' => 'getPersonsOfProject']
                            ] as $selection)
                                <div class="mt-8 flex flex-row items-center">
                                    <x-input-label for="{{ $selection['inputName'] }}" :value="__($selection['title'])" />
                                    <x-dropdown-search 
                                        class="ml-4" 
                                        placeholder="{{ $selection['placeholder'] }}" 
                                        inputName="{{ $selection['inputName'] }}" 
                                        :options="$selection['options']" 
                                        onSelect="{{ isset($selection['onSelect']) ? $selection['onSelect'] : '' }}"
                                    />
                                </div>
                            @endforeach
                        </section>
                    </div>
                    <div class="mt-10">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Assignees') }}</h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("Assignees for this task") }}</p>
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
                                <tbody></tbody>
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
    function enableSubmitButton () {
        const submitBtn = document.getElementById('submit-button');
        if (submitBtn.classList.contains('hidden')) {
            submitBtn.classList.remove('hidden');
        }
    }

    const projectOptions = document.querySelectorAll('input[name="project"]');

    for (let i = 0; i < projectOptions.length; i++) {
        projectOptions[i].addEventListener('change', enableSubmitButton);
    }

    function getPersonsOfProject(projectId) {
        axios.get(`/projects/${projectId}/persons`).then(function(response) {
            const persons = response.data;
            document.querySelector('#projectPersons tbody').innerHTML = persons.map((person, i) => `
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th class="px-6 py-4">${person.id}</th>
                    <td class="px-6 py-4">${person.full_name}</td>
                    <td class="px-6 py-4">${person.birthdate}</td>
                    <td class="px-6 py-4">${person.phone_number}</td>
                    <td class="px-6 py-4"><input type="radio" name="person" value="${person.id}"></td>   
                </tr>                              
            `).join('\n');
        })
        .catch(function (error) {
            console.log(error);
        });
    }
</script>