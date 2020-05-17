export function changeCart(state, newCart) {
  state.cart = newCart
}
export function removeProduct(state, productIndex) {
  state.cart.splice(productIndex, 1)
}
export function pushCart(state, product) {
  state.cart.push(product)
}
export function updateTotalCart(state, {index, total}) {
  state.cart[index].total += total
}
export function clearCart(state) {
  state.cart = []
}
