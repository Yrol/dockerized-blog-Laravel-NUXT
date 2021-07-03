<template>
  <ValidationProvider tag="div" :rules="rules" v-slot="{ errors }">
    <label class="flex flex-row items-end justify-between font-light uppercase">
      <span class="block text-sm leading-5 text-gray-500">
        {{ label }}
      </span>
      <small
        v-if="!rules && showOptional === true"
        class="text-gray-400 text-xs"
        >Optional</small
      >
    </label>
    <div class="mt-1 relative rounded-md shadow-sm">
      <div
        class="absolute inset-y-0 left-0 flex items-start mt-3 pointer-events-none"
      >
        <font-awesome-icon
          v-if="icon"
          :icon="['fas', icon]"
          class="fa-lg mx-4 text-gray-400 absolute"
          :class="{ 'text-red-600': errors[0] }"
        ></font-awesome-icon>
      </div>
      <textarea
        type="text"
        v-model="proxy"
        :placeholder="placeholder"
        class="form-input block w-full py-3 px-2 resize-none sm:text-sm sm:leading-5"
        :class="{
          'pl-12': icon,
          'border-red-300 text-red-600 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red':
            errors[0],
        }"
      >
      </textarea>
    </div>
  </ValidationProvider>
</template>

<script>
export default {
  name: "FormTextarea",
  props: {
    value: String,
    icon: String,
    label: String,
    placeholder: String,
    rules: String,
    showOptional: {
      type: Boolean,
      default: false,
    },
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
        this.$emit("input", value);
      }
    },
  },
};
</script>
