import {isLoggedIn, logOut} from '../../utils/auth.js'

export function someAction(/* context */) {
}
export function loadUser({commit, dispatch}) {
  if (isLoggedIn) {
    this._vm.$axios.get('/api/user')
      .then(response => {
        console.log(response)
        commit("setIsLoggedIn", true);
        commit("setUser", response.data);
      })
      .catch(error => {
        console.log(error)
        dispatch('logout')
      })
  }
}
export function logout({commit}) {
  console.log('action logout')
  commit("setIsLoggedIn", false);
  commit("setUser", {});
  logOut()
}
