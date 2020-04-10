export function isLoggedIn () {
  return localStorage.getItem("isLoggedIn")
}

export function logIn () {
  return localStorage.setItem("isLoggedIn", true)
}

export function logOut () {
  return localStorage.removeItem("isLoggedIn")
}
