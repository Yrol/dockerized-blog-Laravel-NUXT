<template>
  <div class="flex flex-col h-screen">
    <Header />
    <main class="mb-auto">
      <PostList
        :posts="posts"
        :totalPosts="totalPosts"
        :perPagePosts="postsPerPage"
        :meta="meta"
        paginationToPage="categories-slug-page"
      />
    </main>
    <div class="flex-wrap border-t border-gray-200">
      <div class="w-full md:w-3/4">
        <Pagination
          :total="totalPosts"
          :perPage="postsPerPage"
          :paginationMeta="meta"
          toPageName="categories-slug-page"
          buttonHighlightColor="bg-blue-900"
        />
      </div>
    </div>
    <Footer />
  </div>
</template>
<script>
import PostList from '~/components/Site/PostList';
import Header from '~/components/Site/Header';
import Footer from '~/components/Site/Footer';
import getPostsByCategory from '~/api/getPostsByCategory';
import Pagination from '~/components/Site/Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'CategoryPage',
  components: {
    PostList,
    Header,
    Footer,
    Pagination,
  },
  props: {
    title: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      posts: [],
      meta: {},
      errorResponse: {},
    };
  },
  computed: {
    ...mapGetters({
      totalPosts: 'categories/totalPosts',
      postsPerPage: 'categories/perPagePosts',
    }),
  },
  head() {
    return {
      title: this.$route.params.slug || '',
    };
  },
  async asyncData({ $axios, store, app, params, error }) {
    return await getPostsByCategory($axios, store, params, error)
      .then((res) => {
        return {
          posts: res.posts.data,
          meta: { to: res.posts.meta.to, from: res.posts.meta.from },
        };
      })
      .catch((error) => {});
  },
};
</script>
