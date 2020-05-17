export function getStorageCart({commit}) {
  console.log('getStorageCart')
  let cartProducts = []
  let localCart = localStorage.getItem('cart')
  if (localCart) {
    cartProducts = JSON.parse(localCart);
  } else {
    localStorage.setItem('cart', '[]')
  }
  commit("changeCart", cartProducts);
}

export function updateStorageCart({commit, dispatch, state}, {product, color, size, total}) {
  const cartExist = !!(state.cart && state.cart.length > 0) // true/false

  const productIndex = state.cart && state.cart.length > 0 ? state.cart.findIndex(cartP => cartP.product.id === product.id) : -1
  const sameProductIndex = state.cart.findIndex(cartP => cartP.product.id === product.id && cartP.color.color === color.color && cartP.size === size)
  if (!cartExist || productIndex === -1 || sameProductIndex === -1) {
    commit("pushCart", {total, color, size, product});
  } else {
    commit("updateTotalCart", {index: sameProductIndex, total});
  }

  localStorage.cart = JSON.stringify(state.cart)
}

export function removeFromStorageCart({commit, dispatch, state}, productIndex) {
  commit("removeProduct", productIndex);

  localStorage.cart = JSON.stringify(state.cart)
}

export function clearCart({commit, state}) {
  commit("clearCart");

  localStorage.cart = JSON.stringify(state.cart)
}
