<template>
  <nuxt-link
    class="admin-button button"
    type="button"
    :to="defaultToPath"
    :alt="alt"
    :class="classes"
  >
    <slot></slot>
  </nuxt-link>
</template>

<script>
export default {
  name: 'AdminButton',
  props: {
    label: String,
    rounded: Boolean,
    round: Boolean,
    flat: Boolean,
    url: String,
    alt: String,
  },
  data() {
    return {
      buttonClass: '',
      defaultToPath: '#',
    };
  },
  computed: {
    classes() {
      return (
        (this.round === true ? 'rounded-full p-0' : '') +
        (this.rounded === true ? ' rounded' : '')
      );
    },
  },
};
</script>

<style scoped>
.admin-button {
  transition: all 0.25s ease;
}
</style>
