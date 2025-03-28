<template>
    <div class="container mx-auto p-4 md:p-6 max-w-lg">
      <div class="flex flex-col md:flex-row justify-between items-center mb-4">
        <h1 class="text-xl md:text-2xl font-bold mb-2 md:mb-0">Enviar email com Comissão</h1>
        <button @click="goBack" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
          Voltar
        </button>
      </div>
      <form @submit.prevent="sendEmail" class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-4">
          <label class="block text-gray-700">Selecione o Vendedor:</label>
          <select v-model="selectedSeller" class="w-full p-2 border rounded-md" required>
            <option value="" disabled>Selecione um vendedor</option>
            <option v-for="seller in sellers" :key="seller.id" :value="seller.id">
              {{ seller.name }}
            </option>
          </select>
        </div>
  
        <button 
          type="submit" 
          class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700"
          :disabled="loading"
        >
          {{ loading ? "Enviando..." : "Enviar Comissão" }}
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
  import axios from "axios";
  
  export default {
    data() {
      return {
        selectedSeller: "",
        sellers: [],
        loading: false,
        successMessage: "",
        errorMessage: "",
      };
    },
    async created() {
      await this.loadSellers();
    },
    methods: {
      async loadSellers() {
        try {
          const token = localStorage.getItem("auth_token");
          const response = await axios.get(`${import.meta.env.VITE_API_URL}/api/vendedores`, {
            headers: { Authorization: `Bearer ${token}` },
          });
  
          this.sellers = response.data;
        } catch (error) {
          console.error("Erro ao carregar vendedores:", error);
        }
      },
  
      async sendEmail() {
        if (!this.selectedSeller) {
          this.errorMessage = "Selecione um vendedor!";
          return;
        }
  
        this.loading = true;
        this.successMessage = "";
        this.errorMessage = "";
  
        try {
          const token = localStorage.getItem("auth_token");
          const url = `${import.meta.env.VITE_API_URL}/api/reenvio-comissao/${this.selectedSeller}`;

          const response = await axios.post(url, {}, {
            headers: { Authorization: `Bearer ${token}` },
          });
  
          if (response.status === 200) {
            this.successMessage = "E-mail de comissão reenviado com sucesso!";
          }
        } catch (err) {
          this.errorMessage = "Erro ao reenviar e-mail. Tente novamente.";
        } finally {
          this.loading = false;
        }
      },

      goBack() {
        this.$router.go(-1);
      },
    },
  };
  </script>
  
  <style>
  @media (max-width: 640px) {
    input, select {
      font-size: 14px;
    }
  }
  </style>
  