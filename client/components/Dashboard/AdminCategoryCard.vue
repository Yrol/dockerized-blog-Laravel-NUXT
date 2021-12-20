<template>
  <div class="w-full lg:flex shadow-lg mb-2">
    <div
      class="w-full bg-white p-4 flex flex-col justify-between leading-normal"
    >
      <div class="mb-3">
        <div
          :class="[
            dataReady
              ? 'text-black font-bold text-xl'
              : 'animate-pulse bg-gray-500 h-6 w-2/4',
          ]"
        >
          <span v-if="dataReady && categoryData.title">{{
            categoryData.title
          }}</span>
        </div>
      </div>
      <div class="mb-4 w-full flex flex-wrap">
        <div
          v-if="dataReady"
          class="border-8:transparent w-full md:w-1/2 lg:w-2/4 md:h-16"
        >
          <div class="text-sm">
            <p class="text-gray-600">
              Slug: <span class="font-semibold">{{ categoryData.slug }} </span>
            </p>
            <p class="text-gray-600">
              Articles:
              <span class="font-semibold"
                >{{ categoryData.articles_count }}
              </span>
            </p>
            <p class="text-gray-600">
              Published:
              <span class="font-semibold"
                >{{ categoryData.created_at_dates.created_at_format_2 }}
              </span>
            </p>
            <p class="text-gray-600">
              Updated:
              <span class="font-semibold"
                >{{ categoryData.updated_at_dates.updated_at_format_2 }}
              </span>
            </p>
          </div>
        </div>
        <div
          v-else
          class="flex flex-wrap items-center h-12 border-8:transparent"
        >
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
          v-if="dataReady"
          class="
            flex flex-wrap
            mt-4
            justify-end
            content-end
            border-8:transparent
            w-full
            md:w-1/2
            lg:w-2/4
          "
        >
          <Button
            variant="primary"
            :loading="false"
            size="small"
            icon="edit"
            @click="editCategory(categoryData.slug, categoryData.title)"
          >
          </Button>
          <Button
            variant="danger"
            :loading="false"
            size="small"
            icon="trash-alt"
            @click="deleteCategory(categoryData.slug)"
          >
          </Button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Button from '~/components/Input/Button';
export default {
  name: 'AdminCategoryCard',
  components: {
    Button,
  },
  props: {
    dataReady: {
      type: Boolean,
      default: false,
    },
    categoryData: {
      type: Object,
    },
  },
  methods: {
    editCategory(slug, title) {
      this.$emit('edit-category', slug, title);
    },

    deleteCategory(slug) {
      this.$emit('delete-category', slug);
    },
  },
};
</script>
