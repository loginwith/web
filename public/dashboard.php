<?php

global $dbh;

$sth = $dbh->prepare("SELECT COUNT(id) FROM projects WHERE user_id=?");
$sth->execute([$_SESSION['user_id']]);

$numProjects = $sth->fetch()[0];
?>

<div class="pb-5 sm:flex sm:items-center sm:justify-between">
  <h1 class="text-2xl leading-6 font-semibold text-gray-900">
    Dashboard
  </h1>
</div>

<div>
  <h3 class="text-lg leading-6 font-medium text-gray-900">
  </h3>
  <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
    <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
      <dt class="text-sm font-medium text-gray-500 truncate">
        Projects
      </dt>
      <dd class="mt-1 text-3xl font-semibold text-gray-900">
        <a href="/app/projects"><?= $numProjects ?></a>
      </dd>
    </div>

  </dl>
</div>

