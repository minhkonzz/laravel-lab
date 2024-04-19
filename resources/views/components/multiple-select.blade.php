@php

$selectOptions = [
    ['id' => 1, 'name' => 'Developer', 'selected' => false],
    ['id' => 2, 'name' => 'Designer', 'selected' => false],
    ['id' => 3, 'name' => 'Project Manager', 'selected' => false],
    ['id' => 4, 'name' => 'Tester', 'selected' => false]
]

@endphp

<div 
    id="select-container"
    x-data="{ open: false, options: {{ json_encode($selectOptions) }} }" 
    @click.away="open = false" 
    @close.stop="open = false" 
    @click="open = ! open;" 
    class="w-60 h-[60px] border-gray-500 border-2 rounded-md relative"
    x-init="">

    <div id="select-selected" class="h-full flex items-center overflow-x-auto overflow-y-hidden">
        <template x-for="option in options" :key="option.id">
            <span 
                @click="option.selected = false"
                x-show="option.selected"
                class="cursor-pointer p-2 bg-gray-300 rounded-md text-[12px] ml-1" 
                x-text="option.name">
            </span>
        </template>
    </div>

    <div x-show="open" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="w-full absolute z-50 mt-2 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 bg-white" 
        style="display: none;">

        <template x-for="option in options" :key="option.id">
            <span 
                @click="option.selected = true;" 
                x-show="!option.selected" 
                class="cursor-pointer block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out" 
                x-text="option.name">
            </span>
        </template>

    </div>
</div>