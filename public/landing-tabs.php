<?php
$current = $_SERVER['QUERY_STRING'] ?: 'login.html';
?>

<div class="flex-none overflow-auto whitespace-nowrap flex" style="opacity: 1;">
  <div class="relative flex-none min-w-full px-1">
    <ul class="flex text-sm leading-6 text-gray-400">
      <li class="flex-none">
        <button type="button" class="relative py-2 px-3 <?= $current=='login.html' ? 'text-sky-300' : 'hover:text-gray-300' ?>" hx-get="/h/landing-tabs?login.html">login.html <span class="<?= $current == 'login.html' ? '' : 'hidden' ?> absolute z-10 bottom-0 inset-x-3 h-px bg-sky-300"></span>
        </button>
      </li>
      <li class="flex-none">
        <button type="button" class="relative py-2 px-3 <?= $current=='node.js' ? 'text-sky-300' : 'hover:text-gray-300' ?>" hx-get="/h/landing-tabs?node.js">node.js <span class="<?= $current == 'node.js' ? '' : 'hidden' ?> absolute z-10 bottom-0 inset-x-3 h-px bg-sky-300"></span>
        </button>
      </li>
      <li class="flex-none">
        <button type="button" class="relative py-2 px-3 <?= $current=='php' ? 'text-sky-300' : 'hover:text-gray-300' ?>" hx-get="/h/landing-tabs?php">PHP <span class="<?= $current == 'php' ? '' : 'hidden' ?> absolute z-10 bottom-0 inset-x-3 h-px bg-sky-300"></span>
        </button>
      </li>
    </ul>
    <div class="absolute bottom-0 inset-x-0 h-px bg-gray-500/30"></div>
  </div>
</div>
<div class="w-full flex-auto flex min-h-0" style="opacity: 1;">
  <div class="w-full flex-auto flex min-h-0 overflow-auto">
    <div class="w-full relative flex-auto">
      <pre class="flex min-h-full text-sm leading-6">
<!--
        <div aria-hidden="true" class="hidden md:block text-gray-600 flex-none py-4 pr-4 text-right select-none w-[3.125rem]">1
2
        </div>
-->
<?php if($current == 'login.html') { ?>
<code class="flex-auto relative block text-gray-50 pt-4 pb-4 px-4 overflow-auto language-html">&lt;script type="module" src="https://js.loginwith.xyz/v1/"&gt;&lt;/script&gt;

&lt;script&gt;
window.addEventListener("load", async () =&gt; {
  let loginwith = LoginWith(YOUR_LOGIN_WITH_API_KEY)
  await loginwith.init()

  loginwith.onlogin = async (network, user, ticket) =&gt; {
    // submit LoginWith Ticket (LWT) to your server for verification
    document.forms['loginwith'].lwt.value = ticket
    document.forms['loginwith'].submit()
  }

  document.querySelector("#loginwith").onclick = () =&gt; loginwith.start();
})
&lt;/script&gt;

&lt;!-- and a button to trigger web3 login popup --&gt;
&lt;form name="loginwith" method="post" action="/login/web3"&gt;
  &lt;input type="hidden" name="lwt"&gt;
  &lt;button id="loginwith"&gt;Login With Web3&lt;/button&gt;
&lt;/form&gt;
</code>
<?php } else if($current == 'node.js') { ?>
<code class="flex-auto relative block text-gray-50 pt-4 pb-4 px-4 overflow-auto language-javascript">const { LoginWith } = require('loginwith')
const express = require('express')
const app = express()

// other middleware, routes, etc.

const loginwith = LoginWith('YOUR_LOGIN_WITH_API_KEY')

// validate LoginWith Token and start session
app.post('/login/web3', async (req, res) =&gt; {
  const user = await loginwith.verify(req.body.lwt)
  req.session.lwt = req.body.lwt // keep, to check for expiry
  req.session.user = {
    login_method: 'web3',    // etc.
    name: user.display_name, // 0x1234..., example.eth, etc.
    network: user.network,   // ethereum, solana, etc.
    // ...
  }
  res.redirect('/app')
})</code>
<?php } else if($current == 'php') { ?>
<code class="flex-auto relative block text-gray-50 pt-4 pb-4 px-4 overflow-auto language-php">&lt;?php
function verifyLWT($lwt) {
  $opts = ['http' =&gt; [
    'method' =&gt; 'POST',
    'header' =&gt; [
      'Content-Type: application/x-www-form-urlencoded',
      'Authorization: Bearer YOUR_LOGIN_WITH_API_KEY'
    ],
    'content' =&gt; http_build_query(['ticket' =&gt; $lwt])
  ]];
  $context = stream_context_create($opts);
  $result = file_get_contents('https://api.loginwith.xyz/v1/verify', false, $context);
  return json_decode($result, true);
}

// validate LoginWith Token and start session
$lwt = verifyLWT($_REQUEST['lwt']);
if($lwt['valid']) {
  $_SESSION['lwt'] = $lwt['lwt'];
  $_SESSION['user'] = [
    'login_method' =&gt; 'web3',        // etc.
    'name' =&gt; $lwt['display_name'], // 0x1234..., example.eth, etc.
    'network' =&gt; $lwt['network']    // ethereum, solana, etc.
    // ...
  ];
  header("Location: /");
}
</code>
<?php } ?>
<script>Prism.highlightElement(document.currentScript.previousElementSibling)</script>
      </pre>
    </div>
  </div>
</div>
