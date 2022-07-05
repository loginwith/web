<?php
global $dbh;

$sth = $dbh->prepare("SELECT * FROM projects WHERE user_id=?");
$sth->execute([$_SESSION['user_id']]);
$projects = $sth->fetchAll();

if(count($projects) == 0) {
?>

<div class="text-center">
  <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
  </svg>
  <h3 class="mt-2 text-sm font-medium text-gray-900">No projects</h3>
  <p class="mt-1 text-sm text-gray-500">
    Get started by creating a new project.
  </p>
  <div class="mt-6">
    <a href="/app/projects/new" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      <!-- Heroicon name: solid/plus -->
      <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
      </svg>
      New Project
    </a>
  </div>
</div>

<?php
  exit();
}
?>


<div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
  <h1 class="text-2xl leading-6 font-semibold text-gray-900">
    Projects
  </h1>
  <div class="mt-3 sm:mt-0 sm:ml-4">
    <a href="/app/projects/new" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      New Project
    </a>
  </div>
</div>

<div class="flex flex-col">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Name
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Domain
              </th>
              <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Edit</span>
              </th>
            </tr>
          </thead>
          <tbody>
<?php
$even = 0;
foreach($projects as $prj) {
  $even ^= 1;
?>
            <!-- Odd row -->
            <tr class="<?= $even ? 'bg-white' : 'bg-gray-50' ?>">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                <a href="/app/projects/<?= $prj['id'] ?>"><?= htmlentities($prj['name']) ?></a>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <?= htmlentities($prj['domain']) ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="/app/projects/<?= $prj['id'] ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
              </td>
            </tr>
<?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
