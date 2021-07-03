export default async ($axios, store, params, error) => {

  //$axios.defaults.baseURL = process.env.API_URL; // base url defined in the .env file

  try{
    const post = await $axios.$get(`/api/articles/${params.slug}`);

    return {
      post
    }
  }catch(e){
    throw error({ statusCode: e.response.status, message: typeof e.response?.data?.errors?.message !== 'undefined' ?  e.response?.data?.errors?.message : 'An unknown error occurred. Please try again later'});
  }
}
