<template>
  <div
    v-if="!loadingStatus && !error"
    class="w-full mt-3 px-6 sm:w-1/2 xl:w-1/3 xl:mt-0"
  >
    <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
      <div>
        <font-awesome-icon
          :icon="['fas', 'newspaper']"
          class="fa-fw fa-3x mr-1 fa-square fa-w-14"
        />
      </div>
      <div class="mx-5">
        <div>
          <h4 class="text-2xl font-semibold text-gray-700">
            {{ count }}
          </h4>
        </div>
        <div class="text-gray-500">{{ title }}</div>
      </div>
    </div>
  </div>
  <div v-else-if="error" class="w-full mt-3 px-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
    <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
      <span class="text-sm text-gray-600"
        >An error occurred while loading categories. Click
        <button
          class="text-sm text-gray-600 p-1 focus:outline-none hover:text-black"
          v-on:click="loadData"
        >
          <strong>here</strong>
        </button>
        to reload.</span
      >
    </div>
  </div>
  <div v-else class="w-full mt-3 px-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
    <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
      <div>
        <img class="w-10 h-10 rounded-full mr-4 animate-pulse bg-gray-500" />
      </div>
      <div class="text-sm justify-center">
        <p
          class="text-black mb-3 leading-none w-12 h-2 animate-pulse bg-gray-400"
        ></p>
        <p class="text-grey-dark animate-pulse w-12 h-2 bg-gray-400"></p>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex';
import agent from '~/api/agent';
export default {
  name: 'StatsCard',
  computed: {
    ...mapGetters({
      totalPosts: 'admin/admin-posts/totalPosts',
      totalCategories: 'admin/admin-categories/totalCategories',
    }),
  },
  props: {
    intialCount: {
      type: Number,
      default: false,
    },
    title: {
      type: String,
      default: false,
    },
    cardSignature: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      loadingStatus: false,
      error: false,
      count: 0,
    };
  },
  methods: {
    async fetchCategoryCount() {
      if (this.count > 0) {
        return;
      }

      this.error = false;
      this.loadingStatus = true;

      try {
        let categories = await agent.Categories.categoriesCount();
        this.$store.dispatch(
          'admin/admin-categories/totalCategories',
          categories.count
        );
        this.count = this.totalCategories;
      } catch (error) {
        this.error = true;
      } finally {
        this.loadingStatus = false;
      }
    },

    async fetchArticleCount() {
      if (this.count > 0) {
        return;
      }

      this.error = false;
      this.loadingStatus = true;

      try {
        let posts = await agent.Posts.postCount();
        this.$store.dispatch('admin/admin-posts/totalPosts', posts.count);
        this.count = this.totalPosts;
      } catch (error) {
        this.error = false;
      } finally {
        this.loadingStatus = false;
      }
    },

    loadData() {
      if (!this.cardSignature) {
        return;
      }

      if (this.cardSignature === 'posts') {
        this.fetchArticleCount();
      }

      if (this.cardSignature === 'categories') {
        this.fetchCategoryCount();
      }
    },
  },
  created() {
    this.count = this.intialCount;
    this.loadData();
  },
};
</script>
