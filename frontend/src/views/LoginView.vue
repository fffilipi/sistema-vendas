<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const form = ref({
  email: '',
  password: ''
});

const goToRegister = () => {
  router.push('/register');
};

const login = async () => {
  try {
    const response = await axios.post(`${import.meta.env.VITE_API_URL}/api/login`, {
      email: form.value.email,
      password: form.value.password
    });

    if (response.status === 200) {
      localStorage.setItem('auth_token', response.data.token);
      router.push('/dashboard');
    }
  } catch (error) {
    alert('Erro ao tentar fazer login. Verifique suas credenciais e tente novamente.');
  }
};
</script>

<template>
  <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
      <h2 class="text-2xl font-bold text-center text-gray-800">Acesse sua Conta</h2>
      <p class="text-gray-500 text-center mt-2">Bem-vindo de volta! Faça login para continuar.</p>

      <form class="mt-6" @submit.prevent="login">
        <div>
          <label class="block text-gray-700">E-mail</label>
          <input v-model="form.email" type="email" placeholder="Digite seu e-mail"
            class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none" />
        </div>

        <div class="mt-4">
          <label class="block text-gray-700">Senha</label>
          <input v-model="form.password" type="password" placeholder="Digite sua senha"
            class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none" />
        </div>

        <button type="submit"
          class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg mt-6 transition">
          Entrar
        </button>
      </form>

      <p class="text-center text-gray-600 mt-4">
        Ainda não tem uma conta?
        <a href="#" class="text-purple-600 font-bold hover:underline" @click="goToRegister">Cadastre-se</a>
      </p>
    </div>
  </div>
</template>
