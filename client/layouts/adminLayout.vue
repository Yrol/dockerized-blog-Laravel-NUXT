<template>
  <div class="flex h-screen bg-gray-200 font-roboto">
    <SideBar />

    <div class="flex-1 flex flex-col overflow-hidden">
      <Nav />

      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
        <div class="container mx-auto px-6 py-8">
          <Nuxt />
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import SideBar from '~/components/Dashboard/SideBar';
import Nav from '~/components/Dashboard/Nav';

export default {
  middleware: 'unauthinticated',
  components: { SideBar, Nav },
};
</script>
