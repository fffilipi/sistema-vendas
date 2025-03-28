<template>
  <div class="container mx-auto p-4 md:p-6 max-w-lg">
    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
      <h1 class="text-xl md:text-2xl font-bold mb-2 md:mb-0">Cadastrar Venda</h1>
      <button @click="goBack" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
        Voltar
      </button>
    </div>

    <form @submit.prevent="registerSale" class="bg-white shadow-md rounded-lg p-6">
      <div class="mb-4">
        <label class="block text-gray-700">Selecione o vendedor</label>
        <select v-model="sale.employee_id" class="w-full p-2 border rounded-md" required>
          <option value="" disabled>Selecione</option>
          <option v-for="employee in employees" :key="employee.id" :value="employee.id">
            {{ employee.name }}
          </option>
        </select>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Valor da venda (R$):</label>
        <input
          v-model="sale.value"
          @input="formatCurrency"
          type="text"
          class="w-full p-2 border rounded-md"
          placeholder="0,00"
          required
        />
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Data da venda:</label>
        <input
          v-model="sale.sale_date"
          @input="formatDate"
          class="w-full p-2 border rounded-md"
          placeholder="dd/mm/aaaa"
          required
        />
      </div>

      <button 
        type="submit" 
        class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700"
        :disabled="loading"
      >
        {{ loading ? "Registrando " : "Cadastro de venda" }}
      </button>

      <p v-if="successMessage" class="text-green-600 mt-4 text-center">
        {{ successMessage }}
      </p>

      <p v-if="errorMessage" class="text-red-600 mt-4 text-center">
        {{ errorMessage }}
      </p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      sale: { employee_id: "", value: "", sale_date: "" },
      employees: [],
      loading: false,
      successMessage: "",
      errorMessage: "",
    };
  },
  async created() {
    await this.loadEmployees();
  },
  methods: {
    async loadEmployees() {
      try {
        const token = localStorage.getItem('auth_token');
        const response = await axios.get(`${import.meta.env.VITE_API_URL}/api/vendedores`, {
          headers: { Authorization: `Bearer ${token}` }
        });

        this.employees = response.data;
      } catch (error) {
        console.error("Erro ao carregar vendedor:", error);
      }
    },

    // Formatar valor para moeda brasileira
    formatCurrency() {
      let value = this.sale.value.replace(/\D/g, ""); // Remove tudo que não for número
      value = (parseFloat(value) / 100).toFixed(2); // Converte para decimal
      this.sale.value = value.replace(".", ","); // Troca ponto por vírgula
    },

    // Formatar data para dd/mm/aaaa
    formatDate() {
      let value = this.sale.sale_date.replace(/\D/g, ""); // Remove caracteres não numéricos

      if (value.length > 2) value = value.replace(/^(\d{2})(\d)/, "$1/$2");
      if (value.length > 5) value = value.replace(/^(\d{2})\/(\d{2})(\d)/, "$1/$2/$3");

      this.sale.sale_date = value;
    },

    async registerSale() {
      this.loading = true;
      this.successMessage = "";
      this.errorMessage = "";

      try {
        const token = localStorage.getItem('auth_token');

         // Convertendo os dados antes do envio
         const saleData = {
          employee_id: this.sale.employee_id,
          value: this.sale.value.replace(",", "."),
          sale_date: this.sale.sale_date.split("/").reverse().join("-")
        };

        const response = await axios.post(
          `${import.meta.env.VITE_API_URL}/api/vendas`,
          saleData,
          {
            headers: { Authorization: `Bearer ${token}` }
          }
        );

        if (response.status === 201) {
          this.successMessage = "Venda cadastrada com sucesso!";
          this.sale = { employee_id: "", value: "", sale_date: "" };
        }
      } catch (err) {
        this.errorMessage = "Erro ao cadastrar venda. Por favor, tente novamente.";
      } finally {
        this.loading = false;
      }
    },

    goBack() {
      this.$router.go(-1);
    }
  }
};
</script>

<style>
@media (max-width: 640px) {
  input, select {
    font-size: 14px;
  }
}
</style>
