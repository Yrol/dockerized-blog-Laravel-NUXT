<template>
  <div>
    <h3 class="text-gray-700 text-3xl font-medium">All Posts</h3>
    <div v-if="loading">
      <AdminCard v-for="item in 3" :key="item" :dataReady="false" />
    </div>
    <div v-else>
      <AdminCard
        v-for="(post, index) in currentPagePosts"
        :key="index"
        @delete-post="deletePost"
        :dataReady="true"
        :postData="post"
      />
    </div>
    <div class="flex flex-wrap">
      <Modal :visible="showModal" @close="showModal = false">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div
              class="
                mx-auto
                flex-shrink-0 flex
                items-center
                justify-center
                h-12
                w-12
                rounded-full
                bg-red-100
                sm:mx-0 sm:h-10 sm:w-10
              "
            >
              <svg
                class="h-6 w-6 text-red-600"
                stroke="currentColor"
                fill="none"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                />
              </svg>
            </div>

            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3
                class="text-lg leading-6 font-medium text-gray-900"
                id="modal-headline"
              >
                Are you sure?
              </h3>

              <div class="mt-2">
                <p class="text-sm leading-5 text-gray-500">
                  This action will permanently delete the post.
                </p>
                <p class="text-sm leading-5 text-gray-500">
                  {{ deletePostSlug }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <Button
              variant="danger"
              @click="deletePostConfirmAction()"
              :loading="modalSubmitting"
              :disableButton="modalSubmitting ? true : false"
              size="small"
              width="full"
            >
              Yes, Proceed
            </Button>
          </span>

          <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <Button
              variant="white"
              @click="modalNo()"
              :disableButton="modalSubmitting ? true : false"
              size="small"
              width="full"
            >
              No
            </Button>
          </span>
        </div>
      </Modal>
    </div>
    <div class="flex flex-wrap border-t border-gray-200">
      <div class="w-full">
        <Pagination
          :total="totalPosts"
          :perPage="perPage"
          :paginationMeta="paginationMeta"
          toPageName="admin-posts-page-page"
          buttonHighlightColor="bg-blue-500"
        />
      </div>
    </div>
  </div>
</template>
<script>
import AdminCard from '~/components/Dashboard/AdminCard';
import Modal from '~/components/Site/Modal';
import Button from '~/components/Input/Button';
import agent from '~/api/agent';
import Pagination from '~/components/Site/Pagination';
import { mapGetters } from 'vuex';
export default {
  name: 'AllPosts',
  head: {
    title: 'All Posts',
  },
  layout: 'adminLayout',
  components: {
    AdminCard,
    Pagination,
    Modal,
    Button,
  },
  computed: {
    ...mapGetters({
      totalPosts: 'admin/admin-posts/totalPosts',
      perPage: 'admin/admin-posts/perPagePosts',
      currentPagePosts: 'admin/admin-posts/allPosts',
    }),
  },
  data() {
    return {
      error: false,
      loading: true,
      showModal: false,
      modalSubmitting: false,
      deletePostSlug: String,
      paginationFrom: Number,
      paginationTo: Number,
      paginationMeta: {
        type: Object,
        default: null,
      },
    };
  },
  methods: {
    deletePost(slug) {
      this.deletePostSlug = slug;
      this.showModal = true;
    },
    async deletePostConfirmAction() {
      this.modalSubmitting = true;
      try {
        await agent.Posts.delete(this.deletePostSlug);
        this.$store.dispatch('admin/admin-posts/deletePost', {
          slug: this.deletePostSlug,
        });
      } catch (error) {
        if (error?.data?.errors) {
          let errors = error.data.errors;
          for (var key in errors) {
            this.$toast.show({
              type: 'danger',
              title: 'Error',
              message: errors[key],
            });
          }
        }
      } finally {
        this.modalSubmitting = false;
        this.showModal = false;
      }
    },
    modalNo() {
      this.modalSubmitting = false;
      this.showModal = false;
    },
  },
  async fetch() {
    try {
      this.error = false;
      this.loading = true;
      let posts = await agent.Posts.adminAll(
        isNaN(this.$route.params.page) ? 1 : this.$route.params.page
      );
      let meta = { to: posts.meta.to, from: posts.meta.from };
      this.paginationMeta = meta;
      this.$store.dispatch('admin/admin-posts/totalPosts', posts?.meta?.total);
      this.$store.dispatch(
        'admin/admin-posts/perPagePosts',
        posts?.meta?.per_page
      );
      this.$store.dispatch('admin/admin-posts/posts', posts);
    } catch (error) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  },
  fetchOnServer: false,
  fetchDelay: 0,
};
</script>
