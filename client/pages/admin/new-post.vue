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
              <FormTextarea
                rules="required"
                v-model="postDesription"
                name="textarea"
                label="Post Description"
                placeholder="Post Description"
                icon="newspaper"
              ></FormTextarea>
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
                class="
                  border-r border-b border-l border-gray-400
                  lg:border-l-0 lg:border-t lg:border-gray-400
                  bg-white
                  rounded-b
                  lg:rounded-b-none lg:rounded-r
                  p-4
                  flex flex-col
                  justify-between
                  leading-normal
                "
              >
                <div class="mb-4">
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
                <div class="mb-8">
                  <p class="text-sm text-gray-600 flex items-center">
                    <svg
                      class="fill-current text-gray-500 w-3 h-3 mr-2"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                    >
                      <path
                        d="M17.35,2.219h-5.934c-0.115,0-0.225,0.045-0.307,0.128l-8.762,8.762c-0.171,0.168-0.171,0.443,0,0.611l5.933,5.934c0.167,0.171,0.443,0.169,0.612,0l8.762-8.763c0.083-0.083,0.128-0.192,0.128-0.307V2.651C17.781,2.414,17.587,2.219,17.35,2.219M16.916,8.405l-8.332,8.332l-5.321-5.321l8.333-8.332h5.32V8.405z M13.891,4.367c-0.957,0-1.729,0.772-1.729,1.729c0,0.957,0.771,1.729,1.729,1.729s1.729-0.772,1.729-1.729C15.619,5.14,14.848,4.367,13.891,4.367 M14.502,6.708c-0.326,0.326-0.896,0.326-1.223,0c-0.338-0.342-0.338-0.882,0-1.224c0.342-0.337,0.881-0.337,1.223,0C14.84,5.826,14.84,6.366,14.502,6.708"
                      ></path>
                    </svg>
                    Tags
                  </p>
                  <TagsInput v-model="tags" />
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
import FormTextarea from '~/components/Input/FormTextarea';
import Button from '~/components/Input/Button';
import Vue2Editor from '~/components/Input/Vue2Editor';
import FormCheckbox from '~/components/Input/FormCheckbox';
import DropDown from '~/components/Input/DropDown';
import AdminLoader from '~/components/Dashboard/AdminLoader';
import TagsInput from '~/components/Input/TagsInput';
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
    FormTextarea,
    Button,
    FormCheckbox,
    DropDown,
    AdminLoader,
    Vue2Editor,
    TagsInput,
  },
  data() {
    return {
      richTextContent: '',
      postTitle: '',
      postDesription: '',
      postCategory: '',
      buttonDisable: false,
      variant: 'success',
      isLoading: false,
      errors: Array,
      isSubmitting: false,
      categoriesList: [],
      postOptions: [],
      tags: [],
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
        description: this.postDesription,
        body: this.richTextContent,
        is_live: this.postOptions[0].selected,
        close_to_comments: this.postOptions[1].selected,
        category_id: Number(this.postCategory),
        tags: JSON.stringify(this.tags),
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
      this.postDesription = '';
      (this.tags = []), this.$refs.postForm.reset();
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
    getTags() {},
  },
  beforeMount() {
    this.resetPostOptions();
    this.fetchCategories();
  },
};
</script>
