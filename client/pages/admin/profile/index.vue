<template>
  <div>
    <div>
      <h3 class="text-gray-700 text-3xl font-medium">Profile</h3>
    </div>
    <div class="flex flex-wrap -mx-6">
      <div class="w-full mt-3 px-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
        <a
          @click="changePasswordModalOpen"
          class="mt-4"
          to="/admin/profile/keyvalue"
        >
          <div
            class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white"
          >
            <div>
              <font-awesome-icon
                :icon="['fas', 'key']"
                class="fa-fw fa-3x mr-1 fa-square fa-w-14"
              />
            </div>
            <div class="mx-5">
              <div>
                <h4 class="text-2xl font-semibold text-gray-700">
                  Change password
                </h4>
              </div>
              <div class="text-gray-500">Change password</div>
            </div>
          </div>
        </a>
      </div>
    </div>

    <Modal
      :visible="modalStatus.changePassword"
      @close="modalStatus.changePassword = false"
    >
      <ValidationObserver ref="changePasswordForm" v-slot="{ handleSubmit }">
        <form @submit.prevent="handleSubmit(changePasswordAction)">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3
                  class="text-lg leading-6 font-medium text-gray-900"
                  id="modal-headline"
                >
                  Change password
                </h3>

                <div class="mt-2">
                  <p class="text-sm leading-5 text-gray-500">
                    This action will change your password
                  </p>
                  <p class="text-sm leading-5 text-gray-500"></p>
                </div>

                <div class="mt-2">
                  <div class="min-w-full">
                    <FormText
                      rules="required"
                      name="password"
                      type="password"
                      label="Current password"
                      placeholder="Current password"
                      class="my-4"
                      icon="key"
                      v-model="currentPassword"
                    ></FormText>
                  </div>
                </div>
                <div class="mt-2">
                  <div class="min-w-full">
                    <FormText
                      rules="required"
                      name="New password"
                      type="password"
                      label="New password"
                      placeholder="New password"
                      class="my-4"
                      icon="key"
                      v-model="newPassword"
                    ></FormText>
                  </div>
                </div>
                <div class="mt-2">
                  <div class="min-w-full">
                    <FormText
                      rules="required"
                      name="Confirm password"
                      type="password"
                      label="Confirm password"
                      placeholder="Confirm password"
                      class="my-4"
                      icon="key"
                      v-model="confirmPassword"
                    ></FormText>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
              <Button
                variant="success"
                :loading="modalSubmitting"
                :disableButton="modalSubmitting ? true : false"
                size="small"
                width="full"
              >
                Update
              </Button>
            </span>

            <span
              class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto"
            >
              <Button
                variant="white"
                @click.native="modalStatus.changePassword = false"
                :disableButton="modalSubmitting ? true : false"
                size="small"
                width="full"
              >
                Cancel
              </Button>
            </span>
          </div>
        </form>
      </ValidationObserver>
    </Modal>
  </div>
</template>
<script>
import Button from '~/components/Input/Button';
import agent from '~/api/agent';
import Modal from '~/components/Site/Modal';
import FormText from '~/components/Input/FormText';
export default {
  name: 'Profile',
  head: {
    title: 'Profile',
  },
  components: {
    Button,
    Modal,
    FormText,
  },
  layout: 'adminLayout',
  data() {
    return {
      error: false,
      preValidationErrors: {},
      loading: true,
      modalStatus: {
        changePassword: false,
      },
      modalSubmitting: false,
      currentPassword: '',
      newPassword: '',
      confirmPassword: '',
    };
  },
  methods: {
    changePasswordModalOpen() {
      this.setModalStatus('changePassword', true);
    },

    preValidation() {
      var errors = false;

      if (this.currentPassword === this.newPassword) {
        this.preValidationErrors['New password'] =
          'New password and current password must be different.';
        errors = true;
      }

      if (this.newPassword !== this.confirmPassword) {
        this.preValidationErrors['Confirm password'] =
          'New password and Confirm password must match.';
        errors = true;
      }

      if (errors) {
        this.$refs?.changePasswordForm?.setErrors(
          this.preValidationErrors || {}
        );
        return false;
      }

      return true;
    },

    clearPostData() {
      this.currentPassword = '';
      this.newPassword = '';
      this.confirmPassword = '';
      this.$refs.postForm.reset();
    },

    async changePasswordAction() {
      if (!this.modalStatus.changePassword) {
        return;
      }

      if (!this.preValidation()) {
        return;
      }

      if (this.modalSubmitting) {
        return;
      }

      this.modalSubmitting = true;

      let formData = {
        current_password: this.currentPassword,
        password: this.newPassword,
        password_confirmation: this.confirmPassword,
      };

      try {
        await agent.Password.update(formData);
        this.setModalStatus('changePassword', false);
        this.clearPostData();
      } catch (error) {
        if (error?.data?.errors) {
          let errors = error.data.errors;
          this.$refs?.changePasswordForm?.setErrors(errors || {});
          for (var key in errors) {
            this.$toast.show({
              type: 'danger',
              title: 'Error',
              message: errors[key][0],
            });
          }
        }
      } finally {
        this.modalSubmitting = false;
      }
    },

    setModalStatus(modal, status) {
      for (var key in this.modalStatus) {
        if (key == modal) {
          this.modalStatus[key] = status;
          continue;
        }

        this.currentPassword = '';
        this.newPassword = '';
        this.confirmPassword = '';
        this.error = false;
        this.modalSubmitting = false;
        this.modalStatus[key] = false;
      }
    },
  },
};
</script>
