export default async ($axios, store, params, error) => {

  //$axios.defaults.baseURL = process.env.API_URL; // base url defined in the .env file

  const allPosts = await $axios.$get(`/api/articles?page=${isNaN(params.page) ? 1 : params.page}`);

  if (!allPosts.data.length) {
    throw error({ statusCode: 404, message: 'No articles found!' });
  }

  //storing pagination state
  store.dispatch('posts/totalPosts', allPosts);
  store.dispatch('posts/perPagePosts',allPosts);

  return {
    allPosts
  }
}
