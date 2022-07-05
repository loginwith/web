<html class="h-full bg-gray-50">
<meta charset="utf-8">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/static/loginwith.css">
</head>

<?php
global $dbh;

$sth = $dbh->prepare("SELECT response, expires FROM magic_links WHERE id=? and response=0");
@$sth->execute([$_REQUEST['id']]);
$row = $sth->fetch();
[$response, $exp] = $row;
//[$response, $exp] = [$row['response'], $row['expires']];
//[$response, $exp] = [$row['response'], $row['expires']];
$expired = $exp < time();
?>

<body class="h-full">

  <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <a href="/"><img class="mx-auto h-12 w-auto" src="/static/loginwith.svg"></a>

      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
      </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form class="space-y-6" action="/login-rsvp" method="post">
          <input type="hidden" name="id" value="<?= @$_REQUEST['id'] ?>">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

          <?php if(isset($_REQUEST['rsvp'])) { ?>
            <p>Thank you. You may may now close this tab.</p>
          <?php } elseif($expired) { ?>
            <p>This login link has expired.</p>
          <?php } else { ?>

          <div>
            <p class="">Someone (maybe you?) is trying to sign in to your LoginWith.xyz account. If you didn't expect this, press Reject or close this tab.</p>
          </div>

          <div>
            <button type="submit" name="rsvp" value="approve" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-800 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
              Approve
            </button>
          </div>

          <div>
            <button type="submit" name="rsvp" value="reject" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-800 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
              Reject
            </button>
          </div>
          <?php } ?>

        </form>

      </div>
    </div>
  </div>

</body>
</html>
