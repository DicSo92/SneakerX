import axios from 'axios'

// We create our own axios instance and set a custom base URL.
// Note that if we wouldn't set any config here we do not need
// a named export, as we could just `import axios from 'axios'`
const axiosInstance = axios.create({
  baseURL: process.env.DEV ? 'http://localhost:8000' : 'http://sneakerx-shop.herokuapp.com',
  withCredentials: true,
  headers: {
    'X-Requested-With': 'XMLHttpRequest'
  },
})


export default ({Vue, store}) => {

  axiosInstance.interceptors.response.use(
    response => {
      return response
    },
    error => {
      console.log('reject')
      if (401 === error.response.status) {
        console.log('**Unauthorized**')
        store.dispatch('auth/logout')
      }
      return Promise.reject(error)
    }
  )

  // for use inside Vue files through this.$axios
  Vue.prototype.$axios = axiosInstance

}


// Here we define a named export
// that we can later use inside .js files:
export {
  axiosInstance as Axios
}
