<template>
  <div class="flex flex-col h-screen">
    <Header />
    <main class="mb-auto">
      <PostView :articleData="post" />
    </main>
    <Footer />
  </div>
</template>

<script>
import getSinglePost from '~/api/getSinglePost';
import Header from '~/components/Site/Header';
import Footer from '~/components/Site/Footer';
import PostView from '~/components/Site/PostView';
export default {
  name: 'PostPage',
  components: {
    Header,
    Footer,
    PostView,
  },
  data() {
    return {
      errorResponse: {},
    };
  },
  async asyncData({ $axios, store, app, params, error }) {
    return await getSinglePost($axios, store, params, error)
      .then((res) => {
        return {
          post: res.post.data,
        };
      })
      .catch((e) => {});
  },
  props: {
    title: {
      type: String,
      default: '',
    },
  },
  head() {
    return {
      title: this.$route.params.slug || '',
    };
  },
};
</script>
