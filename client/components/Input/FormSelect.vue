<template>
  <ValidationProvider tag="div" :name="name" :rules="rules" v-slot="{ errors }">
    <label
      :for="name"
      class="flex flex-row items-end justify-between font-light uppercase"
    >
      <span class="block text-sm leading-5 text-gray-500">
        {{ label }}
      </span>
      <small v-if="!rules" class="text-gray-400 text-xs">Optional</small>
    </label>
    <div class="mt-1 relative rounded-md shadow-sm">
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
      <select
        v-if="options"
        v-model="proxy"
        :id="name"
        :name="name"
        class="form-select appearance-none block w-full h-12 py-3 pr-10 sm:text-sm sm:leading-5"
        :class="{
          'pl-12': icon,
          'border-red-300 text-red-600 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red':
            errors[0],
        }"
      >
        <option value="" selected>{{ placeholder || 'Please Select' }}</option>
        <option
          v-for="(type, index) in options"
          :value="Number.isInteger(index) === false ? index : type"
          :key="index"
        >
          {{ type }}
        </option>
      </select>
      <select
        v-else
        v-model="proxy"
        :id="name"
        :name="name"
        class="form-select appearance-none block w-full h-12 py-3 pr-10 sm:text-sm sm:leading-5"
        :class="{
          'pl-12': icon,
          'border-red-300 text-red-600 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red':
            errors[0],
        }"
      >
        <slot></slot>
      </select>
      <div
        v-if="errors[0]"
        class="absolute inset-y-0 right-0 pr-8 flex items-center pointer-events-none"
      >
        <svg
          class="h-5 w-5 text-red-500"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"
          />
        </svg>
      </div>
    </div>
  </ValidationProvider>
</template>

<script>
export default {
  name: 'FormSelect',
  props: {
    value: [String, Number],
    name: String,
    icon: String,
    label: String,
    placeholder: String,
    options: [Array, Object],
    rules: String,
  },
  data() {
    return {
      proxy: null,
    };
  },
  mounted() {
    this.proxy = this.value;
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
