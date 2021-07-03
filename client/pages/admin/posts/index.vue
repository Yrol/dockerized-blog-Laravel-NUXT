<script>
export default {
  middleware({ redirect }) {
    return redirect('301', '/admin/posts/page/1');
  },
};
</script>
