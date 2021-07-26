<template>
  <header>
    <nav
      class="flex flex-wrap items-center justify-between px-2 py-3 mb-3"
      :class="navbarBackground"
    >
      <div
        class="
          w-full
          flex
          justify-between
          lg:w-auto
          px-4
          lg:static
          lg:block
          lg:justify-start
        "
      >
        <nuxt-link
          class="
            text-lg
            font-bold
            leading-relaxed
            inline-block
            mr-4
            py-2
            whitespace-nowrap
            uppercase
            tracking-wide
          "
          :class="colorText"
          to="/"
        >
          YROL.BLOG
        </nuxt-link>
        <button
          class="
            cursor-pointer
            text-xl
            leading-none
            px-3
            py-1
            border border-solid border-transparent
            rounded
            bg-transparent
            block
            lg:hidden
            outline-none
            focus:outline-none
          "
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
              <button
                class="
                  text-xs
                  uppercase
                  font-bold
                  leading-snug
                  background-transparent
                  outline-none
                  focus:outline-none
                  hover:opacity-75
                "
                :class="textColor"
                @click="showMe()"
              >
                <i />
                <font-awesome-icon
                  :icon="['fas', 'user']"
                  class="fa-fw fa-lg mr-1 fa-square fa-w-14"
                /><span class="inline-block align-middle">me</span>
              </button>
            </div>
          </li>
          <li class="nav-item">
            <div class="px-3 py-2 flex items-center">
              <a
                class="
                  text-xs
                  uppercase
                  font-bold
                  leading-snug
                  hover:opacity-75
                "
                @click="goToSite('https://github.com/Yrol/')"
                :class="textColor"
              >
                <i />
                <font-awesome-icon
                  :icon="['fas', 'code']"
                  class="fa-fw fa-lg mr-1 fa-square fa-w-14"
                /><span class="inline-block align-middle">Code</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
      <Modal :visible="showProfileModal" @close="showProfileModal = false">
        <div
          class="
            bg-white
            p-3
            rounded
            text-center
            py-8
            hover:shadow-md
            cursor-pointer
          "
        >
          <div class="flex justify-center mb-2">
            <img
              src="~/assets/images/profile_image.png"
              class="
                rounded-full
                h-40
                w-40
                flex
                items-center
                border-solid border-4 border-blue-500
                justify-center
              "
            />
          </div>
          <h1 class="text-3xl text-gray-700">Yrol Fernando</h1>
          <span class="text-1xl text-gray-700">Software Developer</span>
          <div class="mt-3">
            <a @click="goToSite('https://www.linkedin.com/in/yrol-fernando/')">
              <font-awesome-icon
                :icon="['fab', 'linkedin']"
                class="fa-fw fa-lg mr-1 text-gray-500 fa-square fa-w-14"
            /></a>
            <a @click="goToSite('https://github.com/Yrol/')">
              <font-awesome-icon
                :icon="['fab', 'github']"
                class="fa-fw fa-lg mr-1 fa-square text-gray-500 fa-w-14"
            /></a>
          </div>
          <div class="mt-2">
            <button
              class="
                bg-blue-500
                hover:bg-blue-700
                text-white
                w-5/12
                font-bold
                py-2
                px-4
                rounded-full
                background-transparent
                outline-none
                focus:outline-none
              "
              @click="showProfileModal = false"
            >
              Close
            </button>
          </div>
        </div>
      </Modal>
    </nav>
  </header>
</template>

<script>
import Modal from '~/components/Site/Modal';
export default {
  name: 'SiteHeader',
  components: {
    Modal,
  },
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
      showProfileModal: false,
    };
  },
  methods: {
    toggleNavbar: function () {
      this.showMenu = !this.showMenu;
    },
    goToSite: function (link, target = '_blank') {
      window.open(link, target);
    },
    showMe: function () {
      this.toggleNavbar();
      this.showProfileModal = true;
    },
  },
};
</script>
