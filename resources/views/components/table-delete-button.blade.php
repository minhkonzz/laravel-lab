@props(['message'])

<button
    x-data="{ showTooltip: false }"
    @mouseenter="showTooltip = true"
    @mouseleave="showTooltip = false" 
    type="submit" 
    onclick="return confirm('{{ $message }}?');" 
    class="relative">
    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 7H20" stroke="#ff8591" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 10L7.70141 19.3578C7.87432 20.3088 8.70258 21 9.66915 21H14.3308C15.2974 21 16.1257 20.3087 16.2986 19.3578L18 10" stroke="#ff8591" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#ff8591" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
    <div x-show.transition="showTooltip" style="display: none;" class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 p-2 bg-gray-800 text-white rounded-lg">
        Delete
    </div>
</button>