{{-- Master layout , <x-layout></x-layout> --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  {{-- meta tags --}}
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="index,follow">
  <meta name="description" content="SEO description."/>
  <meta name="keywords" content="SEO,Keywords" />
  <meta name="author" content="SEOCompanyName">

  {{-- og meta --}}
  <meta property="og:type" content="article" />
  <meta property="og:title" content="TITLE OF YOUR POST OR PAGE" />
  <meta property="og:description" content="DESCRIPTION OF PAGE CONTENT" />
  <meta property="og:image" content="LINK TO THE IMAGE FILE" />
  <meta property="og:url" content="PERMALINK" />
  <meta property="og:site_name" content="SITE NAME" />

  {{-- twitter meta --}}
  <meta name="twitter:title" content="TITLE OF POST OR PAGE">
  <meta name="twitter:description" content="DESCRIPTION OF PAGE CONTENT">
  <meta name="twitter:image" content="LINK TO IMAGE">
  <meta name="twitter:site" content="SITE">
  <meta name="twitter:creator" content="USERNAME">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="canonical" href="http://example.com/" />

  <link rel="icon" href="{{ asset('images/favicon.ico') }}" />

  {{-- JS & CSS --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
        theme: {
          extend: {
            colors: {
              laravel: '#ef3b2d',
            },
          },
        },
      }
  </script>
  
  <title>{{ config('app.name', 'LaraGigs | Find Laravel Jobs & Projects') }}</title>
</head>

<body class="mb-48">
  <nav class="flex justify-between items-center mb-4">
    <a href="{{ route('listings.index') }}"><img class="w-24" src="{{asset('images/logo.png')}}" alt="" class="logo" /></a>
    <ul class="flex space-x-6 mr-6 text-lg">
      @auth {{-- Show only to logged in users --}}
      <li>
        <span class="font-bold uppercase">
          Welcome {{auth()->user()->name}}
        </span>
      </li>
      <li>
        <a href="{{ route('listings.manage') }}" class="hover:text-laravel"><i class="fa-solid fa-gear"></i> Manage Listings</a>
      </li>
      <li>
      {{-- logout --}}
        <form class="inline" method="POST" action="{{ route('users.logout') }}">
          @csrf
          <button type="submit">
            <i class="fa-solid fa-door-closed"></i> Logout
          </button>
        </form>
      </li>
      @else {{-- Guests --}}
      <li>
        <a href="{{ route('users.register') }}" class="hover:text-laravel"><i class="fa-solid fa-user-plus"></i> Register</a>
      </li>
      <li>
        <a href="{{route('users.login') }}" class="hover:text-laravel"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</a>
      </li>
      @endauth
    </ul>
  </nav>

  <main>
    {{$slot}} {{-- render everything between <x-layout></x-layout> --}}
  </main>
  <footer class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-white h-24 mt-24 opacity-90 md:justify-center">
    <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>
    <a href="{{route('listings.create')}}" class="absolute top-1/3 right-10 bg-black text-white py-2 px-5">Post Job</a>
  </footer>

  <x-flash-message />
</body>

</html>