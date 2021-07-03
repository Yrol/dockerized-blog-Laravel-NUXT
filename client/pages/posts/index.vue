<script>
export default {
  middleware({ redirect }) {
    return redirect('301', '/posts/page/1');
  },
};
</script>
