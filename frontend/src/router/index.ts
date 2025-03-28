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
    meta: { showHeaderFooter: true }
  },
  {
    path: '/register-employee',
    name: 'register-employee',
    component: RegisterEmployee
  },
  {
    path: '/register-sale',
    name: 'register-sale',
    component: RegisterSale
  },
  {
    path: '/list-employees',
    name: 'list-employees',
    component: ListEmployees
  },
  {
    path: '/list-sales',
    name: 'list-sales',
    component: ListSales
  },
  {
    path: '/list-sales-by-employee',
    name: 'list-sales-by-employee',
    component: ListSalesByEmployee
  },
  {
    path: '/send-comission-employee',
    name: 'send-comission-employee',
    component: SendComissionEmployee
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
