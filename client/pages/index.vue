<template>
  <div class="flex flex-col h-screen">
    <Header />
    <main class="mb-auto">
      <PostList :posts="posts" />
    </main>
    <div class="flex-wrap border-t border-gray-200">
      <div class="w-full md:w-3/4">
        <Pagination
          @update-pagenumber="updatePageNumber"
          :total="totalPosts"
          :perPage="perPagePosts"
          :paginationMeta="meta"
          toPageName="posts-page-page"
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
import getPosts from '~/api/getPosts';
import Pagination from '~/components/Site/Pagination';
import { mapGetters } from 'vuex';
import { generateSeoMeta } from '~/utils/seo';

export default {
  name: 'HomePage',
  components: {
    PostList,
    Header,
    Footer,
    Pagination,
  },
  computed: {
    ...mapGetters({
      totalPosts: 'posts/totalPosts',
      perPagePosts: 'posts/perPagePosts',
    }),
  },
  data() {
    return {
      posts: [],
      meta: {},
    };
  },
  methods: {
    updatePageNumber(e) {
      console.log(e);
    },
  },
  async asyncData({ $axios, store, app, params, error }) {
    return await getPosts($axios, store, params, error)
      .then((res) => {
        return {
          posts: res.allPosts.data,
          meta: { to: res.allPosts.meta.to, from: res.allPosts.meta.from },
        };
      })
      .catch((e) => {});
  },
  head() {
    const url = `${process.env.API_URL_BROWSER}`;
    const title = 'Home';
    const description = "Yrol's personal blog";
    return {
      title: title,
      meta: generateSeoMeta({ title, description, url }),
    };
  },
};
</script>
