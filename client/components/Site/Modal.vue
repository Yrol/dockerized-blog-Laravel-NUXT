<template>
  <div
    class="fixed bottom-0 inset-x-0 z-50 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"
    :class="{ 'pointer-events-none': !visible }"
  >
    <transition
      enter-active-class="ease-out duration-300"
      enter-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="ease-in duration-200"
      leave-class="opacity-100"
      leave-to-class="opacity-0 delay-200"
    >
      <div v-if="visible" class="fixed inset-0 transition-opacity-0">
        <div
          @click="close"
          class="absolute inset-0 bg-gray-900 opacity-50"
        ></div>
      </div>
    </transition>

    <transition
      enter-active-class="ease-out duration-300"
      enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      enter-to-class="opacity-100 translate-y-0 sm:scale-100"
      leave-active-class="ease-in duration-200"
      leave-class="opacity-100 translate-y-0 sm:scale-100"
      leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
      <div
        v-if="visible"
        class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-headline"
      >
        <slot></slot>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  name: 'Modal',

  props: {
    visible: {
      type: Boolean,

      default: false,
    },
  },

  methods: {
    close() {
      if (this.visible) {
        this.$emit('close');
      }
    },
  },
};
</script>
