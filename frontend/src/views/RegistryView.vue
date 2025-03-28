<template>
  <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
      <h2 class="text-2xl font-bold text-center mb-6">Cadastro</h2>
      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
          <label for="name" class="block text-sm font-semibold text-gray-700">Nome</label>
          <input
            v-model="form.name"
            type="text"
            id="name"
            class="mt-1 block w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
            placeholder="Digite seu nome"
          />
          <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</p>
        </div>

        <div class="mb-4">
          <label for="email" class="block text-sm font-semibold text-gray-700">E-mail</label>
          <input
            v-model="form.email"
            type="email"
            id="email"
            class="mt-1 block w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
            placeholder="Digite seu e-mail"
          />
          <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
        </div>

        <div class="mb-6">
          <label for="password" class="block text-sm font-semibold text-gray-700">Senha</label>
          <input
            v-model="form.password"
            type="password"
            id="password"
            class="mt-1 block w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
            placeholder="Digite sua senha"
          />
          <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</p>
        </div>

        <button
          type="submit"
          class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg mt-6 transition"
        >
          Cadastrar
        </button>

        <button
          type="button"
          @click="goToLogin" 
          class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded-lg mt-6 transition"
        >
          Voltar para Login
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  setup() {
    const router = useRouter();

    return {
      router,
      goToLogin: () => router.push({ name: 'Login' })
    };
  },
  data() {
    return {
      form: {
        name: "",
        email: "",
        password: ""
      },
      errors: {
        name: "",
        email: "",
        password: ""
      }
    };
  },
  methods: {
    validateForm() {
      let isValid = true;
      this.errors.name = "";
      this.errors.email = "";
      this.errors.password = "";

      // Validando nome
      if (!this.form.name) {
        this.errors.name = "Nome é obrigatório!";
        isValid = false;
      }

      // Validando e-mail
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!this.form.email || !emailPattern.test(this.form.email)) {
        this.errors.email = "E-mail inválido!";
        isValid = false;
      }

      // Validando senha
      const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[A-Z])(?=.*[!@#$%^&*_])[A-Za-z\d!@#$%^&*]{8,20}$/;
      if (!this.form.password || !passwordPattern.test(this.form.password)) {
        this.errors.password = "A senha deve ter entre 8 e 20 caracteres, incluindo letras maiúsculas, números e ao menos um caractere especial!";
        isValid = false;
      }

      return isValid;
    },

    async handleSubmit() {
      if (this.validateForm()) {
        try {
          const response = await axios.post(`${import.meta.env.VITE_API_URL}/api/register`, {
            name: this.form.name,
            email: this.form.email,
            password: this.form.password
          });

          if (response.status === 201) {
            alert('Cadastro realizado com sucesso!');
            this.$router.push({ name: 'Login' });
          }
        } catch (error) {
          if (error.response && error.response.data && error.response.data.message) {
            alert(error.response.data.message);
          } else {
            alert('Erro desconhecido, tente novamente!');
          }
        }
      }
    }
  }
};
</script>
