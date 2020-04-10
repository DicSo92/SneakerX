export function someMutation (/* state */) {
}
export const setIsLoggedIn = (state, status) => {
  console.log('set IsLoggedIn')
  state.isLoggedIn = status
}
export const setUser = (state, user) => {
  console.log('set user')
  state.user = user
}
