@props(['type' => 'success'])
@php
    $color = $type === 'success' ? 'green' : ($type === 'error' ? 'red' : 'gray');
@endphp
<div class="bg-{{ $color }}-100 border border-{{ $color }}-400 text-{{ $color }}-700 px-4 py-3 rounded-lg shadow mb-4 text-center animate__animated animate__fadeInDown">
    {{ $slot }}
</div>
