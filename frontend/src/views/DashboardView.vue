<template>
  <div class="dashboard-container">

    <div class="header text-center mb-10">
      <p class="text-1xl font-semibold text-gray-800">Tudo que você precisa saber sobre suas vendas 🛒 </p>
    </div>

    <!-- Grid com Cards de Funcionalidades -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Card de Cadastro de Vendedores -->
      <div class="card bg-gray-100 text-gray-700 p-6 rounded-lg shadow-lg transition-transform hover:scale-105 hover:shadow-xl">
        <h2 class="text-2xl font-semibold">Cadastrar Vendedores</h2>
        <p class="mt-4">Cadastre vendedores para gerenciar suas vendas.</p>
        <button @click="navigateTo('register-employee')" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
          Cadastrar Vendedor
        </button>
      </div>

      <!-- Card de Cadastro de Vendas -->
      <div class="card bg-gray-100 text-gray-700 p-6 rounded-lg shadow-lg transition-transform hover:scale-105 hover:shadow-xl">
        <h2 class="text-2xl font-semibold">Cadastrar Vendas</h2>
        <p class="mt-4">Cadastre as vendas realizadas pelos vendedores.</p>
        <button @click="navigateTo('register-sale')" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
          Cadastrar Venda
        </button>
      </div>

      <!-- Card de Enviar Comissões -->
      <div class="card bg-gray-100 text-gray-700 p-6 rounded-lg shadow-lg transition-transform hover:scale-105 hover:shadow-xl">
        <h2 class="text-2xl font-semibold">Enviar Comissões</h2>
        <p class="mt-4">Envie as Comissões do Vendedor por e-mail.</p>
        <button @click="navigateTo('send-comission-employee')" class="mt-4 bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600">
          Enviar e-mail para um vendedor
        </button>
      </div>

       <!-- Card de Listagem de Vendedores -->
      <div class="card bg-gray-100 text-gray-700 p-6 rounded-lg shadow-lg transition-transform hover:scale-105 hover:shadow-xl">
        <h2 class="text-2xl font-semibold">Listar Vendedores</h2>
        <p class="mt-4">Veja a lista de todos os vendedores cadastrados.</p>
        <button @click="navigateTo('list-employees')" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
          Listar Vendedores
        </button>
      </div>

      <!-- Card de Listagem de Vendas -->
      <div class="card bg-gray-100 text-gray-700 p-6 rounded-lg shadow-lg transition-transform hover:scale-105 hover:shadow-xl">
        <h2 class="text-2xl font-semibold">Listar Vendas</h2>
        <p class="mt-4">Veja todas as vendas realizadas no sistema.</p>
        <button @click="navigateTo('list-sales')" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
          Listar Vendas
        </button>
      </div>

       <!-- Card de Listagem de Vendas por Vendedor -->
       <div class="card bg-gray-100 text-gray-700 p-6 rounded-lg shadow-lg transition-transform hover:scale-105 hover:shadow-xl">
        <h2 class="text-2xl font-semibold">Listar Vendas por Vendedor</h2>
        <p class="mt-4">Veja as vendas realizadas por cada vendedor.</p>
        <button @click="navigateTo('list-sales-by-employee')" class="mt-4 bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600">
          Listar Vendas por Vendedor
        </button>
      </div>
    </div>

    <div class="header text-center mt-16 mb-8">
      <h5 class="text-3xl font-semibold text-gray-800">Já vendeu hoje? 💡 Aqui vão algumas dicas!</h5>
    </div>

    <!-- Cards com Dicas de Vendas -->
    <div class="tips-container grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
      <div class="tip-card bg-blue-100 p-6 rounded-lg shadow-lg hover:shadow-2xl transition-all">
        <h2 class="text-xl font-semibold text-gray-800">Dica 1 🔥 </h2>
        <p class="mt-4 text-gray-600">"Entenda as necessidades do cliente e ofereça soluções personalizadas."</p>
      </div>
      <div class="tip-card bg-green-100 p-6 rounded-lg shadow-lg hover:shadow-2xl transition-all">
        <h2 class="text-xl font-semibold text-gray-800">Dica 2 🔥 </h2>
        <p class="mt-4 text-gray-600">"Use a escassez a seu favor, mostre que o produto é limitado ou exclusivo."</p>
      </div>
      <div class="tip-card bg-purple-100 p-6 rounded-lg shadow-lg hover:shadow-2xl transition-all">
        <h2 class="text-xl font-semibold text-gray-800">Dica 3 🔥 </h2>
        <p class="mt-4 text-gray-600">"Foque no benefício que o cliente vai obter, e não apenas no produto."</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  components: {},
  methods: {
    navigateTo(page) {
      this.$router.push({ name: page });
    },
    
    async logout() {
      try {
        const token = localStorage.getItem('auth_token');

        const response = await axios.post(
          `${import.meta.env.VITE_API_URL}/api/logout`, 
          {},
          {
            headers: {
              Authorization: `Bearer ${token}`
            }
          }
        );

        if (response.status === 200) {
          this.$router.push({ name: 'Home' });
        }
      } catch (error) {
        alert('Erro ao tentar deslogar. Por favor, tente novamente.');
      }
    }
  }
};
</script>

<style scoped>
.dashboard-container {
  padding: 30px;
  max-width: 1200px;
  margin: auto;
}

.header h1 {
  color: #2d3748;
}

.carousel-container {
  max-width: 100%;
  overflow: hidden;
}

.carousel {
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

button {
  transition: background-color 0.3s ease;
}

@media (min-width: 1024px) {
  .col-span-1 {
    grid-column: span 1;
  }
  .lg\:col-span-3 {
    grid-column: span 3;
  }
}
</style>