import { param } from "jquery";

export default async ($axios, store, params, error) => {

  //$axios.defaults.baseURL = process.env.API_URL; // base url defined in the .env file

  try {
    const posts = await $axios.$get(`/api/articles/category/${params.slug}?page=${typeof params.page === 'undefined' ? 1 : params.page }`);

    if (!posts.data.length) {
      throw error({ statusCode: 404, message: 'No content found!' });
    }

    //storing pagination state
    store.dispatch('categories/totalPosts', posts);
    store.dispatch('categories/perPagePosts',posts);

    return {
      posts
    }
  } catch(e) {
    throw error({ statusCode: e.statusCode, message: e.message });
  }
}
