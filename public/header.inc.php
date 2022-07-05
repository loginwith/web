<!doctype html>
<html class="h-full bg-gray-50" lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? "${title} - " : "" ?>LoginWith.xyz</title>
  <link rel="stylesheet" href="/static/loginwith.css">
  <script src="/static/loginwith.js"></script>
</head>
<body>
<div class="relative bg-white overflow-hidden">
  <?php if(($UI ?? '') != 'app') { ?>
  <!-- marketing site view -->
  <!-- dot pattern thingy -->
  <div class="hidden lg:block lg:absolute lg:inset-0" aria-hidden="true">
    <svg class="absolute top-0 left-1/2 transform translate-x-64 -translate-y-8" width="640" height="784" fill="none" viewBox="0 0 640 784">
      <defs>
        <pattern id="9ebea6f4-a1f5-4d96-8c4e-4c2abf658047" x="118" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
          <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
        </pattern>
      </defs>
      <rect y="72" width="640" height="640" class="text-gray-50" fill="currentColor" />
      <rect x="118" width="404" height="784" fill="url(#9ebea6f4-a1f5-4d96-8c4e-4c2abf658047)" />
    </svg>
  </div>

  <div class="relative pt-6 pb-16 sm:pb-24 lg:pb-32">
    <div>
      <nav class="relative max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6" aria-label="Global">
        <div class="flex items-center flex-1">
          <div class="flex items-center justify-between w-full md:w-auto">
            <a href="/">
              <span class="sr-only">LoginWith</span>
              <img class="h-11 w-auto sm:h-10" src="/static/loginwith.svg" alt="LoginWith logo">
            </a>
            <div class="-mr-2 flex items-center md:hidden">
              <script>const openMobileMenu = () => document.querySelector('menu').classList.remove('hidden')</script>
              <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false" onclick='openMobileMenu()'>
                <span class="sr-only">Open main menu</span>
                <!-- Heroicon name: outline/menu -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </button>
            </div>
          </div>
          <div class="hidden md:block md:ml-10 md:space-x-10">
            <!--<a href="/wallets" class="font-medium text-gray-500 hover:text-gray-900">Wallets</a>-->
          </div>
        </div>
        <div class="hidden md:block text-right">
          <span class="inline-flex rounded-md shadow-md ring-1 ring-black ring-opacity-5">
            <button class="login-button inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50" onclick='handleLogin()'>
              Login
            </button>
          </span>
        </div>
      </nav>

      <!--
        Mobile menu, show/hide based on menu open state.

        Entering: "duration-150 ease-out"
          From: "opacity-0 scale-95"
          To: "opacity-100 scale-100"
        Leaving: "duration-100 ease-in"
          From: "opacity-100 scale-100"
          To: "opacity-0 scale-95"
      -->
      <script>const closeMobileMenu = () => document.querySelector('menu').classList.add('hidden')</script>
      <menu class="hidden absolute z-10 top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
        <div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
          <div class="px-5 pt-4 flex items-center justify-between">
            <div>
              <img class="h-8 w-auto" src="/static/loginwith.svg" alt="LoginWith logo">
            </div>
            <div class="-mr-2">
              <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" onclick='closeMobileMenu()'>
                <span class="sr-only">Close main menu</span>
                <!-- Heroicon name: outline/x -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
          <div class="px-2 pt-2 pb-3 space-y-1">
            <!--<a href="/wallets" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Wallets</a>-->
          </div>
          <button class="login-button block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100" onclick='handleLogin()'>
            Login
          </button>
        </div>
      </menu>
    </div>
  <?php } ?>
