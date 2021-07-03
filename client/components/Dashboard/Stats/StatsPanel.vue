<template>
  <div class="mt-4">
    <div class="flex flex-wrap -mx-6">
      <StatCard
        title="Total Posts"
        :intialCount="totalPosts"
        cardSignature="posts"
      />
      <StatCard
        title="Total Categories"
        :intialCount="totalCategories"
        cardSignature="categories"
      />
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex';
import StatCard from '~/components/Dashboard/Stats/StatCard';
import agent from '~/api/agent';
export default {
  name: 'StatsPanel',
  components: {
    StatCard,
  },
  computed: {
    ...mapGetters({
      totalPosts: 'admin/admin-posts/totalPosts',
      totalCategories: 'admin/admin-categories/totalCategories',
    }),
  },
};
</script>
