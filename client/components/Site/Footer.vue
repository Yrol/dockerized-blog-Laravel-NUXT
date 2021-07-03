<template>
  <footer>
    <div
      class="flex flex-wrap items-center justify-center px-2 py-3 bg-blue-500"
    >
      <span
        class="text-xs font-bold items-center text-white leading-snug hover:opacity-75"
      >
        {{ `Yrol Fernando &copy ${new Date().getFullYear()}` }}
      </span>
    </div>
  </footer>
</template>
<script>
export default {
  name: 'SiteFooter',
};
</script>
