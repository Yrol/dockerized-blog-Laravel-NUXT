<template>
  <div>
    <h3 class="text-gray-700 text-3xl font-medium">Dashboard</h3>
    <StatsPanel />
  </div>
</template>
<script>
import StatsPanel from '~/components/Dashboard/Stats/StatsPanel';
export default {
  name: 'Admin',
  head: {
    title: 'Admin',
  },
  layout: 'adminLayout',
  components: {
    StatsPanel,
  },
  data() {
    return {};
  },
};
</script>
