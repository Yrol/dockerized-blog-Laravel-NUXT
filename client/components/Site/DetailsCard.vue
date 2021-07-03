<template>
  <div class="w-full lg:flex shadow-lg mb-2">
    <div
      class="w-full bg-white p-4 flex flex-col justify-between leading-normal"
    >
      <div class="mb-3">
        <div class="text-black font-bold text-xl mb-2">
          <span>{{ articleData.title }}</span>
        </div>
        <span
          class="text-grey-darker text-base"
          v-html="articleData.body"
        ></span>
        <div class="mb-2 mt-2">
          <a
            class="text-sm text-gray-600 p-1 hover:text-black"
            v-for="(tag, index) in articleData.tag_list[0]"
            :href="`/t/${tag}`"
            :key="`${index}`"
          >
            <span class="text-opacity-50">{{ tag }}</span>
          </a>
        </div>
      </div>
      <div class="flex mb-4">
        <div class="flex items-center w-3/4">
          <div class="text-sm">
            <p class="text-gray-600">
              Category:
              <span
                class="text-xs mb-2 font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 uppercase last:mr-0 mr-1"
              >
                {{ articleData.category.title }}
              </span>
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
export default {
  name: 'DetailsCard',
  props: {
    articleData: {},
  },
};
</script>
