
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        name: 'home',
        component: () => import('pages/Home.vue'),
        meta: { requiresAuth: true }
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
