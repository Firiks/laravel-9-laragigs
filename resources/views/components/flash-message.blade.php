{{-- Show flash message, <x-flash-message/> --}}
@if(session()->has('message'))
<div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" {{-- use alpine.js x-data, x-init, x-show  to hide 3s after showing--}}
  class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-laravel text-white px-48 py-3">
  <p>
    {{session('message')}}
  </p>
</div>
@endif