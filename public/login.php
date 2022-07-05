<html class="h-full bg-gray-50">
<meta charset="utf-8">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/static/loginwith.css">
</head>

<script type="module">
window.addEventListener("load", async () => {
  let loginwith = LoginWith("HWcNp8Da0qqoPV2D")
  await loginwith.init()

  loginwith.onlogin = async (network, user, ticket) => {
    document.forms['loginwith'].lwt.value = ticket
    document.forms['loginwith'].submit()
  }

  document.querySelector('#loginwith-start').onclick = () => loginwith.start();
})
</script>

<body class="h-full">

  <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <a href="/"><img class="mx-auto h-12 w-auto" src="/static/loginwith.svg"></a>

      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
      </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <?php if(isset($_SESSION['flash'])) { ?>
          <?php if($_SESSION['flash_type'] == 'success') { ?>
            <div class="bg-teal-100 border border-teal-400 text-teal-700 px-4 py-3 rounded relative" role="alert">
            <?php } elseif($_SESSION['flash_type'] == 'error') { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <?php } ?>

            <span class="block sm:inline"><?= htmlentities($_SESSION['flash']) ?></span>
          </div>
        <?php } ?>
        <?php $_SESSION['flash'] = null ?>

        <form class="space-y-6" action="/login" method="post">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

<?php if(isset($_SESSION['login_rsvp_id'])) { ?>

          <iframe src="/login-rsvp?id=<?= urlencode($_SESSION['login_rsvp_id']) ?>&check=1" border="0" width="0" height="0"></iframe>

          <p>
            Please check your email for a login link and press the Approve button. You will be automatically logged in.
          </p>

          <div className="mx-auto mt-6 flex items-center justify-center h-12 w-12 rounded-full">
            <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-gray" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
          </div>


<?php } else { ?>
          <p>To begin, enter your email or login with web3 below.</p>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
              Email address
            </label>
            <div class="mt-1">
              <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-rose-500 focus:border-rose-500 sm:text-sm" value="">
            </div>
          </div>

          <!--
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
              Password
            </label>
            <div class="mt-1">
              <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-rose-500 focus:border-rose-500 sm:text-sm" value="">
            </div>
          </div>
          -->

          <div class="hidden flex items-center justify-between">
            <div class="flex items-center">
              <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-rose-600 focus:ring-rose-500 border-gray-300 rounded">
              <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                Remember me
              </label>
            </div>

            <div class="text-sm">
              <a href="#" class="font-medium text-gray-600 hover:text-gray-500" onclick='alert("hehe"); return false;'>
                Forgot your password?
              </a>
            </div>
          </div>

          <div>
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-800 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
              Login with Email
            </button>
          </div>
        </form>

        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">
                Or
              </span>
            </div>
          </div>

          <form name="loginwith" action="/login" method="post">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="lwt" value="">

            <div class="mt-6">
              <button type="button" id="loginwith-start" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-800 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                Login with Web3
              </button>
            </div>

<?php } ?>

          </form>
        </div>
      </div>
    </div>
  </div>

<?php
$uri = is_dir('/Users/amir') ? 'http://localhost:1234/v1/' : 'https://js.loginwith.xyz/v1/';
?>
  <script type="module" src="<?= $uri ?>"></script>

</body>
</html>
