@props(['element', 'depth'])

@php
    $hasChild = isset($element->children) && count($element->children) > 0
@endphp

<div x-data="{ open: true }">
    <div class="grid grid-cols-4 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <div class="px-6 py-4">
            <span class="relative flex flex-row items-center" style="margin-left: {{ $element->isChild() ? intval($depth) * 10 . 'px' : null }}">
                @if ($hasChild)
                    @php $icRef = str_replace('=', '', base64_encode('ic' . $element->id . $element->name)) @endphp
                    <button class="absolute -left-5" @click="open = !open; const e = $refs.{{ $icRef }}; e.style.transform = `rotate(-${open ? 0 : 90}deg)`">
                        <svg
                            x-ref="{{ $icRef }}"
                            class="w-4 h-4 mr-4 transition" 
                            xmlns="http://www.w3.org/2000/svg" 
                            class="ionicon" 
                            viewBox="0 0 512 512">
                            <path d="M98 190.06l139.78 163.12a24 24 0 0036.44 0L414 190.06c13.34-15.57 2.28-39.62-18.22-39.62h-279.6c-20.5 0-31.56 24.05-18.18 39.62z"/>
                        </svg>
                    </button>
                @endif
                {{ $element->id }}
            </span>
        </div>
        <div class="px-6 py-4">{{ $element->code }}</div>
        <div class="px-6 py-4">{{ $element->name }}</div>
        <div class="flex items-center px-6 py-4">
            <a  x-data="{ showTooltip: false }"
                @mouseenter="showTooltip = true"
                @mouseleave="showTooltip = false"
                class="relative inline-block mb-1 mx-4"
                href="{{ route('departments.edit', $element->id) }}">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#a8a8a8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#a8a8a8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                <div x-show="showTooltip" style="display: none;" class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 p-2 bg-gray-800 text-white rounded-lg">
                    Edit
                </div>
            </a> 
            <form action="{{ route('departments.destroy', $element->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button
                    x-data="{ showTooltip: false }"
                    @mouseenter="showTooltip = true"
                    @mouseleave="showTooltip = false" 
                    type="submit" 
                    onclick="return confirm('Do you want to delete this project?');" 
                    class="relative">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 7H20" stroke="#ff8591" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 10L7.70141 19.3578C7.87432 20.3088 8.70258 21 9.66915 21H14.3308C15.2974 21 16.1257 20.3087 16.2986 19.3578L18 10" stroke="#ff8591" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#ff8591" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    <div x-show="showTooltip" style="display: none;" class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 p-2 bg-gray-800 text-white rounded-lg">
                        Delete
                    </div>
                </button>
            </form>
        </div>
    </div>
    <div x-show="open">
        <x-tree-view-table :elements="$element->children" depth="{{ intval($depth) * 2 }}" />
    </div>
</div>
