<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('projects.index') }}">&larr; Back</a>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form action="{{ route('projects.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Create new project') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Each project need have these information") }}
                                </p>
                            </header>
                            <div class="mt-4">
                                <x-input-label for="code" :value="__('Code')" />
                                <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code')" required autofocus autocomplete="code" />
                                <x-input-error class="mt-2" :messages="$errors->get('code')" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="description" :value="__('Description')" />
                                <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description')" autofocus autocomplete="description" />
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>
                            <div class="mt-8 flex flex-row items-center">
                                <x-input-label for="company" :value="__('Company')" />
                                <x-dropdown-search class="ml-4" placeholder="Select company" inputName="company" onSelect="getPersonsOfCompany" :options="$companies" />
                            </div>
                        </section>
                    </div>
                    <div class="mt-10">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Members') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Members of this project") }}
                                </p>
                            </header>
                            <table id="companyPersons" class="mt-4 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        @foreach (['ID', 'Full name', 'Birthdate', 'Phone number', 'Accessible'] as $col)
                                            <th scope="col" class="px-6 py-3">
                                                <div class="flex items-center">
                                                    {{ $col }}
                                                    <svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                                    </svg>
                                                </div>
                                            </th>
                                        @endforeach
                                    </tr>
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
    function setupToggles(index) {
        const container = document.getElementById(`toggle-container-${index}`);
        const toggle = container.querySelector('input[type=checkbox]');
        const bg = container.querySelector('div');
        const btn = container.querySelector('span');
        const submitBtn = document.getElementById('submit-button');

        toggle.addEventListener('change', () => {
            if (submitBtn.classList.contains('hidden')) {
                submitBtn.classList.remove('hidden');
            }

            if (toggle.checked) {
                bg.classList.add('bg-black');
                bg.classList.remove('bg-gray-300');
                btn.style.transform = 'translateX(16px)'; 
            } else {
                bg.classList.add('bg-gray-300');
                bg.classList.remove('bg-black');
                btn.style.transform = 'translateX(0)'; 
            }
        });
    }

    function getPersonsOfCompany(companyId) {
        axios.get(`/companies/${companyId}/persons`)
            .then(function (response) {
                const persons = response.data;
                document.querySelector('#companyPersons tbody').innerHTML = persons.map((person, i) => `
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4">${person.id}</th>
                        <td class="px-6 py-4">${person.full_name}</td>
                        <td class="px-6 py-4">${person.birthdate}</td>
                        <td class="px-6 py-4">${person.phone_number}</td>
                        <td class="px-6 py-4">
                            <label class="inline-flex items-center cursor-pointer" id="toggle-container-${i}">
                                <input type="checkbox" class="sr-only" name="person_ids[]" value="${person.id}" />
                                <div class="w-10 h-6 bg-gray-300 rounded-full transition duration-300 relative">
                                    <span class="w-4 h-4 bg-white rounded-full absolute top-1 left-1 transition-transform transform"></span>
                                </div>
                            </label>
                        </td>   
                    </tr>                              
                `).join('\n')

                for (let i = 0; i < persons.length; i++) {
                    setupToggles(i);
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }
</script>