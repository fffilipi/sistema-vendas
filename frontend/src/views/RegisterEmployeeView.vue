<template>

  <Header />
  <div class="container mx-auto p-4 md:p-6 max-w-lg">
    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
      <h1 class="text-xl md:text-2xl font-bold mb-2 md:mb-0">Cadastrar Vendedor</h1>
      <button @click="goBack" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
        Voltar
      </button>
    </div>

    <!-- Formulário de Cadastro -->
    <form @submit.prevent="registerEmployee" class="bg-white shadow-md rounded-lg p-6">
      <div class="mb-4">
        <label class="block text-gray-700">Nome:</label>
        <input v-model="employee.name" type="text" class="w-full p-2 border rounded-md" required />
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">E-mail:</label>
        <input v-model="employee.email" type="email" class="w-full p-2 border rounded-md" required />
      </div>

      <button 
        type="submit" 
        class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700"
        :disabled="loading"
      >
        {{ loading ? "Cadastrando..." : "Cadastrar" }}
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
      employee: { name: "", email: "" },
      loading: false,
      successMessage: "",
      errorMessage: "",
    };
  },
  methods: {
    async registerEmployee() {
      this.loading = true;
      this.successMessage = "";
      this.errorMessage = "";

      try {
        const token = localStorage.getItem('auth_token');

        const response = await axios.post(
          `${import.meta.env.VITE_API_URL}/api/vendedores`,
          this.employee,
          {
            headers: { Authorization: `Bearer ${token}` }
          }
        );

        if (response.status === 201) {
          this.successMessage = "Vendedor cadastrado com sucesso!";
          this.employee = { nome: "", email: "" };
        }
      } catch (err) {
        this.errorMessage = "Erro ao cadastrar vendedor. Tente novamente.";
      } finally {
        this.loading = false;
      }
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
  input {
    font-size: 14px;
  }
}
</style>
