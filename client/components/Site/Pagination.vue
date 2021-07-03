<template>
  <div
    v-if="totalPages > 0 && perPage > 0"
    class="bg-white px-4 py-3 flex items-center justify-between sm:px-6"
  >
    <div class="flex-1 flex justify-between sm:hidden">
      <nuxt-link
        :to="{ name: toPageName, params: { page: prevPage } }"
        aria-label="Previous"
        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500"
      >
        Previous
      </nuxt-link>
      <nuxt-link
        :to="{ name: toPageName, params: { page: nextPage } }"
        aria-label="Next"
        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500"
      >
        Next
      </nuxt-link>
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p
          v-if="paginationMeta && paginationMeta.to && paginationMeta.from"
          class="text-sm leading-5 text-gray-700"
        >
          Showing
          <span class="font-medium">{{ paginationMeta.from }}</span>
          to
          <span class="font-medium">{{ paginationMeta.to }}</span>
          of
          <span class="font-medium">{{ total }}</span>
          results
        </p>
      </div>
      <div>
        <nav class="relative z-0 inline-flex shadow-sm">
          <nuxt-link
            :to="{ name: toPageName, params: { page: prevPage } }"
            :class="[previousBtnStyle]"
            aria-label="Previous"
          >
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path
                fill-rule="evenodd"
                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                clip-rule="evenodd"
              />
            </svg>
          </nuxt-link>
          <nuxt-link
            v-for="(item, index) in Array(totalPages)"
            :key="index"
            :to="{ name: toPageName, params: { page: index + 1 } }"
            :class="paginationBtnStyle(index + 1)"
            @click="getPageNumber(index + 1)"
          >
            {{ index + 1 }}
          </nuxt-link>
          <nuxt-link
            :to="{ name: toPageName, params: { page: nextPage } }"
            :class="[nextBtnStyle]"
            aria-label="Next"
          >
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path
                fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"
              />
            </svg>
          </nuxt-link>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Pagination',
  data() {
    return {
      disabled: true,
    };
  },
  props: {
    total: {
      type: Number,
      default: 0,
    },
    perPage: {
      type: Number,
      default: 0,
    },
    toPageName: {
      type: String,
      default: '',
    },
    buttonHighlightColor: {
      type: String,
      default: 'bg-pink-500 border-pink-500',
    },
    paginationMeta: {
      type: Object,
      default: null,
    },
  },
  computed: {
    nextBtnStyle() {
      return {
        'cursor-not-allowed text-gray-300': this.disableNextBtn == true,
        '-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium': true,
        'text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150':
          this.disableNextBtn == false,
      };
    },
    previousBtnStyle() {
      return {
        'cursor-not-allowed text-gray-300': this.disableBtnPrev == true,
        'text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150':
          this.disableBtnPrev == false,
        'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm leading-5 font-medium': true,
      };
    },
    disableBtnPrev() {
      return this.currentPage <= 1 ? true : false;
    },
    disableNextBtn() {
      return this.currentPage >= this.totalPages ? true : false;
    },
    totalPages() {
      return Math.ceil(this.total / this.perPage);
    },
    currentPage() {
      return parseInt(this.$route.params.page) || 1;
    },
    prevPage() {
      return this.currentPage > 1 ? this.currentPage - 1 : 1;
    },
    nextPage() {
      return this.currentPage < this.totalPages
        ? this.currentPage + 1
        : this.totalPages;
    },
  },
  methods: {
    getPageNumber(pNumber) {
      this.$emit('update-pagenumber', pNumber);
    },
    paginationBtnStyle(pageId) {
      var styleObj = {
        '-ml-px relative inline-flex items-center px-4 py-2 border bg-white text-sm leading-5 font-medium': true,
        'text-white hover:text-white focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-white transition ease-in-out duration-150':
          this.currentPage == pageId,
        'text-gray-700 hover:text-gray-500 border-gray-300 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150':
          this.currentPage != pageId,
      };

      styleObj[this.buttonHighlightColor] = this.currentPage == pageId;

      return styleObj;
    },
  },
};
</script>
