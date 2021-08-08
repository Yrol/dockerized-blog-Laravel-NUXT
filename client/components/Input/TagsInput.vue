<template>
  <div>
    <client-only>
      <vue-tags-input
        v-model="tag"
        :tags="tags"
        @tags-changed="(newTags) => (tags = newTags)"
      />
    </client-only>
  </div>
</template>
<script>
export default {
  name: 'TagsInput',
  props: {
    value: {
      type: Array,
      default: [],
    },
  },
  data() {
    return {
      tags: [],
      tag: '',
      proxy: null,
    };
  },
  mounted() {
    let tags = this.convertToTagsObject(this.value);
    this.proxy = tags;
    this.tags = tags;
  },
  methods: {
    convertToTagsObject(tagsArray) {
      var tags = [];
      if (tagsArray instanceof Array) {
        tagsArray.forEach((tag) => {
          tags.push({ text: tag });
        });
      }
      return tags;
    },
    convertToArray(tagsObj) {
      var tags = [];
      tagsObj.forEach((tag) => {
        tags.push(tag.text);
      });

      return tags;
    },
  },
  watch: {
    tags(value) {
      if (value !== this.proxy) {
        this.proxy = value;
      }
    },
    proxy(value) {
      if (value !== this.value) {
        this.$emit('input', this.convertToArray(value));
      }
    },
  },
};
</script>

