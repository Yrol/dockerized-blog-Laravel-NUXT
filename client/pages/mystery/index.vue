<template>
  <client-only>
    <div v-if="!loginSuccessful">
      <ValidationObserver ref="loginForm" v-slot="{ handleSubmit }">
        <div class="container mx-auto p-2">
          <div
            class="max-w-sm mx-auto my-24 bg-white px-5 py-10 rounded shadow-xl"
          >
            <div class="text-center mb-8">
              <h1 class="font-bold text-2xl font-bold">Login</h1>
            </div>
            <form @submit.prevent="handleSubmit(login)">
              <div class="mt-5">
                <FormText
                  name="email"
                  label="Email"
                  placeholder="Email"
                  class="my-4"
                  icon="user"
                  v-model="email"
                  rules="required"
                ></FormText>
              </div>
              <div class="mt-5">
                <FormText
                  type="password"
                  name="password"
                  label="Password"
                  placeholder="Password"
                  class="my-4"
                  icon="key"
                  v-model="password"
                  rules="required"
                ></FormText>
              </div>
              <div class="mt-10">
                <Button
                  :variant="variant"
                  :loading="submitting"
                  :disableButton="buttonDisable"
                  icon="sign-in-alt"
                  size="small"
                  width="full"
                >
                  Login
                </Button>
              </div>
            </form>
          </div>
        </div>
      </ValidationObserver>
    </div>
    <div v-else>
      <AdminLoader title="Redirecting. Please wait...." />
    </div>
  </client-only>
</template>
<script>
import FormText from '~/components/Input/FormText';
import Button from '~/components/Input/Button';
import AdminLoader from '~/components/Dashboard/AdminLoader';
export default {
  name: 'Mystery',
  components: {
    FormText,
    Button,
    AdminLoader,
  },
  head: {
    title: 'Mystery',
  },
  middleware: 'authenticated',
  data() {
    return {
      email: null,
      password: null,
      submitting: false,
      errors: [],
      buttonDisable: false,
      variant: 'success',
      loginSuccessful: false,
    };
  },
  methods: {
    login() {
      if (this.submitting) {
        return;
      }

      this.submitting = true;
      this.buttonDisable = true;

      this.$refs.loginForm.validate().then((result) => {
        let formData = new FormData();
        formData.append('email', this.email);
        formData.append('password', this.password);
        (async () => {
          await this.$auth
            .loginWith('local', {
              data: formData,
            })
            .then((res) => {
              //console.log(res.data.token);
              if (res?.data?.token) {
                this.loginSuccessful = true;
              }
            })
            .catch((error) => {
              this.$refs.loginForm.setErrors(error.response.data.errors || {});
            })
            .finally(() => {
              this.submitting = false;
              this.buttonDisable = false;
            });
        })();
      });
    },
  },
};
</script>
