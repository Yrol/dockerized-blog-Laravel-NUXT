<template>
  <ValidationProvider :name="name" tag="div" :rules="rules" v-slot="{ errors }">
    <label :for="id" class="cursor-pointer">
      <input
        type="radio"
        :id="id"
        :name="name"
        tabindex="1"
        :value="val"
        v-model="checked"
        @change="change"
        class="hidden"
      />
      <font-awesome-icon
        v-if="isChecked"
        :icon="['fas', 'dot-circle']"
        :class="checkedClass"
      />
      <font-awesome-icon
        v-else
        :icon="['fas', 'circle']"
        :class="[{ 'text-red-600': errors[0] }, uncheckedClass]"
      />
      <slot></slot>
    </label>
  </ValidationProvider>
</template>
<script>
export default {
  name: 'FormRadio',
  inheritAttrs: true,
  props: {
    value: [String, Number, Boolean],
    val: [String, Number, Boolean],
    name: String,
    rules: String,
    uncheckedColor: {
      type: String,
      default: 'text-gray-500',
    },
    checkedColor: {
      type: String,
      default: 'text-blue-600',
    },
  },
  computed: {
    checked: {
      get() {
        return this.value;
      },
      set(value) {
        this.proxy = value;
      },
    },
    isChecked() {
      return this.value === this.val;
    },
    checkedClass() {
      var styleObj = {
        'fa-fw mr-1 subpixel-antialiased': true,
      };
      styleObj[this.checkedColor] = true;
      return styleObj;
    },
    uncheckedClass() {
      var styleObj = {
        'fa-fw mr-1 subpixel-antialiased': true,
      };
      styleObj[this.uncheckedColor] = true;
      return styleObj;
    },
  },
  data() {
    return {
      proxy: false,
      id: `radio#${this._uid}`,
    };
  },
  methods: {
    change() {
      this.$emit('input', this.proxy);
    },
  },
};
</script>
