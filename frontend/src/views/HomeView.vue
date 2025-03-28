<script setup>
import { useRouter } from 'vue-router';
import { useMotion } from '@vueuse/motion';

const router = useRouter();

const goToLogin = () => {
  router.push('/login');
};
</script>

<template>
  <div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center p-6">
    <h1 
      v-motion 
      :initial="{ opacity: 0, y: -50 }" 
      :enter="{ opacity: 1, y: 0 }" 
      class="text-5xl font-extrabold"
    >
      Bem-vindo ao Sistema de Vendas!
    </h1>
    <p 
      v-motion 
      :initial="{ opacity: 0, y: 20 }" 
      :enter="{ opacity: 1, y: 0 }" 
      class="mt-4 text-lg"
    >
      Gerencie suas vendas de forma simples e eficiente.
    </p>

    <button 
      v-motion 
      :hover="{ scale: 1.1 }" 
      :tap="{ scale: 0.9 }" 
      class="mt-8 bg-white text-purple-600 px-6 py-3 rounded-full text-lg font-semibold shadow-lg hover:bg-purple-100 transition"
      @click="goToLogin"
    >
      Comece Agora
    </button>
  </div>
</template>
