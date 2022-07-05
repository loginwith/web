<?php include __DIR__ . '/header.inc.php'; ?>

    <main class="mt-16 mx-auto max-w-7xl px-4 sm:mt-24 sm:px-6 lg:mt-32">
      <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="__sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
          <h1>
            <span class="rounded bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-500 tracking-wide uppercase">Beta</span>

            <span class="mt-1 block text-4xl tracking-tight font-extrabold sm:text-5xl xl:text-6xl">
              <span class="block text-gray-900">Single Sign-On</span>
              <span class="block text-rose-600">for Web3</span>
            </span>
          </h1>
          <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
            Add crypto wallet login to any website with only a few lines of code. As easy as adding another social login button. Perfect for gating access to members-only NFT communities, and more!
          </p>



          <dl class="mt-10 space-y-10">
            <div class="relative">
              <dt>
                <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                  <!-- Heroicon name: outline/globe-alt -->
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                  </svg>
                </div>
                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Multiple Wallets</p>
              </dt>
              <dd class="mt-2 ml-16 text-base text-gray-500">
                LoginWith takes care of handling all the different web3 wallets, whether they're mobile, desktop, browser extension, etc.
              </dd>
            </div>

            <div class="relative">
              <dt>
                <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                  <!-- Heroicon name: outline/scale -->
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                  </svg>
                </div>
                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Multiple Blockchains</p>
              </dt>
              <dd class="mt-2 ml-16 text-base text-gray-500">
                Ethereum (including EVM-compatible networks) and Solana supported out of the box. Opt-in to what networks you want to support. More soon.
              </dd>
            </div>

            <div class="relative">
              <dt>
                <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                  <!-- Heroicon name: outline/lightning-bolt -->
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                  </svg>
                </div>
                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Lightning Fast</p>
              </dt>
              <dd class="mt-2 ml-16 text-base text-gray-500">
                Blinding-fast CDN-hosted script bundle. Always up-to-date.
              </dd>
            </div>
          </dl>



          <div class="hidden mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0">
            <p class="text-base font-medium text-gray-900">
              Sign up to get notified when it’s ready.
            </p>
            <form action="#" method="POST" class="mt-3 sm:flex">
              <label for="email" class="sr-only">Email</label>
              <input type="email" name="email" id="email" class="block w-full py-3 text-base rounded-md placeholder-gray-500 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:flex-1 border-gray-300" placeholder="Enter your email">
              <button type="submit" class="mt-3 w-full px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:flex-shrink-0 sm:inline-flex sm:items-center sm:w-auto">
                Notify me
              </button>
            </form>
            <p class="mt-3 text-sm text-gray-500">
              No spam, promise.
            </p>
          </div>
        </div>
        <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">

          <!-- terminal -->
          <div class="relative overflow-hidden shadow-xl flex bg-gray-800 __h-[30rem] __max-h-[60vh] sm:max-h-[none] sm:rounded-xl __lg:h-[30rem] __xl:h-[30rem] dark:bg-gray-900/70 dark:backdrop-blur dark:ring-1 dark:ring-inset dark:ring-white/10 __mr-[2rem] w-full">
            <div class="relative w-full flex flex-col">
              <div class="flex-none border-b border-gray-500/30">
                <div class="flex items-center h-8 space-x-1.5 px-3">
                  <div class="w-2.5 h-2.5 bg-gray-600 rounded-full"></div>
                  <div class="w-2.5 h-2.5 bg-gray-600 rounded-full"></div>
                  <div class="w-2.5 h-2.5 bg-gray-600 rounded-full"></div>
                </div>
              </div>
              <div class="relative min-h-0 flex-auto flex flex-col">
                <!-- {children} -->
                <div id="tabs" hx-target="#tabs" hx-swap="innerHTML">
                  <?php include 'landing-tabs.php' ?>
                </div>
              </div>
            </div>
          </div> <!-- /terminal -->

        </div>
      </div>


      <div class="relative bg-white py-16 sm:py-24 lg:py-32">
        <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
          <h2 class="text-base font-semibold tracking-wider text-indigo-600 uppercase">Better Together</h2>
          <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
            web2 + web3 = ❤️
          </p>
          <p class="mt-5 max-w-prose mx-auto text-xl text-gray-500">
            LoginWith brings together a seamless and joyful web3 sign-in experience for your users, already supporting popular wallets. And with <a class="underline" href="https://walletconnect.com/">WalletConnect</a> integration, any wallet in the metaverse can login with us. Compatible with <a class="underline" href="https://login.xyz/">Sign-In with Ethereum</a>, too.
          </p>
        </div>
      </div>



      <!-- CTA section -->
      <!--
      <div class="relative mt-24 sm:mt-32 sm:py-16">
        <div aria-hidden="true" class="hidden sm:block">
          <div class="absolute inset-y-0 left-0 w-1/2 bg-gray-50 rounded-r-3xl"></div>
          <svg class="absolute top-8 left-1/2 -ml-3" width="404" height="392" fill="none" viewBox="0 0 404 392">
            <defs>
              <pattern id="8228f071-bcee-4ec8-905a-2a059a2cc4fb" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
              </pattern>
            </defs>
            <rect width="404" height="392" fill="url(#8228f071-bcee-4ec8-905a-2a059a2cc4fb)" />
          </svg>
        </div>
        <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
          <div class="relative rounded-2xl px-6 py-10 bg-rose-500 overflow-hidden shadow-xl sm:px-12 sm:py-20">
            <div aria-hidden="true" class="absolute inset-0 -mt-72 sm:-mt-32 md:mt-0">
              <svg class="absolute inset-0 h-full w-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 1463 360">
                <path class="text-rose-400 text-opacity-40" fill="currentColor" d="M-82.673 72l1761.849 472.086-134.327 501.315-1761.85-472.086z" />
                <path class="text-rose-600 text-opacity-40" fill="currentColor" d="M-217.088 544.086L1544.761 72l134.327 501.316-1761.849 472.086z" />
              </svg>
            </div>
            <div class="relative">
              <div class="sm:text-center">
                <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
                  Get notified when we&rsquo;re launching.
                </h2>
                <p class="mt-6 mx-auto max-w-2xl text-lg text-rose-100">
                  <span class="italic">Want to know more? Leave your email and get a personal update about when LoginWith is ready for launch!</span>
                </p>
              </div>
              <form action="#" class="mt-12 sm:mx-auto sm:max-w-lg sm:flex" onsubmit='notifyme()'>
                <div class="min-w-0 flex-1">
                  <label for="cta-email" class="sr-only">Email address</label>
                  <input id="cta-email" type="email" class="block w-full border border-transparent rounded-md px-5 py-3 text-base text-gray-900 placeholder-gray-500 shadow-sm focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-rose-500" placeholder="Enter your email">
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-3">
                  <button type="submit" class="block w-full rounded-md border border-transparent px-5 py-3 bg-gray-900 text-base font-medium text-white shadow hover:bg-black focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-rose-500 sm:px-10">Notify me</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      -->


    </main>


<?php include __DIR__ . '/footer.inc.php'; ?>
