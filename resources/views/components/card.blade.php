{{-- <x-card></x-card> --}}
<div {{$attributes->merge(['class' => 'bg-gray-50 border border-gray-200 rounded p-6'])}}> {{-- merge passed class attributes, provide default ones --}}
  {{$slot}} {{-- everything passed between <x-card> content </x-card> --}}
</div>