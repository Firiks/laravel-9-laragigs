{{-- this listing is called in parent using <x-listing-card :listing="$listing"> --}}

@props(['listing']) {{-- access $listing from prop --}}

<x-card>
  <div class="flex">
    <img class="hidden w-48 mr-6 md:block"
      src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.png')}}" alt="" /> {{-- fallback to default image if none --}}
    <div>
      <h3 class="text-2xl">
        <a href="{{ route('listings.show', [$listing->id]) }}">{{$listing->title}}</a>
      </h3>
      <div class="text-xl font-bold mb-4">{{$listing->company}}</div>
      <x-listing-tags :tagsCsv="$listing->tags" /> {{-- pass value as prop --}}
      <div class="text-lg mt-4">
        <i class="fa-solid fa-location-dot"></i> {{$listing->location}}
      </div>
    </div>
  </div>
</x-card>