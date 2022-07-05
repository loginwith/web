<?php
$project = project_get($PROJECT_ID);
$apikeys = project_get_api_keys($PROJECT_ID);
$methods = json_decode($project['lwt_methods']);
?>

<h1 class="text-2xl font-semibold text-gray-900">Edit Project</h1>

<script>
function confirmDelete(e) {
  if(!confirm('Are you sure you want to delete this project?')) {
    e.preventDefault()
  }
}

function confirmRollKey(e) {
  if(!confirm('Are you sure you want to immediately revoke this API key and generate a new one?')) {
    e.preventDefault()
  }
}
</script>

<form method="post" action="/app/projects/<?= $project['id'] ?>" class="space-y-8 divide-y divide-gray-200">
  <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
    <div>
      <div>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
        </p>
      </div>

      <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
          <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            Name
          </label>
          <div class="mt-1 sm:mt-0 sm:col-span-2">
            <input type="text" name="name" id="name" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md" value="<?= htmlentities($project['name']) ?>">
          </div>
        </div>

        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
          <label for="domain" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            Domain
          </label>
          <div class="mt-1 sm:mt-0 sm:col-span-2">
            <input type="text" name="domain" id="domain" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md" value="<?= htmlentities($project['domain']) ?>">
          </div>
        </div>

        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
          <label for="session_expiry" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            Login Session Lifetime
          </label>
          <div class="mt-1 sm:mt-0 sm:col-span-2">
            <select id="session_expiry" name="session_expiry" class="block max-w-lg pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
              <option value="600"     <?= $project['lwt_ttl'] == 600 ? 'selected' : '' ?>>10 minutes</option>
              <option value="14400"   <?= $project['lwt_ttl'] == 14400 ? 'selected' : '' ?>>4 hours</option>
              <option value="86400"   <?= $project['lwt_ttl'] == 86400 ? 'selected' : '' ?>>1 day</option>
              <option value="604800"  <?= $project['lwt_ttl'] == 604800 ? 'selected' : '' ?>>1 week</option>
              <option value="1209600" <?= $project['lwt_ttl'] == 1209600 ? 'selected' : '' ?>>2 weeks</option>
              <option value="2592000" <?= $project['lwt_ttl'] == 2592000 ? 'selected' : '' ?>>1 month</option>
            </select>
          </div>
        </div>

        <input type="hidden" name="methods[]" value="set">

        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
          <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            Blockchain Login Methods
          </label>
          <div class="mt-1 sm:mt-0 sm:col-span-2">
            <fieldset class="space-y-2">
              <legend class="sr-only">Blockchain Login Methods</legend>
              <div class="relative flex items-start">
                <div class="flex items-center h-5">
                <input id="methods[ethereum]" name="methods[ethereum]" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" <?= in_array('ethereum', $methods) ? 'checked' : '' ?>>
                </div>
                <div class="ml-3 text-sm">
                  <label for="methods[ethereum]" class="font-medium text-gray-700">Ethereum</label>
                </div>
              </div>
              <div class="relative flex items-start">
                <div class="flex items-center h-5">
                  <input id="methods[solana]" name="methods[solana]" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" <?= in_array('solana', $methods) ? 'checked' : '' ?>>
                </div>
                <div class="ml-3 text-sm">
                  <label for="methods[solana]" class="font-medium text-gray-700">Solana</label>
                </div>
              </div>
            </fieldset>
          </div>
        </div>


      </div>
    </div>
  </div>

  <div class="pt-5">
    <div class="flex justify-end">

      <div class="flex items-center mr-8">
        <div class="relative flex items-start">
          <div class="flex items-center h-5">
            <input id="logins_enabled" aria-describedby="logins_enabled-description" name="logins_enabled" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" <?= $project['login_enabled'] ? 'checked' : '' ?>>
          </div>
          <div class="ml-3 text-sm">
            <label for="logins_enabled" class="font-medium text-gray-700">Login Enabled</label>
          </div>
        </div>
      </div>

      <a href="/app/projects" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Cancel
      </a>
      <button type="submit" name="action" value="save" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Save
      </button>
      <button type="submit" name="action" value="delete" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick='confirmDelete(event)'>
        Delete
      </button>
    </div>


<script>
function copyText(e, s) {
  e.preventDefault()
  navigator.clipboard.writeText(s).then(() => {
    e.target.textContent = "Copied!"
    setTimeout(() => {
      e.target.textContent = 'Copy'
    }, 1000)
  })
}
</script>


  <div class="mt-10 divide-y divide-gray-200">
    <div class="space-y-1">
      <h3 class="text-lg leading-6 font-medium text-gray-900">
        API Keys
      </h3>
      <p class="max-w-2xl text-sm text-gray-500">
      </p>
    </div>
    <div class="mt-6">
      <dl class="divide-y divide-gray-200">
<?php
foreach($apikeys as $key) {
?>
        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
          <dt class="text-sm font-medium text-gray-500">
            <?= $key['created_at'] ?> UTC
          </dt>
          <dd class="mt-1 flex text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          <span class="flex-grow"><span class="font-mono"><?= htmlentities($key['key']) ?></span> &nbsp; <button class="bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus:outline-none " onclick='copyText(event, "<?= htmlentities($key['key']) ?>")'>Copy</button></span>
            <span class="ml-4 flex-shrink-0">
              <button type="submit" name="action" value="rollkey" class="bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" onclick='confirmRollKey(event)'>
                Roll Key
              </button>
            </span>
          </dd>
        </div>
<?php } ?>
      </dl>
    </div>
  </div>


</form>
