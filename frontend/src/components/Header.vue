<template>
  <header class="bg-gray-800 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
      <!-- Botão de Dashboard -->
      <router-link to="/dashboard" class="text-lg font-bold hover:text-gray-300">
        <small>Vamos de 🚀 para o sucesso!</small>
      </router-link>

      <!-- Botão de Sair -->
      <button @click="logout" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
        Sair
      </button>
    </div>
  </header>
</template>

<script>
import axios from "axios";
import { useRouter } from 'vue-router';

export default {
  methods: {
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
          localStorage.removeItem('auth_token');
          this.$router.push({ name: 'Home' });
        }
      } catch (error) {
        // alert('Erro ao tentar deslogar. Por favor, tente novamente.');
        localStorage.removeItem('auth_token');
        this.$router.push({ name: 'Home' });
      }
    }
  },
};
</script>

<style scoped>
/* Estilos do Header */
header {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

button {
  transition: background-color 0.3s;
}

button:hover {
  background-color: #c53030;
}
</style>
