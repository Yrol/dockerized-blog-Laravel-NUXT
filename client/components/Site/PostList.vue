<template>
  <div class="flex flex-wrap">
    <div class="w-full md:w-3/4 p-4">
      <Card
        v-for="(post, index) in posts"
        :key="index"
        :dataReady="true"
        :toLocation="toLocation"
        :postData="post"
      />
    </div>
    <div class="w-full md:w-1/4 lg:pl-0 md:pl-0 p-4">
      <CategoriesCard />
    </div>
  </div>
</template>
<script>
import CategoriesCard from '~/components/Site/CategoriesCard';
import Card from '~/components/Site/Card';
export default {
  name: 'PostList',
  components: {
    CategoriesCard,
    Card,
  },
  data() {
    return {
      toLocation: 'posts-slug',
    };
  },
  props: {
    posts: {
      type: Array,
      default: Array,
    },
  },
};
</script>
