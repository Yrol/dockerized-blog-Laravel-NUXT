<template>
  <ValidationProvider tag="div" :name="name" :rules="rules" v-slot="{ errors }">
    <label
      :for="name"
      class="flex flex-row items-end justify-between font-light uppercase"
    >
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
      <font-awesome-icon
        :icon="['fas', icon || 'calendar-alt']"
        class="fa-lg h-full mx-4 text-gray-400 absolute z-10"
        :class="{ 'text-red-600': errors[0] }"
      ></font-awesome-icon>
      <datepicker
        v-model="proxy"
        @selected="formatSelectedDate"
        :disabled-dates="futureDates"
        :typeable="true"
        initial-view="year"
        name="dateOfBirth"
        :placeholder="placeholder"
        class="form-input block w-full h-12 py-3 px-2 sm:text-sm sm:leading-5 pl-12"
        :class="{
          'border-red-300 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red':
            errors[0],
        }"
      >
      </datepicker>
    </div>
  </ValidationProvider>
</template>

<script>
import moment from "moment/moment";

export default {
  name: "FormText",
  props: {
    value: [String, Date],
    name: String,
    icon: String,
    label: String,
    placeholder: String,
    rules: String,
    allowFuture: {
      type: Boolean,
      default: false,
    },
    showOptional: {
      type: Boolean,
      default: true,
    },
    dateRange: {
      type: Object,
      default: () => ({}),
    },
  },
  computed: {
    futureDates() {
      if (this.dateRange.enable) {
        return { to: this.dateRange.end, from: this.dateRange.start };
      }
      return this.allowFuture || { from: new Date() };
    },
  },
  data() {
    return {
      proxy: null,
    };
  },
  methods: {
    formatSelectedDate(value) {
      this.proxy = moment(value).format("YYYY-MM-DD");
    },
  },
  mounted() {
    this.proxy = this.value;
  },
  watch: {
    proxy(value) {
      if (value !== this.value) {
        this.$emit("input", value);
      }
    },
  },
};
</script>
