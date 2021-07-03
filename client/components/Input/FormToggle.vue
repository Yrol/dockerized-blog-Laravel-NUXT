<template>
  <label
    :for="id"
    class="flex flex-row items-center cursor-pointer text-gray-400 font-light text-xs uppercase"
  >
    <span class="mr-2">
      <slot></slot>
    </span>
    <span
      :class="{ 'bg-blue-200': !value, 'bg-blue-600': value }"
      class="relative inline-block flex-no-shrink h-6 w-11 border-2 border-transparent rounded-full transition-colors ease-in-out duration-200 focus:outline-none focus:shadow-outline"
      role="checkbox"
      tabindex="0"
    >
      <span
        aria-hidden="true"
        :class="{ 'translate-x-5': value, 'translate-x-0': !value }"
        class="inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200"
      ></span>
      <input
        type="checkbox"
        :id="id"
        :name="name"
        tabindex="1"
        @change="toggle"
        :checked="value"
        class="hidden"
      />
    </span>
  </label>
</template>

<script>
export default {
  name: 'FormToggle',
  inheritAttrs: true,
  props: {
    value: {
      type: Boolean,
      required: true,
      default: false,
    },
    name: {
      type: String,
    },
  },
  data() {
    return {
      id: `toggleSwitch#${this._uid}`,
    };
  },
  methods: {
    toggle() {
      this.$emit('input', !this.value);
    },
  },
};
</script>
