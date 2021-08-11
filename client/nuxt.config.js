require('dotenv').config()

const webpack = require("webpack");
const axios = require('axios')

export default {
  /*
   ** Nuxt rendering mode
   ** See https://nuxtjs.org/api/configuration-mode
   */
  mode: "universal",
  /*
   ** Nuxt target
   ** See https://nuxtjs.org/api/configuration-target
   */
  target: "server",
  /*
   ** Headers of the page
   ** See https://nuxtjs.org/api/configuration-head
   */
  head: {
    title: process.env.npm_package_name || "",
    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      {
        hid: "description",
        name: "description",
        content: process.env.npm_package_description || ""
      }
    ],
    link: [{ rel: "icon", type: "image/x-icon", href: "/favicon.ico" }]
  },
  sitemap: {
    hostname: process.env.SITE_URL,
    gzip: true,
    exclude: [
      '/mystery',
      '/admin',
      '/showcase',
      '/admin/**'
    ],
    routes: async () => {
      let baseUrl =  process.env.API_URL;
      let { data } = await axios.get(`${baseUrl}/api/articles/seo`)
      let posts = data.map((post) => {
        return {
          url:`/posts/${post.slug}`,
          changefreq: 'weekly',
          priority: 1,
          lastmod: post.updated_at
        }
      })

      let categories = data.map((post) => {
        return {
          url:`/categories/${post.category.slug}`,
          changefreq: 'weekly',
          priority: 1,
          lastmod: new Date()
        }
      })

      return [ ...posts, ...categories ]
    },
  },
  /**
   * Customized loading indicator and customizing the top loading bar
   */
  loading: {
    color: '#f66d9b',
    height: '6px'
  },
  //loading:'~/components/Site/Loading.vue',//using the custom loading component
  /*
   ** Global CSS
   */
  css: [
    "@assets/scss/main.scss"
  ],
  /*
   ** Plugins to load before mounting the App
   ** https://nuxtjs.org/guide/plugins
   */
  plugins: [
    { src: "~plugins/validation.js", ssr: false },
    { src: "~plugins/datePicker.js", ssr: false},
    { src: "~plugins/vue2-editor.js", ssr: false },
    { src: "~plugins/vue-tags-input.js", ssr: false },
    '~plugins/eventBus.js'
  ],
  /*
   ** Auto import components
   ** See https://nuxtjs.org/api/configuration-components
   */
  components: true,
  /*
   ** Nuxt.js dev-modules being used only in development mode
   */
  buildModules: [
    // Doc: https://github.com/nuxt-community/nuxt-tailwindcss
    "@nuxtjs/tailwindcss",
    "@nuxtjs/dotenv"
  ],
  /*
   ** Nuxt.js modules
   */
  modules: [
    "@nuxtjs/axios",
    "@nuxtjs/auth",
    ['nuxt-tailvue', {toast: true}],
    [
      "nuxt-fontawesome",
      {
        imports: [
          {
            set: "@fortawesome/free-solid-svg-icons",
            icons: ["fas"]
          },
          {
            set: "@fortawesome/free-brands-svg-icons",
            icons: ["fab"]
          }
        ]
      }
    ],
    '@nuxtjs/sitemap'
  ],

  auth: {
    strategies: {
      local: {
        endpoints: {
          login: { url: '/api/login', method: 'post', propertyName: 'token' }, //token property in the JSON response contains the actual token
          logout: { url: '/api/logout', method: 'post' },
          user: { url: '/api/me', method: 'get', propertyName: 'data' } //token property in the JSON response contains the actual user info
        },
        // tokenRequired: true,
        // tokenType: 'bearer',
        // globalToken: true,
        // autoFetchUser: true
      }
    },
    redirect: {
      login: '/mystery',
      logout: '/',
      callback: '/login',
      home: '/admin'
    }
  },

  /*
   ** Build configuration
   ** See https://nuxtjs.org/api/configuration-build/
   */
  build: {
    /*
     ** You can extend webpack config here
     */
    vendor: ["jquery"],
    plugins: [
      new webpack.ProvidePlugin({
        $: "jquery",
        jQuery: "jquery",
        jquery: "jquery",
        "window.jQuery": "jquery"
      })
    ],
    extend(config, ctx) {}
  }
};
