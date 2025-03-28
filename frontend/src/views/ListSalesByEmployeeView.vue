<template>
  <div class="container mx-auto p-4 md:p-6">
    <!-- Título e Botão de Voltar -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
      <h1 class="text-xl md:text-2xl font-bold mb-2 md:mb-0">Vendas por Vendedor</h1>
      <button @click="goBack" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
        Voltar
      </button>
    </div>

    <!-- Select para escolher o vendedor -->
    <div class="mb-4">
      <label class="block text-gray-700 mb-1">Selecione um vendedor:</label>
      <select v-model="selectedEmployee" @change="fetchSales" class="w-full p-2 border rounded-md">
        <option value="" disabled>Escolha um vendedor</option>
        <option v-for="employee in employees" :key="employee.id" :value="employee.id">
          {{ employee.name }}
        </option>
      </select>
    </div>

    <!-- Exibe um alerta caso ocorra erro -->
    <div v-if="error" class="bg-red-100 text-red-600 p-3 rounded-md mb-4">
      {{ error }}
    </div>

    <!-- Tabela Responsiva -->
    <div v-if="sales.length > 0" class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
      <table class="w-full border-collapse min-w-[400px]">
        <thead>
          <tr class="bg-gray-200 text-left text-sm md:text-base">
            <th class="p-2 md:p-3">#</th>
            <th class="p-2 md:p-3">Valor</th>
            <th class="p-2 md:p-3">Data da Venda</th>
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
            <td class="p-2 md:p-3">R$ {{ sale.value }}</td>
            <td class="p-2 md:p-3">{{ formatDate(sale.sale_date) }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Mensagem caso não tenha vendas -->
    <p v-if="sales.length === 0 && selectedEmployee && !error" class="text-gray-500 mt-4 text-center">
      Nenhuma venda encontrada para este vendedor.
    </p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      employees: [],
      sales: [],
      selectedEmployee: "",
      error: null
    };
  },
  async created() {
    await this.fetchEmployees();
  },
  methods: {
    // Buscar lista de vendedores
    async fetchEmployees() {
      try {
        const token = localStorage.getItem('auth_token');
        const response = await axios.get(`${import.meta.env.VITE_API_URL}/api/vendedores`, {
          headers: { Authorization: `Bearer ${token}` }
        });

        this.employees = response.data;
      } catch (err) {
        this.error = "Erro ao carregar vendedores.";
      }
    },

    async fetchSales() {
      if (!this.selectedEmployee) return;

      try {
        this.error = null;
        const token = localStorage.getItem('auth_token');
        const response = await axios.get(`${import.meta.env.VITE_API_URL}/api/vendas/vendedor/${this.selectedEmployee}`, {
          headers: { Authorization: `Bearer ${token}` }
        });

        this.sales = response.data;
      } catch (err) {
        this.error = "Erro ao carregar vendas.";
      }
    },

    // Formatar a data da venda
    formatDate(dateString) {
      const options = { year: "numeric", month: "long", day: "numeric" };
      return new Date(dateString).toLocaleDateString("pt-BR", options);
    },

    // Voltar para a página anterior
    goBack() {
      this.$router.go(-1);
    }
  }
};
</script>

<style>
@media (max-width: 640px) {
  table {
    font-size: 14px;
  }
}
</style>
