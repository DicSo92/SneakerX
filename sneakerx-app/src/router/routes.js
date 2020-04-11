
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
      }
    ],
  },
  {
    path: '/dashboard',
    component: () => import('layouts/DashboardLayout.vue'),
    children: [
      {
        path: '/dashboard/home',
        name: 'home_admin',
        component: () => import('pages/dashboard/Home.vue'),
        meta: { requiresAdmin: true }
      }
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
