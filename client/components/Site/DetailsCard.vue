<template>
  <div class="w-full lg:flex shadow-lg mb-2">
    <div
      class="w-full bg-white p-4 flex flex-col justify-between leading-normal"
    >
      <div class="mb-3">
        <div class="text-black font-bold text-xl mb-2">
          <span>{{ articleData.title }}</span>
        </div>
        <span>
          <Vue2Editor :editMode="false" v-model="articleData.body"
        /></span>
        <!-- <div class="mb-2 mt-2">
          <a
            class="text-sm text-gray-600 p-1 hover:text-black"
            v-for="(tag, index) in articleData.tag_list[0]"
            :href="`/t/${tag}`"
            :key="`${index}`"
          >
            <span class="text-opacity-50">{{ tag }}</span>
          </a>
        </div> -->
      </div>
      <div class="flex mb-4">
        <div class="flex items-center w-3/4">
          <div class="text-sm">
            <p class="text-gray-600">
              Category:
              <nuxt-link
                :to="'/categories/' + articleData.category.slug"
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
                >{{ articleData.category.title }}</nuxt-link
              >
            </p>
            <p class="text-gray-600">
              Published: {{ articleData.created_at_dates.created_at }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Vue2Editor from '~/components/Input/Vue2Editor';
export default {
  name: 'DetailsCard',
  components: {
    Vue2Editor,
  },
  props: {
    articleData: {},
  },
};
</script>
<style>
.ql-editor {
  padding: 0 !important;
}
.ql-snow {
  border: 0 !important;
}
</style>
