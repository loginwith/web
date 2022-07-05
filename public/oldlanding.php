<?php include __DIR__ . '/header.inc.php'; ?>

    <main>
      <!-- Hero section -->
      <div class="pt-8 overflow-hidden sm:pt-12 lg:relative lg:py-24">
        <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl lg:grid lg:grid-cols-2 lg:gap-24">
          <div>
            <div>
              <img class="h-11 w-auto" src="/static/loginwith.svg" alt="LoginWith logo">
            </div>
            <div class="mt-20">
              <div>
                <!--<a href="#" class="inline-flex space-x-4">-->
                  <span class="rounded bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-500 tracking-wide uppercase">
                    Coming Soon
                  </span>
                <!--</a>-->
              </div>
              <div class="mt-6 sm:max-w-xl">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">
                  Single Sign-On for Web3
                </h1>
                <p class="mt-6 text-xl text-gray-500">
Add web3 wallet login to traditional web2 apps with only a few lines of code. As easy as adding another social login button!
                </p>
              </div>
              <form action="https://demo.loginwith.xyz/" class="mt-12 sm:max-w-lg sm:w-full sm:flex">
                <div class="hidden min-w-0 flex-1">
                  <label for="hero-email" class="sr-only">Email address</label>
                  <input id="hero-email" type="email" class="block w-full border border-gray-300 rounded-md px-5 py-3 text-base text-gray-900 placeholder-gray-500 shadow-sm focus:border-rose-500 focus:ring-rose-500" placeholder="Enter your email">
                </div>
                <div class="mt-4 sm:mt-0 sm:___ml-3">
                  <button type="submit" name="ref" value="landing" class="block w-full rounded-md border border-transparent px-5 py-3 bg-rose-500 text-base font-medium text-white shadow hover:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 sm:px-10">Try it out!</button>
                </div>
              </form>

              <div class="mt-6 hidden">
                <div class="inline-flex items-center divide-x divide-gray-300">
                  <div class="min-w-0 flex-1 py-1 text-sm text-gray-500 sm:py-3"></div>
                  <!--<div class="min-w-0 flex-1 py-1 text-sm text-gray-500 sm:py-3"><span class="font-medium text-gray-900">Rated 5 stars</span> by over <span class="font-medium text-rose-500">500 beta users</span></div>-->
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="sm:mx-auto sm:max-w-3xl sm:px-6">
          <div class="py-12 sm:relative sm:mt-12 sm:py-16 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <div class="hidden sm:block">
              <div class="absolute inset-y-0 left-1/2 w-screen bg-gray-50 rounded-l-3xl lg:left-80 lg:right-0 lg:w-full"></div>
              <svg class="absolute top-8 right-1/2 -mr-3 lg:m-0 lg:left-0" width="404" height="392" fill="none" viewBox="0 0 404 392">
                <defs>
                  <pattern id="837c3e70-6c3a-44e6-8854-cc48c737b659" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                  </pattern>
                </defs>
                <rect width="404" height="392" fill="url(#837c3e70-6c3a-44e6-8854-cc48c737b659)" />
              </svg>
            </div>
            <div class="relative pl-4 m:-mr-40 sm:mx-auto sm:max-w-3xl sm:px-0 lg:max-w-none lg:h-full lg:pl-12">
              <!--<img class="w-full rounded-md shadow-xl ring-1 ring-black ring-opacity-5 lg:h-full lg:w-auto lg:max-w-none" src="https://tailwindui.com/img/component-images/task-app-rose.jpg" alt="">-->


              <div class="relative overflow-hidden shadow-xl flex bg-gray-800 __h-[30rem] __max-h-[60vh] sm:max-h-[none] sm:rounded-xl __lg:h-[30rem] __xl:h-[30rem] dark:bg-gray-900/70 dark:backdrop-blur dark:ring-1 dark:ring-inset dark:ring-white/10 mr-[2rem]">
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
                    <div id="tabs" hx-get="/h/landing-tabs?login.html" hx-trigger="load" hx-target="#tabs" hx-swap="innerHTML"></div>
                </div>
              </div> <!--  terminal -->
            </div>
          </div>
        </div>
      </div>


      <div class="mt-32">
        <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
          <div class="lg:grid lg:grid-cols-2 lg:gap-24 lg:items-center">
            <div>
              <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
                web2 + web3 = ❤️
              </h2>
              <p class="mt-6 max-w-3xl text-lg leading-7 text-gray-500">
                Old and new go well together. LoginWith lets you provide a seamless sign-in experience supporting all major web3 wallets in use today. Plus, any wallet supporting <a href="https://walletconnect.com/">WalletConnect</a> works seamlessly.
              </p>
              <div class="mt-6">
                <a href="/wallets" class="text-base font-medium text-rose-500">
                  Learn more about wallet support&nbsp&rarr;
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- CTA section -->
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
    </main>

<?php include __DIR__ . '/footer.inc.php'; ?>
