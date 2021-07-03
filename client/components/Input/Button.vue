<template>
  <component
    :is="tag"
    :type="type"
    v-on="$listeners"
    :class="[btnClass, colorVariants]"
    :variant="variant"
    :variant-type="variantType"
    :size="size"
    :href="to"
  >
    <span>
      <font-awesome-icon
        v-if="icon"
        :icon="['fas', icon]"
        class="fa-fw fa-lg mr-1"
      />
    </span>
    <slot />
  </component>
</template>
<script>
export default {
  props: {
    tag: {
      type: String,
      default: 'button',
    },
    disableButton: {
      type: Boolean,
      default: false,
    },
    variant: {
      type: String,
      default: 'primary',
    },
    variantType: {
      type: String,
      default: 'normal',
    },
    size: {
      type: String,
      default: 'normal',
    },
    rounded: {
      type: String,
      default: 'medium',
    },
    width: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: '',
    },
    icon: {
      type: String,
      default: '',
    },
    to: {
      type: String,
    },
    loading: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {};
  },

  methods: {},

  computed: {
    btnClass() {
      return {
        'base-spinner': this.loading == true,
        'cursor-not-allowed': this.disableButton == true,
        'pointer-events-none': this.disableButton == true,
        'base-button inline-flex align-middle align-items-center justify-center text-sm font-medium rounded-md text-white focus:outline-none border-2': true,

        'rounded-lg': this.rounded === 'medium',
        'rounded-full': this.rounded === 'large',

        'w-full': this.width === 'full',

        'px-6 py-3': this.size == 'normal',
        'px-4 py-2': this.size == 'small',
      };
    },

    colorVariants() {
      switch (this.variant) {
        case 'primary':
          switch (this.variantType) {
            case 'normal':
              switch (this.disableButton) {
                case true:
                  return 'border-blue-300 bg-blue-300 text-white';
                  break;
                default:
                  break;
              }
              return 'border-blue-600 bg-blue-600 hover:bg-blue-700 hover:border-blue-700 text-white';
              break;
            case 'outline':
              return 'border-gray-200 text-blue-500 hover:text-blue-700';
              break;
            default:
              break;
          }
          break;
        case 'danger':
          switch (this.variantType) {
            case 'normal':
              switch (this.disableButton) {
                case true:
                  return 'border-red-300 bg-red-300 text-white';
                  break;
                default:
                  break;
              }
              return 'border-red-600 bg-red-600 hover:bg-red-700 hover:border-red-700 text-white';
              break;
            case 'outline':
              return 'border-gray-200 text-red-500 hover:text-red-600';
              break;
            default:
              break;
          }
          break;

        case 'warning':
          switch (this.variantType) {
            case 'normal':
              return 'border-orange-600 bg-orange-600 hover:bg-orange-700 hover:border-orange-700 text-white';
              break;
            default:
              break;
          }
          break;

        case 'success':
          switch (this.variantType) {
            case 'normal':
              switch (this.disableButton) {
                case true:
                  return 'border-green-300 bg-green-300 text-white';
                  break;
                default:
                  break;
              }
              return 'border-green-600 bg-green-600 hover:bg-green-700 hover:border-green-700 text-white';
              break;
            case 'outline':
              return 'border-2 border-gray-200 text-green-500 hover:text-green-700';
              break;
            default:
              break;
          }
          break;

        case 'white':
          switch (this.variantType) {
            case 'normal':
              return 'border-grey-200 bg-white text-gray-500 hover:text-grey-800';
              break;
            default:
              break;
          }
          break;

        case 'secondary':
          switch (this.variantType) {
            case 'outline':
              return 'border-gray-300 text-gray-500 hover:text-blue-500';
              break;
            default:
              break;
          }
          break;

        default:
          break;
      }
    },
  },
};
</script>
