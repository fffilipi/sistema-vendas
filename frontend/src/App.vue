<template>
  <div class="flex flex-col min-h-screen">
    <Header v-if="shouldShowHeaderFooter" />
    <main class="flex-grow">
      <router-view />
    </main>
    <Footer v-if="shouldShowHeaderFooter" />
  </div>
</template>


<script>
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
import { useRouter } from 'vue-router';

export default {
  components: {
    Header,
    Footer,
  },
  computed: {
    shouldShowHeaderFooter() {
      return this.$route.meta.showHeaderFooter !== false;
    }
  }
};
</script>

<style scoped>
div {
  display: flex;
  flex-direction: column;
}
</style>
