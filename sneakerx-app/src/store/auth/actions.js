export function someAction(/* context */) {
}

export function loadUser({commit, dispatch}) {
  console.log('action loaduser : ' + localStorage.getItem('isLoggedIn') )
  if (localStorage.getItem('isLoggedIn')) {
    console.log('isLoggedIn')
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
  commit("setIsLoggedIn", false);
  commit("setUser", {});
  localStorage.removeItem('isLoggedIn')
}
