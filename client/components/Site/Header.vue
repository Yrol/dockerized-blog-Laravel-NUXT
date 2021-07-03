<template>
  <header>
    <nav
      class="flex flex-wrap items-center justify-between px-2 py-3 mb-3"
      :class="navbarBackground"
    >
      <div
        class="w-full flex justify-between lg:w-auto px-4 lg:static lg:block lg:justify-start"
      >
        <nuxt-link
          class="text-lg font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase"
          :class="colorText"
          to="/"
        >
          YROL.BLOG
        </nuxt-link>
        <button
          class="cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none"
          :class="colorText"
          type="button"
          v-on:click="toggleNavbar()"
        >
          <font-awesome-icon
            :icon="['fas', 'bars']"
            class="fa-fw fa-lg mr-1 fa-square fa-w-14"
          />
        </button>
      </div>
      <div
        v-bind:class="{ hidden: !showMenu, flex: showMenu }"
        class="lg:flex lg:flex-grow items-center"
      >
        <ul class="flex flex-col lg:flex-row list-none ml-auto">
          <li class="nav-item">
            <div class="px-3 py-2 flex items-center">
              <nuxt-link
                class="text-xs uppercase font-bold leading-snug hover:opacity-75"
                :class="textColor"
                to="/"
              >
                <i />
                <font-awesome-icon
                  :icon="['fas', 'user']"
                  class="fa-fw fa-lg mr-1 fa-square fa-w-14"
                /><span class="inline-block align-middle">me</span>
              </nuxt-link>
            </div>
          </li>
          <li class="nav-item">
            <div class="px-3 py-2 flex items-center">
              <nuxt-link
                class="text-xs uppercase font-bold leading-snug hover:opacity-75"
                :class="textColor"
                to="/"
              >
                <i />
                <font-awesome-icon
                  :icon="['fas', 'code']"
                  class="fa-fw fa-lg mr-1 fa-square fa-w-14"
                /><span class="inline-block align-middle">Code</span>
              </nuxt-link>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'SiteHeader',
  props: {
    backgroundColor: {
      type: String,
      default: 'bg-blue-500',
    },
    textColor: {
      type: String,
      default: 'text-white',
    },
  },
  computed: {
    navbarBackground() {
      return this.backgroundColor;
    },
    colorText() {
      return this.textColor;
    },
  },
  data() {
    return {
      showMenu: false,
    };
  },
  methods: {
    toggleNavbar: function () {
      this.showMenu = !this.showMenu;
    },
  },
};
</script>
