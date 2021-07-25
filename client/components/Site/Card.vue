<template>
  <div class="w-full lg:flex shadow-lg mb-2">
    <div
      class="w-full bg-white p-4 flex flex-col justify-between leading-normal"
    >
      <div class="mb-3">
        <div
          :class="[
            dataReady
              ? 'text-black font-bold text-xl mb-2'
              : 'animate-pulse bg-gray-500 mb-2 h-6 w-2/4',
          ]"
        >
          <span v-if="dataReady && postData.title">{{ postData.title }}</span>
        </div>
        <div
          v-if="dataReady"
          v-html="getBodyText(postData.description)"
          class="text-grey-darker text-base"
        ></div>
        <div v-else>
          <p
            class="leading-relaxed mb-3 w-full h-3 animate-pulse bg-gray-400"
          ></p>
          <p
            class="leading-relaxed mb-3 w-full h-3 animate-pulse bg-gray-400"
          ></p>
          <p
            class="leading-relaxed mb-3 w-full h-3 animate-pulse bg-gray-400"
          ></p>
        </div>

        <div v-if="dataReady" class="mb-2 mt-2">
          <a
            class="text-sm text-gray-600 p-1 hover:text-black"
            v-for="(tag, index) in tags"
            :href="`/t/${tag}`"
            :key="`${index}`"
          >
            <span class="text-opacity-50">{{ tag }}</span>
          </a>
        </div>
      </div>
      <div class="mb-4 w-full flex flex-wrap">
        <div
          v-if="dataReady"
          class="h-16 border-8:transparent w-full md:w-1/2 lg:w-1/4 md:h-16"
        >
          <div class="text-sm">
            <!-- <p class="text-black leading-none">{{ author }}</p> -->
            <p class="text-gray-600">
              Category:
              <nuxt-link
                :to="'/categories/' + postData.category.slug"
                class="
                  text-xs
                  mb-2
                  font-semibold
                  inline-block
                  py-1
                  px-2
                  uppercase
                  rounded-full
                  text-pink-600
                  bg-pink-200
                  uppercase
                  last:mr-0
                  mr-1
                "
                >{{ postData.category.title }}</nuxt-link
              >
            </p>
            <p class="text-gray-600">
              Published: {{ postData.created_at_dates.created_at }}
            </p>
          </div>
        </div>
        <div
          v-else
          class="flex flex-wrap items-center h-12 border-8:transparent"
        >
          <div>
            <img
              class="w-10 h-10 rounded-full mr-4 animate-pulse bg-gray-500"
            />
          </div>
          <div class="text-sm justify-center">
            <p
              class="
                text-black
                mb-3
                leading-none
                w-12
                h-2
                animate-pulse
                bg-gray-400
              "
            ></p>
            <p class="text-grey-dark animate-pulse w-12 h-2 bg-gray-400"></p>
          </div>
        </div>
        <div
          v-if="dataReady && toLocation && postData.slug"
          class="
            md:flex
            flex-wrap
            md:justify-end
            md:content-end
            md:h-16
            border-8:transparent
            w-full
            md:w-1/2
            lg:w-3/4
          "
        >
          <nuxt-link
            :to="{
              name: toLocation,
              params: {
                slug: postData.slug,
              },
            }"
            class="
              bg-blue-900
              lg:w-1/4
              flex
              h-10
              flex-wrap
              items-center
              justify-center
              text-white
              active:bg-pink-600
              font-bold
              uppercase
              text-xs
              px-4
              py-2
              rounded-full
              shadow
              hover:shadow-md
              outline-none
              focus:outline-none
              mr-1
              mb-1
            "
            style="transition: all 0.15s ease"
          >
            <font-awesome-icon
              :icon="['fas', 'book-reader']"
              class="fa-fw fa-lg mr-1 fa-square fa-w-14"
            /><span>Read more </span>
          </nuxt-link>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Card',
  props: {
    tags: {
      type: Array,
      default: () => [],
    },
    dataReady: {
      type: Boolean,
      default: false,
    },
    toLocation: {
      type: String,
      default: '',
    },
    postData: {},
  },
  computed: {
    bodyText() {
      return this.body;
    },
  },
  methods: {
    getBodyText(str) {
      let wordCount = str.match(/(\w+)/g).length;
      if (wordCount > 30) {
        return str.replace(/(([^\s]+\s\s*){30})(.*)/, '$1…');
      }
      return str;
    },
  },
};
</script>
