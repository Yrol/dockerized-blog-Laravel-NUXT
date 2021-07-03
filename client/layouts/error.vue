<template>
  <div class="flex flex-col h-screen">
    <Header />
    <div class="flex h-screen justify-center items-center" v-if="error">
      <p class="text-lg text-gray-600">
        {{ `${getError.statusCode + ' | ' + getError.message}` }}
      </p>
    </div>
    <Footer />
  </div>
</template>

<script>
import Header from '~/components/Site/Header';
import Footer from '~/components/Site/Footer';
export default {
  head() {
    return {
      title: `${this.getError.statusCode + ' | ' + this.getError.message}`,
    };
  },
  props: {
    error: {},
  },
  components: {
    Header,
    Footer,
  },
  computed: {
    getError() {
      return { statusCode: this.error.statusCode, message: this.error.message };
    },
  },
};
</script>
