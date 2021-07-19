<template>
  <div>
    <h3 class="text-gray-700 text-3xl font-medium">Edit Post</h3>
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
        <div class="min-w-full my-4">
          <p class="text-sm leading-5 text-gray-700">
            Category:
            <span class="text-gray-700 font-medium">{{
              postCategory.title
            }}</span>
          </p>
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
                <Vue2Editor v-model="postBodyRichText" />
              </div>
            </div>
          </div>
        </div>
        <div v-if="postOptions.length" class="mt-5">
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
            variant="success"
            :loading="isSubmitting"
            :disableButton="buttonDisable"
            icon="sign-in-alt"
          >
            Update
          </Button>
        </div>
      </form>
    </ValidationObserver>
  </div>
</template>

<script>
import FormText from '~/components/Input/FormText';
import FormTextarea from '~/components/Input/FormTextarea';
import Button from '~/components/Input/Button';
import Vue2Editor from '~/components/Input/Vue2Editor';
import FormCheckbox from '~/components/Input/FormCheckbox';
import { mapGetters } from 'vuex';
import agent from '~/api/agent';

export default {
  name: 'EditPost',
  head: {
    title: 'Edit Post',
  },
  layout: 'adminLayout',
  components: {
    FormText,
    Button,
    FormCheckbox,
    Vue2Editor,
    FormTextarea,
  },
  computed: {
    ...mapGetters({
      currentpost: 'admin/admin-posts/post',
    }),
  },
  middleware({ redirect, route, store }) {
    let postSlug = route.params.slug;
    const post = store.getters['admin/admin-posts/post'](postSlug);

    if (!post) {
      return redirect('301', '/admin/posts/');
    }
  },
  data() {
    return {
      postBodyRichText: String,
      postTitle: String,
      postDesription: String,
      postCategory: String,
      postSlug: String,
      postCategoryId: Number,
      isSubmitting: false,
      buttonDisable: false,
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
        body: this.postBodyRichText,
        description: this.postDesription,
        is_live: this.postOptions[0].selected,
        close_to_comment: this.postOptions[1].selected,
        category_id: Number(this.postCategoryId),
        slug: this.postSlug,
        tags: [],
      };

      try {
        let updatedPost = await agent.Posts.update(formData);
        this.$store.dispatch('admin/admin-posts/updatePost', updatedPost);
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Post has been edited successfully.',
        });
        this.redirect();
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
    setPostOptions(isLiveStatus, commentStatus) {
      this.postOptions = [
        { display: 'Live', option: 'is_live', selected: !!isLiveStatus },
        {
          display: 'Disable comments',
          option: 'close_to_comment',
          selected: !!commentStatus,
        },
      ];
    },
    redirect() {
      this.$router.push({
        name: 'admin-posts',
      });
    },
  },
  beforeMount() {
    let postSlug = this.$route.params.slug;
    let post = this.currentpost(postSlug);
    this.postBodyRichText = post.body;
    this.postTitle = post.title;
    this.postDesription = post.description;
    this.postCategory = post.category;
    this.postCategoryId = post.category.id;
    this.postSlug = post.slug;
    this.setPostOptions(post.is_live, post.close_to_comment);
  },
};
</script>
