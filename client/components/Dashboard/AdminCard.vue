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
        <span
          v-if="dataReady"
          v-html="getBodyText(postData.description)"
          class="text-grey-darker text-base"
        ></span>
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
          class="h-16 border-8:transparent w-full md:w-1/2 lg:w-2/4 md:h-16"
        >
          <div class="text-sm">
            <!-- <p class="text-black leading-none">{{ author }}</p> -->
            <p class="text-gray-600">
              Category:
              <span
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
              >
                {{ postData.category.title }}
              </span>
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
          v-if="dataReady"
          class="
            md:flex
            flex-wrap
            md:justify-end
            md:content-end
            md:h-16
            border-8:transparent
            w-full
            md:w-1/2
            lg:w-2/4
          "
        >
          <Button
            variant="success"
            :loading="updatingPublishStatus"
            :disableButton="updatingPublishStatus"
            size="small"
            @click="updatePublishStatus()"
          >
            {{ isLive == 0 ? 'Publish' : 'Unpublish' }}
          </Button>
          <Button
            variant="primary"
            :loading="false"
            :disableButton="updatingPublishStatus"
            size="small"
            icon="edit"
            @click="goToEdit()"
          >
          </Button>
          <Button
            variant="danger"
            :loading="false"
            :disableButton="updatingPublishStatus"
            size="small"
            icon="trash-alt"
            @click="deletePost(postData.slug, postData.id)"
          >
          </Button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import agent from '~/api/agent';
import Button from '~/components/Input/Button';
import { mapGetters } from 'vuex';
export default {
  name: 'Card',
  components: {
    Button,
  },
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
    postData: {
      type: Object,
    },
  },
  data() {
    return {
      updatingPublishStatus: false,
    };
  },
  computed: {
    ...mapGetters({
      postStatus: 'admin/admin-posts/postStatus',
    }),
    isLive() {
      return this.postStatus(this.postData.id);
    },
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
    async updatePublishStatus() {
      this.updatingPublishStatus = true;
      let formData = new FormData();
      formData.append('is_live', this.isLive == 0 ? 1 : 0);
      try {
        let update = await agent.Posts.updateStatus(
          formData,
          this.postData.slug
        );
        let isLiveStatus = update.is_live;
        console.log(isLiveStatus);
        if (isLiveStatus == 1 || isLiveStatus == 0) {
          this.$store.dispatch('admin/admin-posts/postStatus', {
            id: this.postData.id,
            state: parseInt(isLiveStatus),
          });
        }
      } catch (error) {
        if (error?.data?.errors) {
          let errors = error.data.errors;
          for (var key in errors) {
            this.$toast.show({
              type: 'danger',
              title: 'Error',
              message: errors[key][0],
            });
          }
        }
      } finally {
        this.updatingPublishStatus = false;
      }
    },

    goToEdit() {
      this.$router.push({
        name: 'admin-edit-slug',
        params: { slug: this.postData.slug },
      });
    },

    deletePost(slug, id) {
      this.$emit('delete-post', slug, id);
    },
  },
};
</script>
