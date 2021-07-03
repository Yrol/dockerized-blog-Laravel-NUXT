<template>
  <div>
    <client-only>
      <div v-if="isLoading">
        <AdminLoader title="Loading..." />
      </div>
      <div v-else>
        <h3 class="text-gray-700 text-3xl font-medium">New Post</h3>
        <ValidationObserver ref="postForm" v-slot="{ handleSubmit }">
          <form @submit.prevent="handleSubmit(submitPost)">
            <div class="min-w-full">
              <FormText
                rules="required"
                name="title"
                label="Post title"
                placeholder="Post title"
                class="my-4"
                icon="newspaper"
                v-model="postTitle"
              ></FormText>
            </div>
            <div class="min-w-full">
              <DropDown
                name="category_id"
                label="Category"
                rules="required"
                icon="folder"
                placeholder="Please choose a category"
                :options="categoriesList"
                class="my-4"
                v-model="postCategory"
              />
            </div>
            <div class="min-w-full">
              <div
                class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal"
              >
                <div class="mb-8">
                  <p class="text-sm text-gray-600 flex items-center">
                    <svg
                      class="fill-current text-gray-500 w-3 h-3 mr-2"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                    >
                      <path
                        d="M4 8V6a6 6 0 1 1 12 0v2h1a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h1zm5 6.73V17h2v-2.27a2 2 0 1 0-2 0zM7 6v2h6V6a3 3 0 0 0-6 0z"
                      />
                    </svg>
                    Body content
                  </p>
                  <div>
                    <Vue2Editor v-model="richTextContent" />
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-5">
              <FormCheckbox
                v-for="(value, index) in postOptions"
                :key="index"
                :val="value.option"
                v-model="value.selected"
              >
                {{ value.display }}
              </FormCheckbox>
            </div>
            <div class="mt-5">
              <Button
                :variant="variant"
                :loading="isSubmitting"
                :disableButton="buttonDisable"
                icon="sign-in-alt"
              >
                Create
              </Button>
            </div>
          </form>
        </ValidationObserver>
      </div>
    </client-only>
  </div>
</template>
<script>
import FormText from '~/components/Input/FormText';
import Button from '~/components/Input/Button';
import Vue2Editor from '~/components/Input/Vue2Editor';
import FormCheckbox from '~/components/Input/FormCheckbox';
import DropDown from '~/components/Input/DropDown';
import AdminLoader from '~/components/Dashboard/AdminLoader';
import agent from '~/api/agent';
import { mapGetters } from 'vuex';
export default {
  name: 'NewPost',
  head: {
    title: 'New Post',
  },
  layout: 'adminLayout',
  components: {
    FormText,
    Button,
    FormCheckbox,
    DropDown,
    AdminLoader,
    Vue2Editor,
  },
  data() {
    return {
      richTextContent: '',
      postTitle: '',
      postCategory: '',
      buttonDisable: false,
      variant: 'success',
      isLoading: false,
      errors: Array,
      isSubmitting: false,
      categoriesList: [],
      postOptions: [],
    };
  },
  methods: {
    async submitPost() {
      if (this.isSubmitting) {
        return;
      }

      this.isSubmitting = true;

      let formData = {
        title: this.postTitle,
        body: this.richTextContent,
        is_live: this.postOptions[0].selected,
        close_to_comments: this.postOptions[1].selected,
        category_id: Number(this.postCategory),
      };

      try {
        const newPost = await agent.Posts.create(formData);
        this.$store.dispatch('admin/admin-posts/savePost', newPost);
        this.clearPostData();
        this.resetPostOptions();
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Post has been created successfully.',
        });
      } catch (error) {
        if (error?.data?.errors) {
          let errors = error.data.errors;
          this.$refs.postForm.setErrors(errors || {});
          for (var key in errors) {
            this.$toast.show({
              type: 'danger',
              title: 'Error',
              message: errors[key][0],
            });
          }
        }
      } finally {
        this.isSubmitting = false;
      }
    },

    async fetchCategories() {
      this.isLoading = true;
      try {
        let categories = await agent.Categories.categories();
        if (categories.length > 0) {
          categories.forEach((category) => {
            let categoryObj = {};
            categoryObj['value'] = category.id.toString();
            categoryObj['name'] = category.title;
            this.categoriesList.push(categoryObj);
          });
        }
      } catch (error) {
      } finally {
        this.isLoading = false;
      }
    },
    clearPostData() {
      this.richTextContent = '';
      this.postTitle = '';
      this.$refs.postForm.reset();
    },
    resetPostOptions() {
      this.postOptions = [
        { display: 'Live', option: 'is_live', selected: true },
        {
          display: 'Disable comments',
          option: 'close_to_comments',
          selected: true,
        },
      ];
    },
  },
  beforeMount() {
    this.resetPostOptions();
    this.fetchCategories();
  },
};
</script>
