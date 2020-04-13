import {isLoggedIn, logOut} from '../../utils/auth.js'
import bus from '../../utils/bus.js'


export function someAction(/* context */) {
}
export function loadUser({commit, dispatch}, loadFor) {
  if (isLoggedIn) {
    this._vm.$axios.get('/api/user')
      .then(response => {
        console.log(response)
        commit("setIsLoggedIn", true);
        commit("setUser", response.data);
        if (loadFor === 'login') bus.$emit('hideLoginLoading', true)
        if (loadFor === 'register') bus.$emit('hideRegisterLoading', true)
        if (loadFor === 'firstLoad') bus.$emit('hideFirstLoading')
      })
      .catch(error => {
        console.log(error.message)
        dispatch('logout')
        if (loadFor === 'login') bus.$emit('hideLoginLoading', false)
        if (loadFor === 'register') bus.$emit('hideRegisterLoading', false)
        if (loadFor === 'firstLoad') bus.$emit('hideFirstLoading')
      })
  }
}
export function logout({commit}) {
  console.log('action logout')
  commit("setIsLoggedIn", false);
  commit("setUser", {});
  logOut()
}
