import store from '@/store'
import { useRouter } from '@core/utils/utils'

export const useEcommerce = () => {
  // eslint-disable-next-line arrow-body-style
  const addOfferInWishlist = productId => {
    return store.dispatch('app-ecommerce/addOfferInWishlist', { productId })
  }

  // eslint-disable-next-line arrow-body-style
  const removeOfferFromWishlist = productId => {
    return store.dispatch('app-ecommerce/removeOfferFromWishlist', { productId })
  }

  // eslint-disable-next-line arrow-body-style
  const addProductInCart = productId => {
    return store.dispatch('app-ecommerce/addProductInCart', { productId })
  }

  // eslint-disable-next-line arrow-body-style
  const removeProductFromCart = productId => {
    return store.dispatch('app-ecommerce/removeProductFromCart', { productId })
  }

  return {
    addOfferInWishlist,
    removeOfferFromWishlist,
    addProductInCart,
    removeProductFromCart,
  }
}

export const useEcommerceUi = () => {
  const { router } = useRouter()

  const toggleOfferInWishlist = product => {
    const { addOfferInWishlist, removeOfferFromWishlist } = useEcommerce()
    if (product.isInWishlist) {
      removeOfferFromWishlist(product.id).then(() => {
        // eslint-disable-next-line no-param-reassign
        product.isInWishlist = false
      })
    } else {
      addOfferInWishlist(product.id).then(() => {
        // eslint-disable-next-line no-param-reassign
        product.isInWishlist = true
      })
    }
  }

  const handleOfferActionClick = product => {
    const { addProductInCart } = useEcommerce()

    if (product.isInCart) {
      router.push({ name: 'apps-e-commerce-checkout' })
    } else {
      addProductInCart(product.id).then(() => {
        // eslint-disable-next-line no-param-reassign
        product.isInCart = true

        // Update cart items count
        store.commit('app-ecommerce/UPDATE_CART_ITEMS_COUNT', store.state['app-ecommerce'].cartItemsCount + 1)
      })
    }
  }

  const handleSaveOfferActionClick = (product, removeOfferFromWishlistUi) => {
    const { addProductInCart, removeOfferFromWishlist } = useEcommerce()

    if (product.isInCart) {
      router.push({ name: 'apps-e-commerce-checkout' })
    } else {
      addProductInCart(product.id)
        .then(() => {
          // eslint-disable-next-line no-param-reassign
          product.isInCart = true
          removeOfferFromWishlist(product.id)

          // Update cart items count
          store.commit('app-ecommerce/UPDATE_CART_ITEMS_COUNT', store.state['app-ecommerce'].cartItemsCount + 1)
        })
        .then(() => {
          // eslint-disable-next-line no-param-reassign
          product.isInWishlist = false
          removeOfferFromWishlistUi(product)
        })
    }
  }
  return {
    toggleOfferInWishlist,
    handleOfferActionClick,
    handleSaveOfferActionClick,
  }
}
