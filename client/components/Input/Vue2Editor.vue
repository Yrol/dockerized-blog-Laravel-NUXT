<template>
  <div>
    <client-only>
      <vue-editor
        v-model="proxy"
        useCustomImageHandler
        @imageAdded="handleImageAdded"
        :editorOptions="editorSettings"
      >
      </vue-editor>
    </client-only>
  </div>
</template>


<script>
import agent from '~/api/agent';
import hljs from 'highlight.js';
export default {
  name: 'Vue2Editor',
  props: {
    value: String,
  },
  data() {
    return {
      proxy: null,
      editorSettings: {
        modules: {
          syntax: {
            highlight: (text) => hljs.highlightAuto(text).value,
          },
        },
      },
    };
  },
  mounted() {
    this.proxy = this.value;
  },
  methods: {
    async handleImageAdded(file, Editor, cursorLocation, resetUploader) {
      var formData = new FormData();
      formData.append('file', file);

      try {
        const imageUpload = await agent.Posts.uploadImage(formData);
        Editor.insertEmbed(cursorLocation, 'image', imageUpload.data.data.link);
      } catch (error) {
        console.log(error);
        this.$toast.show({
          type: 'danger',
          title: error.statusText,
          message: `${error.status} ${error.statusText}`,
        });
      }

      resetUploader();
    },
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

