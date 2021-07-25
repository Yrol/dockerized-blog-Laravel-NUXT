import axios, { AxiosResponse } from 'axios'

axios.defaults.baseURL = '/api'; // base url defined in the .env file

axios.interceptors.request.use((config) => {

  //Grab the token from localStorage pass it along with the request header as Bearer
  const token = window.localStorage.getItem("auth._token.local");
  if (token) {
      config.headers.Authorization = token
  }
  return config;
},error => {
  //"Promise.reject" returns a Promise object that is rejected with a given reason - Promise.reject(reason)
  return Promise.reject(error)
})

axios.interceptors.response.use(undefined, error => {
  if (error.message === "Network Error" && !error?.response) {

  }

  //exposing the properties of the error response values such as header, data & etc
  const { status, data, config, headers } = error?.response;

  console.log(status)

  if (status === 404) {
    //throw error; will be caught by the "activityStore"
  }

  //handling the token expiry (the API has been programmed to exposed to headers -"www-authenticate" ) error
  if (
    status === 401 &&
    headers["www-authenticate"].includes(
      'Bearer error="invalid_token", error_description="The token expired at"'
    )
  ) {

  }

  //handling the 500 server errors using the "react-toastify" library  (ActivityDetails for now)
  if (status === 500) {

  }

  //error response will throw a proper error response
  throw error.response;

});

const responseBody = (response) => response.data;

const requests = {
  get: (url) => axios.get(url).then(responseBody),
  post: (url, body) => axios.post(url, body).then(responseBody),
  put: (url, body) => axios.put(url, body).then(responseBody),
  del: (url) => axios.delete(url).then(responseBody)
}

const Posts = {
  all: (pageId) => requests.get(`/articles?page=${pageId}`),
  adminAll: (pageId) => requests.get(`/articles/all?page=${pageId}`),
  details: (id) => requests.get(`/articles/${id}`),
  create: (post) => requests.post('/articles', post),
  update: (post) => requests.put(`/articles/${post.slug}`, post),
  delete: (slug) => requests.del(`/articles/${slug}`),
  updateStatus: (post, id) => requests.post(`/articles/${id}/publish`, post),
  postCount: () => requests.get(`/count/articles`),
  uploadImage: (post) => requests.post(`/articles/imageupload`, post)
}

const Categories = {
  categories: () => requests.get('/categories').then(responseBody),
  create: (categoryData) => requests.post('/categories', categoryData),
  update: (slug, categoryData) => requests.put(`/categories/${slug}`, categoryData),
  categoriesCount: () => requests.get(`/count/categories`),
}

const SettingsKeyValue = {
  keyValues: () => requests.get('/settings/keyvalue/').then(responseBody),
  create: (settingData) => requests.post('/settings/keyvalue', settingData),
  update: (slug, settingData) => requests.put(`/settings/keyvalue/${slug}`, settingData),
  delete: (slug) => requests.del(`/settings/keyvalue/${slug}`),
}

const Password = {
  update: (passwordData) => requests.put(`/settings/password/`, passwordData),
}

export default{
  Posts,
  Categories,
  SettingsKeyValue,
  Password
}
