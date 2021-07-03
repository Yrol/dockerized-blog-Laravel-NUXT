<template>
  <div class="flex flex-col h-screen">
    <Header />
    <div class="mb-auto flex flex-wrap">
      <div class="w-full p-4">
        <CategoriesCard />
      </div>
    </div>
    <Footer />
  </div>
</template>
<script>
import Header from '~/components/Site/Header';
import Footer from '~/components/Site/Footer';
import CategoriesCard from '~/components/Site/CategoriesCard';
export default {
  name: 'Categories',
  head: {
    title: 'Categories',
  },
  components: {
    Header,
    Footer,
    CategoriesCard,
  },
};
</script>
