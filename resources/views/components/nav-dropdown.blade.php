
@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white', 'trigger'])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$width = match ($width) {
    '48' => 'w-48',
    default => $width,
};
@endphp

<div class="relative inline-flex items-center gap-2 px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500" 
     x-data="{ open: false, top: '4rem', left: '0rem' }" 
     @click.outside="open = false" 
     @close.stop="open = false">
     
    <button @click="open = !open" class="flex items-center gap-2">
        {{ $trigger }}
        <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 shadow-lg {{ $alignmentClasses }}"
         :style="{ top: top, left: left }"
         @click="open = false">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $slot }}
        </div>
    </div>
</div>

