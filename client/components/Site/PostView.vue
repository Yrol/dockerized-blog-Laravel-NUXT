<template>
  <div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <DetailsCard :articleData="articleData" />
      </div>
      <div class="w-ful md:w-1/4 lg:pl-0 md:pl-0 p-4">
        <CategoriesCard />
      </div>
    </div>
  </div>
</template>
<script>
import CategoriesCard from '~/components/Site/CategoriesCard';
import DetailsCard from '~/components/Site/DetailsCard';
export default {
  name: 'PostView',
  components: {
    CategoriesCard,
    DetailsCard,
  },
  props: {
    articleData: {},
  },
};
</script>
