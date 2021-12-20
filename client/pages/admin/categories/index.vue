<template>
  <div>
    <div class="mb-4 w-full flex flex-wrap">
      <div class="flex w-1/2">
        <h3 class="text-gray-700 text-3xl font-medium">Categories</h3>
      </div>
      <div class="flex justify-end content-end border-8:transparent w-1/2">
        <Button
          variant="success"
          :loading="false"
          :disableButton="false"
          size="small"
          icon="plus"
          @click="addCategoryModalOpen"
        >
          Add new
        </Button>
      </div>
    </div>
    <div class="mt-4">
      <div v-if="loading">
        <AdminCategoryCard v-for="item in 3" :key="item" :dataReady="false" />
      </div>
      <div class="mt-4" v-else>
        <AdminCategoryCard
          v-for="(category, index) in categories"
          :key="index"
          :dataReady="true"
          @edit-category="editCategoryModalOpen"
          @delete-category="deleteCategoryModalOpen"
          :categoryData="category"
        />
      </div>
    </div>

    <Modal
      :visible="modalStatus.addCategory"
      @close="modalStatus.addCategory = false"
    >
      <ValidationObserver ref="categoryAddForm" v-slot="{ handleSubmit }">
        <form @submit.prevent="handleSubmit(addCategoryAction)">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3
                  class="text-lg leading-6 font-medium text-gray-900"
                  id="modal-headline"
                >
                  Create new category
                </h3>

                <div class="mt-2">
                  <p class="text-sm leading-5 text-gray-500">
                    This action will create a new category.
                  </p>
                  <p class="text-sm leading-5 text-gray-500"></p>
                </div>

                <div class="mt-2">
                  <div class="min-w-full">
                    <FormText
                      rules="required"
                      name="title"
                      label="Category title"
                      placeholder="Category title"
                      class="my-4"
                      icon="folder"
                      v-model="categoryTitle"
                    ></FormText>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
              <Button
                variant="success"
                :loading="modalSubmitting"
                :disableButton="modalSubmitting ? true : false"
                size="small"
                width="full"
              >
                Create
              </Button>
            </span>

            <span
              class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto"
            >
              <Button
                variant="white"
                @click.native="modalStatus.addCategory = false"
                :disableButton="modalSubmitting ? true : false"
                size="small"
                width="full"
              >
                Cancel
              </Button>
            </span>
          </div>
        </form>
      </ValidationObserver>
    </Modal>

    <Modal
      :visible="modalStatus.editCategory"
      @close="modalStatus.editCategory = false"
    >
      <ValidationObserver ref="categoryEditForm" v-slot="{ handleSubmit }">
        <form @submit.prevent="handleSubmit(editCategoryAction)">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3
                  class="text-lg leading-6 font-medium text-gray-900"
                  id="modal-headline"
                >
                  Edit a category
                </h3>

                <div class="mt-2">
                  <p class="text-sm leading-5 text-gray-500">
                    This action will edit an exisiting category.
                  </p>
                  <p class="text-sm leading-5 text-gray-500"></p>
                </div>

                <div class="mt-2">
                  <div class="min-w-full">
                    <FormText
                      rules="required"
                      name="slug"
                      label="Category title"
                      placeholder="Category title"
                      class="my-4"
                      icon="folder"
                      v-model="categoryTitle"
                    ></FormText>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
              <Button
                variant="success"
                :loading="modalSubmitting"
                :disableButton="modalSubmitting ? true : false"
                size="small"
                width="full"
              >
                Update
              </Button>
            </span>

            <span
              class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto"
            >
              <Button
                variant="white"
                @click.native="modalStatus.editCategory = false"
                :disableButton="modalSubmitting ? true : false"
                size="small"
                width="full"
              >
                Cancel
              </Button>
            </span>
          </div>
        </form>
      </ValidationObserver>
    </Modal>
    <Modal
      :visible="modalStatus.deleteCategory"
      @close="modalStatus.deleteCategory = false"
    >
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
                This action will permanently delete the Category.
              </p>
              <p class="text-sm leading-5 text-gray-500">
                {{ deleteCategorySlug }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
          <Button
            variant="danger"
            @click="deleteCategoryConfirmAction()"
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
</template>

<script>
import AdminCategoryCard from '~/components/Dashboard/AdminCategoryCard.vue';
import Button from '~/components/Input/Button';
import agent from '~/api/agent';
import Modal from '~/components/Site/Modal';
import FormText from '~/components/Input/FormText';
import { mapGetters } from 'vuex';
export default {
  name: 'Categories',
  components: {
    Button,
    AdminCategoryCard,
    Modal,
    FormText,
  },
  head: {
    title: 'Categories',
  },
  layout: 'adminLayout',
  computed: {
    ...mapGetters({
      categoryTotal: 'admin/admin-categories/totalCategories',
      categories: 'admin/admin-categories/allCategories',
    }),
  },
  data() {
    return {
      error: false,
      loading: true,
      modalStatus: {
        addCategory: false,
        editCategory: false,
        deleteCategory: false,
      },
      deleteCategorySlug: String,
      modalSubmitting: false,
      categoryTitle: '',
      categorySlug: '',
      categoryId: Number,
    };
  },
  methods: {
    addCategoryModalOpen() {
      this.setModalStatus('addCategory', true);
    },

    editCategoryModalOpen(slug, title) {
      this.setModalStatus('editCategory', true);
      this.categoryTitle = title;
      this.categorySlug = slug;
    },

    deleteCategoryModalOpen(slug) {
      this.setModalStatus('deleteCategory', true);
      this.deleteCategorySlug = slug;
    },

    async addCategoryAction() {
      if (!this.modalStatus.addCategory) {
        return;
      }

      if (this.modalSubmitting) {
        return;
      }

      this.modalSubmitting = true;

      let formData = {
        title: this.categoryTitle,
      };

      try {
        const newCategory = await agent.Categories.create(formData);
        this.$store.dispatch(
          'admin/admin-categories/saveCategory',
          newCategory
        );
        this.setModalStatus('addCategory', false);
      } catch (error) {
        if (error?.data?.errors) {
          let errors = error.data.errors;
          this.$refs?.categoryAddForm?.setErrors(errors || {});
          for (var key in errors) {
            this.$toast.show({
              type: 'danger',
              title: 'Error',
              message: errors[key][0],
            });
          }
        }
      } finally {
        this.modalSubmitting = false;
      }
    },

    async deleteCategoryConfirmAction() {
      if (!this.modalStatus.deleteCategory) {
        return;
      }

      if (this.modalSubmitting) {
        return;
      }

      this.modalSubmitting = true;

      try {
        await agent.Categories.delete(this.deleteCategorySlug);
        this.$store.dispatch('admin/admin-categories/deleteCategory', {
          slug: this.deleteCategorySlug,
        });
        this.setModalStatus('deleteCategory', false);
      } catch (error) {
        if (error?.data?.errors) {
          let errors = error.data.errors;
          this.modalStatus.deleteCategory = false;
          this.$toast.show({
            type: 'danger',
            title: 'Error',
            message: errors['message'],
          });
        }
      } finally {
        this.modalSubmitting = false;
      }
    },

    async editCategoryAction() {
      if (!this.modalStatus.editCategory) {
        return;
      }

      if (this.modalSubmitting) {
        return;
      }

      this.modalSubmitting = true;

      let formData = {
        title: this.categoryTitle,
      };

      try {
        const latestCategoryData = await agent.Categories.update(
          this.categorySlug,
          formData
        );

        let categoryData = {
          latestData: latestCategoryData,
          oldSlug: this.categorySlug,
        };

        this.$store.dispatch(
          'admin/admin-categories/updateCategory',
          categoryData
        );
        this.setModalStatus('editCategory', false);
      } catch (error) {
        if (error?.data?.errors) {
          let errors = error.data.errors;
          this.$refs?.categoryEditForm?.setErrors(errors || {});
          for (var key in errors) {
            this.$toast.show({
              type: 'danger',
              title: 'Error',
              message: errors[key][0],
            });
          }
        }
      } finally {
        this.modalSubmitting = false;
      }
    },

    setModalStatus(modal, status) {
      for (var key in this.modalStatus) {
        if (key == modal) {
          this.modalStatus[key] = status;
          continue;
        }

        this.categoryTitle = '';
        this.categorySlug = '';
        this.categoryId = '';
        this.error = false;
        this.modalSubmitting = false;
        this.modalStatus[key] = false;
      }
    },
    modalNo() {
      this.modalSubmitting = false;
      this.modalStatus.deleteCategory = false;
    },
  },
  async fetch() {
    try {
      this.error = false;
      this.loading = true;
      const categories = await agent.Categories.categories();
      this.$store.dispatch(
        'admin/admin-categories/totalCategories',
        categories.length
      );
      this.$store.dispatch('admin/admin-categories/categories', categories);
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
