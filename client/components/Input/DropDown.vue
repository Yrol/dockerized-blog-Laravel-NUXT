<template>
  <ValidationProvider
    tag="div"
    :name="name"
    :vid="name"
    :rules="rules"
    v-slot="{ errors }"
  >
    <label
      :for="name"
      class="flex flex-row items-end justify-between font-light uppercase"
    >
      <span class="block text-sm leading-5 text-gray-500">{{ label }}</span>
    </label>
    <div class="relative text-lg w-full">
      <div
        class="absolute inset-y-0 left-0 flex items-center pointer-events-none"
      >
        <font-awesome-icon
          v-if="icon"
          :icon="['fas', icon]"
          class="fa-lg mx-4 text-gray-400 absolute"
          :class="{ 'text-red-600': errors[0] }"
        ></font-awesome-icon>
      </div>
      <input type="text" v-model="proxy" class="hidden" />
      <span
        class="
          flex
          items-center
          justify-between
          px-3
          py-2
          bg-white
          w-full
          border border-gray-500
          rounded-lg
        "
        :class="{
          'pl-12': icon,
          'border-red-300 text-red-600 flex items-center justify-between px-3 py-2 bg-white w-full focus:border-red-300 focus:shadow-outline-red rounded-lg':
            errors[0],
        }"
        @click="isOptionsExpanded = !isOptionsExpanded"
        @blur="isOptionsExpanded = false"
      >
        <span>{{ selectedOption }}</span>
        <svg
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          class="
            h-4
            w-4
            transform
            transition-transform
            duration-200
            ease-in-out
          "
          :class="isOptionsExpanded ? 'rotate-180' : 'rotate-0'"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M19 9l-7 7-7-7"
          />
        </svg>
      </span>
      <transition
        enter-active-class="transform transition duration-500 ease-custom"
        enter-class="-translate-y-1/2 scale-y-0 opacity-0"
        enter-to-class="translate-y-0 scale-y-100 opacity-100"
        leave-active-class="transform transition duration-300 ease-custom"
        leave-class="translate-y-0 scale-y-100 opacity-100"
        leave-to-class="-translate-y-1/2 scale-y-0 opacity-0"
      >
        <ul
          v-show="isOptionsExpanded"
          class="
            absolute
            z-40
            left-0
            right-0
            mb-4
            bg-white
            divide-y
            rounded-lg
            shadow-lg
            overflow-hidden
          "
        >
          <li
            v-for="(option, index) in options"
            :key="index"
            v-bind:value="option.value"
            class="px-3 py-2 transition-colors duration-300 hover:bg-gray-200"
            @mousedown.prevent="setOption(option)"
          >
            {{ option.name }}
          </li>
        </ul>
      </transition>
    </div>
  </ValidationProvider>
</template>

<script>
export default {
  name: 'DropDown',
  props: {
    value: String,
    options: Array,
    name: String,
    rules: String,
    errors: [],
    label: String,
    initialSelected: String,
    icon: String,
  },
  data() {
    return {
      isOptionsExpanded: false,
      selectedOption: null,
      proxy: null,
    };
  },
  methods: {
    setOption(option) {
      this.selectedOption = option.name;
      this.proxy = option.value;
      this.isOptionsExpanded = false;
    },
    setInitialSelected() {
      if (this.initialSelected) {
        for (let key in this.options) {
          if (this.options[key].value === this.initialSelected) {
            this.selectedOption = this.options[key].name;
            this.proxy = this.options[key].value;
          }
        }
      } else {
        if (this.options.length > 0) {
          this.selectedOption = this.proxy = this.options[0].name;
          this.proxy = this.options[0].value;
        }
      }
    },
  },
  mounted() {
    this.proxy = this.value;
    this.setInitialSelected();
  },
  watch: {
    value(value) {
      if (value !== this.proxy) {
        this.proxy = value;
      }
    },
    proxy(value) {
      if (value !== this.value) {
        this.$emit('input', value);
      }
    },
  },
};
</script>

<style>
.ease-custom {
  transition-timing-function: cubic-bezier(0.61, -0.53, 0.43, 1.43);
}
</style>
