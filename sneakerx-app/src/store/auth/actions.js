import {isLoggedIn, logOut} from '../../utils/auth.js'
import bus from '../../utils/bus.js'


export function someAction(/* context */) {
}
export function loadUser({commit, dispatch}) {
  if (isLoggedIn) {
    this._vm.$axios.get('/api/user')
      .then(response => {
        console.log(response)
        commit("setIsLoggedIn", true);
        commit("setUser", response.data);
        bus.$emit('hideLoading', true)
      })
      .catch(error => {
        console.log(error.message)
        dispatch('logout')
        bus.$emit('hideLoading', false)
      })
  }
}
export function logout({commit}) {
  console.log('action logout')
  commit("setIsLoggedIn", false);
  commit("setUser", {});
  logOut()
}
