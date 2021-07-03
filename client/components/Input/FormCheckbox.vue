<template>
  <ValidationProvider :name="name" :rules="rules" v-slot="{ errors }">
    <label
      :for="id"
      class="cursor-pointer text-gray-800"
      :class="{ 'text-red-600': errors[0] }"
    >
      <input
        type="checkbox"
        :id="id"
        tabindex="1"
        :value="val"
        v-model="checked"
        @change="change"
        class="hidden"
      />
      <font-awesome-icon
        v-if="isChecked"
        :icon="['fas', 'check-square']"
        :class="checkedClass"
      ></font-awesome-icon>
      <font-awesome-icon
        v-else
        :icon="['fas', 'square']"
        :class="uncheckedClass"
      ></font-awesome-icon>
      <slot></slot>
    </label>
  </ValidationProvider>
</template>
<script>
export default {
  name: 'FormCheckbox',
  inheritAttrs: true,
  props: {
    value: [String, Array, Boolean],
    val: [String, Number, Object, Boolean],
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
      if (typeof this.value === 'string') {
        return this.val === this.value;
      } else if (typeof this.value === 'boolean') {
        return this.value === true;
      }
      return this.val ? this.value.includes(this.val) : false;
    },
    checkedClass() {
      var styleObj = {
        'fa-fw fa-lg fa-square fa-w-14': true,
      };
      styleObj[this.checkedColor] = true;
      return styleObj;
    },
    uncheckedClass() {
      var styleObj = {
        'fa-fw fa-lg fa-square fa-w-14': true,
      };
      styleObj[this.uncheckedColor] = true;
      return styleObj;
    },
  },
  data() {
    return {
      proxy: false,
      id: `checkbox#${this._uid}`,
    };
  },
  methods: {
    change() {
      this.$emit('input', this.proxy);
    },
  },
};
</script>
