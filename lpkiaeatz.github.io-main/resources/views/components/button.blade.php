@props(['color' => 'orange', 'type' => 'button'])
<button type="{{ $type }}" {{ $attributes->merge(['class' => "bg-gradient-to-r from-[#FF914D] to-[#FF5E13] hover:from-[#FF5E13] hover:to-[#FF914D] text-white font-bold py-2 px-4 rounded-full shadow-lg transition text-lg "]) }}>
    {{ $slot }}
</button>
