<template>
  <div class="container mx-auto p-4 md:p-6">
    <!-- Título e Botões -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
      <h1 class="text-xl md:text-2xl font-bold mb-2 md:mb-0">Lista de Vendas</h1>
      <div class="flex gap-2">
        <!-- Botão de Voltar -->
        <button @click="goBack" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
          Voltar
        </button>

        <!-- Botão de Adicionar Nova Venda -->
        <button @click="navigateTo('register-sale')" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
          Adicionar Venda
        </button>
      </div>
    </div>

    <!-- Exibe um alerta caso ocorra erro ao buscar venda -->
    <div v-if="error" class="bg-red-100 text-red-600 p-3 rounded-md mb-4">
      {{ error }}
    </div>

    <!-- Tabela Responsiva -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
      <table class="w-full border-collapse min-w-[400px]">
        <thead>
          <tr class="bg-gray-200 text-left text-sm md:text-base">
            <th class="p-2 md:p-3">#</th>
            <th class="p-2 md:p-3">Vendedor</th>
            <th class="p-2 md:p-3">Valor da venda</th>
            <th class="p-2 md:p-3">Data da venda</th>
          </tr>
        </thead>
        <tbody>
          <tr 
            v-for="(sale, index) in sales" 
            :key="sale.id" 
            :class="index % 2 === 0 ? 'bg-gray-100' : 'bg-white'"
            class="border-b text-sm md:text-base"
          >
            <td class="p-2 md:p-3">{{ index + 1 }}</td>
            <td class="p-2 md:p-3">{{ sale.employee.name }}</td>
            <td class="p-2 md:p-3 break-words max-w-[150px]">R$ {{ sale.value }}</td>
            <td class="p-2 md:p-3">{{ formatDate(sale.sale_date) }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Caso não haja vendas -->
    <p v-if="sales.length === 0 && !error" class="text-gray-500 mt-4 text-center">
      Nenhuma venda encontrada.
    </p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      sales: [],
      error: null
    };
  },
  async created() {
    await this.fetchSales();
  },
  methods: {
    async fetchSales() {
      try {
        const token = localStorage.getItem('auth_token');
        if (!token) {
          this.error = "Token de autenticação não encontrado. Faça login novamente.";
          return;
        }

        const response = await axios.get(`${import.meta.env.VITE_API_URL}/api/vendas`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        this.sales = response.data;
      } catch (err) {
        this.error = "Erro ao buscar vendas. Tente novamente.";
        console.error(err);
      }
    },

    // Função para formatar a data de criação
    formatDate(dateString) {
      const options = { year: "numeric", month: "long", day: "numeric" };
      return new Date(dateString).toLocaleDateString("pt-BR", options);
    },

    // Função para voltar para a página anterior
    goBack() {
      this.$router.go(-1);
    },

    // Navega para uma rota específica
    navigateTo(route) {
      this.$router.push({ name: route });
    }
  }
};
</script>

<style>
/* Melhorando a responsividade */
@media (max-width: 640px) {
  table {
    font-size: 14px;
  }
}
</style>
