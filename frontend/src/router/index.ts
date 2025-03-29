import { createRouter, createWebHistory } from 'vue-router';
import Login from "../views/LoginView.vue";                             // Página de login
import Home from "../views/HomeView.vue";                               // Página inicial  
import Registry from '../views/RegistryView.vue';                       // Página de registro
import Dashboard from '../views/DashboardView.vue';                     // Página de dashboard
import RegisterEmployee from '../views/RegisterEmployeeView.vue';       // Página de cadastro de vendedor
import RegisterSale from '../views/RegisterSaleView.vue';               // Página de cadastro de venda
import ListEmployees from '../views/ListEmployeesView.vue';             // Página de listagem de vendedores
import ListSales from '../views/ListSalesView.vue';                     // Página de listagem de vendas
import ListSalesByEmployee from '../views/ListSalesByEmployeeView.vue'; // Página de listagem de vendas por vendedor
import SendComissionEmployee from '../views/SendComissionEmployeeView.vue'; // Página de listagem de vendas por vendedor

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: { showHeaderFooter: false }
  },
  { 
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { showHeaderFooter: false }
  },
  {
    path: '/register',
    name: 'Register',
    component: Registry,
    meta: { showHeaderFooter: false }
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: { requiresAuth: true }
  },
  {
    path: '/register-employee',
    name: 'register-employee',
    component: RegisterEmployee,
    meta: { requiresAuth: true }
  },
  {
    path: '/register-sale',
    name: 'register-sale',
    component: RegisterSale,
    meta: { requiresAuth: true }
  },
  {
    path: '/list-employees',
    name: 'list-employees',
    component: ListEmployees,
    meta: { requiresAuth: true }
  },
  {
    path: '/list-sales',
    name: 'list-sales',
    component: ListSales,
    meta: { requiresAuth: true }
  },
  {
    path: '/list-sales-by-employee',
    name: 'list-sales-by-employee',
    component: ListSalesByEmployee,
    meta: { requiresAuth: true }
  },
  {
    path: '/send-comission-employee',
    name: 'send-comission-employee',
    component: SendComissionEmployee,
    meta: { requiresAuth: true }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('auth_token');

  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: 'Home' });
  } else {
    next();
  }
});

export default router;
