
const routes = [
  {
    path: '/',
    component: () => import('layouts/ClientLayout.vue'),
    children: [
      {
        path: '',
        name: 'home',
        component: () => import('pages/Home.vue'),
        // meta: { requiresAuth: true }
      },
      {
        path: '/auth',
        name: 'auth',
        component: () => import('pages/Auth.vue'),
        meta: { requiresVisitor: true }
      },
      {
        path: 'catalog',
        name: 'catalog',
        component: () => import('pages/client/Catalog.vue'),
        // meta: { requiresVisitor: true }
      },
      {
        path: 'catalog/:slug',
        name: 'product',
        props: true,
        component: () => import('pages/client/Product.vue'),
        // meta: { requiresVisitor: true }
      },
      {
        path: 'news',
        name: 'news',
        component: () => import('pages/client/News.vue'),
        // meta: { requiresVisitor: true }
      },
      {
        path: 'contact',
        name: 'contact',
        component: () => import('pages/client/Contact.vue'),
        // meta: { requiresVisitor: true }
      },
      {
        path: 'cart',
        name: 'cart',
        component: () => import('pages/client/Cart.vue'),
        // meta: { requiresVisitor: true }
      },
      {
        path: 'orderConfirmation/:orderId',
        name: 'orderConfirmation',
        props: true,
        component: () => import('pages/client/OrderConfirmation.vue'),
        // meta: { requiresVisitor: true }
      }
    ],
  },
  {
    path: '/dashboard',
    component: () => import('layouts/DashboardLayout.vue'),
    meta: { requiresAdmin: true },
    children: [
      {
        path: '',
        name: 'home_admin',
        component: () => import('pages/dashboard/Home.vue'),
      },
      {
        path: 'users',
        name: 'users_admin',
        component: () => import('pages/dashboard/Users.vue'),
      },
      {
        path: 'news',
        name: 'news_admin',
        component: () => import('pages/dashboard/News.vue'),
      },
      {
        path: 'brands',
        name: 'brands_admin',
        component: () => import('pages/dashboard/Brands.vue'),
      },
      {
        path: 'products',
        name: 'products_admin',
        component: () => import('pages/dashboard/Products.vue'),
      },
      {
        path: 'orders',
        name: 'orders_admin',
        component: () => import('pages/dashboard/Orders.vue'),
      },
      {
        path: 'roles',
        name: 'roles_admin',
        component: () => import('pages/dashboard/Roles.vue'),
      },
      {
        path: 'activityLogs',
        name: 'activityLogs_admin',
        component: () => import('pages/dashboard/ActivityLogs.vue'),
      },
    ],
  }
]

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue')
  })
}

export default routes
