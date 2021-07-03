<template>
  <label
    class="relative mx-auto flex justify-center p-2 m-1 sm:w-full sm:px-6 sm:py-2 border-2 border-gray-300 border-dashed rounded-md cursor-pointer"
  >
    <input type="file" @change="handleFiles" class="hidden" />
    <div
      class="text-center flex items-center"
      :class="{ 'flex-row': inline, 'flex-col': !inline }"
    >
      <svg
        class="mx-auto h-8 w-8 sm:h-10 sm:w-10 text-gray-400"
        :class="{ 'text-indigo-500': file }"
        stroke="currentColor"
        fill="none"
        viewBox="0 0 48 48"
      >
        <path
          d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
      <div
        class="hidden sm:flex flex-col"
        :class="{ 'items-start ml-4 -mt-px': inline, 'items-center': !inline }"
      >
        <p class="text-sm text-gray-600">
          <span v-if="file">{{ file.name }}</span>
          <slot v-else>Drag and drop to attach a file</slot>
        </p>
        <p class="text-xs text-gray-400">
          {{ fileTyes }}
        </p>
      </div>
    </div>
    <button
      v-if="file"
      @click.prevent="file = null"
      class="absolute inset-y right-0 m-2"
    >
      <font-awesome-icon
        :icon="['fas', 'trash-alt']"
        class="text-base text-gray-400 hover:text-gray-600 fa-fw"
      />
    </button>
  </label>
</template>

<script>
export default {
  name: "DragDropFileUpload",
  props: {
    value: {},
    fileTyes: {
      type: String,
      default: "PNG, JPG, GIF, PDF",
    },
    inline: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      file: null,
    };
  },
  methods: {
    handleFiles(event) {
      this.file = event.target.files[0];
    },
  },
  watch: {
    value(value) {
      if (!value) {
        this.file = null;
      }
    },
    file(value) {
      this.$emit("input", this.file);
    },
  },
  mounted() {
    ["dragenter", "dragover", "dragleave", "drop"].forEach((event) => {
      this.$el.addEventListener(
        event,
        (e) => {
          e.preventDefault();
          e.stopPropagation();
        },
        false
      );
    });

    this.$el.addEventListener(
      "drop",
      (e) => {
        this.file = e.dataTransfer.files[0];
      },
      false
    );
  },
};
</script>
