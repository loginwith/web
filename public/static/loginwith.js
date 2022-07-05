let loggedIn = false

window.addEventListener('load', async () => {
  console.log(`marketing site loaded`)
  //const code = document.querySelector('code')
  //code.textContent = Prism.highlight(code.textContent, Prism.languages.html, 'html');

  window.loginwith = LoginWith(`HWcNp8Da0qqoPV2D`)

  await loginwith.init()

  let lwt = localStorage.getItem('lwt')
  if(lwt) {
    console.log(`stored LWT`, lwt)

    const body = new URLSearchParams()
    body.set('ticket', lwt)
    body.set('domain', location.host)

    let info = await (await fetch('https://api.loginwith.xyz/v1/verify', { method: 'POST', body })).json()

    console.log(`LWT INFO`, info)

    if(info.valid) {
      loggedIn = true
      console.log(`logged in`)
      for(const btn of document.querySelectorAll(".login-button")) {
        btn.textContent = info.display_name + ` (${info.network})`
      }
    }
  }

  loginwith.onlogin = async (network, user, ticket) => {
    console.log(`LoginWith login: `, { network, user, ticket })

    localStorage.setItem('lwt', ticket)
    loggedIn = true

    for(const btn of document.querySelectorAll(".login-button")) {
      btn.textContent = user.display_name + ` (${network})`
    }
  }
})

function handleLogin() {
  if(loggedIn) {
    localStorage.removeItem('lwt')
    this.event.target.innerText = 'Login'
    loggedIn = false
  } else {
    //loginwith.start()
    location.href = '/login';
  }
}

function switchTab(codeTarget, codeSource) {
  const isAlreadySelected = !this.event.target.getElementsByTagName("span")[0].classList.contains("hidden")
  if(isAlreadySelected) return;

  // activate other tab
  const siblingTabs = this.event.target.parentElement.parentElement.querySelectorAll("button")

  for(const btn of siblingTabs) {
    if(btn != this.event.target) {
      btn.classList.remove("hover:text-gray-300")
      btn.getElementsByTagName("span")[0].classList.add("hidden")
    }

    // newly clicked tab
    if(btn == this.event.target) {
      btn.classList.add("hover:text-gray-300");
      btn.getElementsByTagName("span")[0].classList.remove("hidden")
    }
  }
}

function notifyme() {
  this.event.preventDefault()

  if(confirm(`TODO`)) {
    window.location.assign('')
  }

  return false
}

function setSidebarOpen(open) {
  if(open) {
    document.querySelector('menu').classList.remove('hidden')
  } else {
    document.querySelector('menu').classList.add('hidden')
  }
}
