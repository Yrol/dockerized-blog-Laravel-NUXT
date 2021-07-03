<template>
  <div class="flex flex-col">
    <client-only>
      <div v-if="loading">
        <AdminLoader title="Loading..." />
      </div>
      <div v-else>
        <div class="mb-4 w-full flex flex-wrap">
          <div class="flex w-1/2">
            <h3 class="text-gray-700 text-3xl font-medium">Key Value</h3>
          </div>
          <div class="flex justify-end content-end border-8:transparent w-1/2">
            <Button
              variant="success"
              :loading="false"
              :disableButton="false"
              size="small"
              icon="plus"
              @click="addSettingModalOpen"
            >
              Add new
            </Button>
          </div>
        </div>
        <div v-if="keyValues.length > 0">
          <table class="min-w-full leading-normal">
            <thead>
              <tr>
                <th
                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                >
                  Key
                </th>
                <th
                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                >
                  Value
                </th>
                <th
                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                >
                  Decription
                </th>
                <th
                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100"
                ></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(keyValue, index) in keyValues" :key="index">
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <div class="flex">
                    <div class="ml-3">
                      <p class="text-gray-900 font-medium whitespace-no-wrap">
                        {{ keyValue.key }}
                      </p>
                    </div>
                  </div>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-600 whitespace-no-wrap">
                    {{ keyValue.value }}
                  </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-600 whitespace-no-wrap"></p>
                </td>
                <td
                  class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right"
                >
                  <div class="relative" :key="`dropdown-${index}`">
                    <button
                      @click="currentDropDownIndex(index)"
                      type="button"
                      class="inline-block text-gray-500 hover:text-gray-700"
                    >
                      <svg
                        class="inline-block h-6 w-6 fill-current"
                        viewBox="0 0 24 24"
                      >
                        <path
                          d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-2 6a2 2 0 104 0 2 2 0 00-4 0z"
                        />
                      </svg>
                    </button>
                    <div
                      v-show="dropdownOpen"
                      @click="dropdownOpen = false"
                      class="fixed inset-0 h-full w-full z-10"
                    ></div>

                    <div
                      v-show="dropdownOpen && index == currentDropDown"
                      class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20"
                    >
                      <button
                        type="button"
                        class="block flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white"
                        @click="
                          editSettingModalOpen(
                            keyValue.id,
                            keyValue.slug,
                            keyValue.key,
                            keyValue.value
                          )
                        "
                      >
                        <span class="flex-start">Edit</span>
                      </button>
                      <button
                        type="button"
                        class="block flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white"
                        @click="deletKeyValueModal(keyValue.slug, keyValue.key)"
                      >
                        <span class="flex-start">Delete</span>
                      </button>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-else></div>
      </div>
    </client-only>

    <Modal
      :visible="modalStatus.addSetting"
      @close="modalStatus.addSetting = false"
    >
      <ValidationObserver ref="keyValueAddForm" v-slot="{ handleSubmit }">
        <form @submit.prevent="handleSubmit(addSettingAction)">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3
                  class="text-lg leading-6 font-medium text-gray-900"
                  id="modal-headline"
                >
                  Create Key Value
                </h3>

                <div class="mt-2">
                  <p class="text-sm leading-5 text-gray-500">
                    This action will create a Key Value.
                  </p>
                  <p class="text-sm leading-5 text-gray-500"></p>
                </div>

                <div class="mt-2">
                  <div class="min-w-full">
                    <FormText
                      rules="required"
                      name="key"
                      label="Setting Key"
                      placeholder="Setting Key"
                      class="my-4"
                      icon="folder"
                      v-model="settingKey"
                    ></FormText>
                  </div>
                </div>

                <div class="mt-2">
                  <div class="min-w-full">
                    <FormText
                      rules="required"
                      name="value"
                      label="Setting value"
                      placeholder="Setting Value"
                      class="my-4"
                      icon="folder"
                      v-model="settingValue"
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
                Create
              </Button>
            </span>

            <span
              class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto"
            >
              <Button
                variant="white"
                @click.native="modalStatus.addSetting = false"
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

    <Modal
      :visible="modalStatus.editSetting"
      @close="modalStatus.editSetting = false"
    >
      <ValidationObserver ref="keyValueEditForm" v-slot="{ handleSubmit }">
        <form @submit.prevent="handleSubmit(editSettingAction)">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3
                  class="text-lg leading-6 font-medium text-gray-900"
                  id="modal-headline"
                >
                  Edit Key Value
                </h3>

                <div class="mt-2">
                  <p class="text-sm leading-5 text-gray-500">
                    This action will edit the Key Value below.
                  </p>
                  <p class="text-sm leading-5 text-gray-500"></p>
                </div>

                <div class="mt-2">
                  <div class="min-w-full">
                    <FormText
                      rules="required"
                      name="key"
                      label="Setting Key"
                      placeholder="Setting Key"
                      class="my-4"
                      icon="folder"
                      v-model="settingKey"
                    ></FormText>
                  </div>
                </div>

                <div class="mt-2">
                  <div class="min-w-full">
                    <FormText
                      rules="required"
                      name="value"
                      label="Setting value"
                      placeholder="Setting Value"
                      class="my-4"
                      icon="folder"
                      v-model="settingValue"
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
                @click.native="modalStatus.editSetting = false"
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

    <Modal
      :visible="modalStatus.deleteSetting"
      @close="modalStatus.deleteSetting = false"
    >
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div
            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
          >
            <svg
              class="h-6 w-6 text-red-600"
              stroke="currentColor"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
              />
            </svg>
          </div>

          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3
              class="text-lg leading-6 font-medium text-gray-900"
              id="modal-headline"
            >
              Are you sure?
            </h3>

            <div class="mt-2">
              <p class="text-sm leading-5 text-gray-500">
                This action will permanently delete the Key Value :
                {{ settingKey }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
          <Button
            variant="danger"
            @click="deleteSettingConfirmAction()"
            :loading="modalSubmitting"
            :disableButton="modalSubmitting ? true : false"
            size="small"
            width="full"
          >
            Yes, Proceed
          </Button>
        </span>

        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
          <Button
            variant="white"
            @click="modalStatus.deleteSetting = false"
            :disableButton="modalSubmitting ? true : false"
            size="small"
            width="full"
          >
            No
          </Button>
        </span>
      </div>
    </Modal>
  </div>
</template>
<script>
import AdminLoader from '~/components/Dashboard/AdminLoader';
import Modal from '~/components/Site/Modal';
import agent from '~/api/agent';
import Button from '~/components/Input/Button';
import FormText from '~/components/Input/FormText';
import { mapGetters } from 'vuex';

export default {
  name: 'KeyValue',
  head: {
    title: 'Key Value',
  },
  layout: 'adminLayout',
  computed: {
    ...mapGetters({
      keyValueTotal: 'admin/settings-key-value/totalKeyValues',
      keyValues: 'admin/settings-key-value/allKeyValues',
    }),
  },
  components: {
    AdminLoader,
    Modal,
    FormText,
    Button,
  },
  data() {
    return {
      loading: false,
      error: false,
      dropdownOpen: false,
      currentDropDown: 0,
      modalStatus: {
        addSetting: false,
        editSetting: false,
        deleteSetting: false,
      },
      modalSubmitting: false,
      settingKey: '',
      settingValue: '',
      settingSlug: '',
      settingId: Number,
    };
  },
  methods: {
    currentDropDownIndex(key) {
      this.currentDropDown = key;
      this.dropdownOpen = !this.dropdownOpen;
    },
    deletKeyValueModal(slug, key) {
      this.setModalStatus('deleteSetting', true);
      this.dropdownOpen = false;
      this.settingSlug = slug;
      this.settingKey = key;
    },

    editSettingModalOpen(id, slug, key, value) {
      this.setModalStatus('editSetting', true);
      this.settingKey = key;
      this.settingValue = value;
      this.settingSlug = slug;
      this.settingId = id;
      this.dropdownOpen = false;
    },

    addSettingModalOpen() {
      this.setModalStatus('addSetting', true);
    },

    setModalStatus(modal, status) {
      for (var key in this.modalStatus) {
        if (key == modal) {
          this.modalStatus[key] = status;
          continue;
        }

        this.settingKey = '';
        this.settingValue = '';
        this.settingSlug = '';
        this.settingId = '';
        this.error = false;
        this.modalSubmitting = false;
        this.modalStatus[key] = false;
      }
    },

    async addSettingAction() {
      if (!this.modalStatus.addSetting) {
        return;
      }

      if (this.modalSubmitting) {
        return;
      }

      this.modalSubmitting = true;

      let formData = {
        key: this.settingKey,
        value: this.settingValue,
      };

      try {
        const settingKeyValue = await agent.SettingsKeyValue.create(formData);
        this.$store.dispatch(
          'admin/settings-key-value/saveKeyValue',
          settingKeyValue
        );
        this.setModalStatus('addSetting', false);
      } catch (error) {
        if (error?.data?.errors) {
          let errors = error.data.errors;
          this.$refs?.keyValueAddForm?.setErrors(errors || {});
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

    async editSettingAction() {
      if (!this.modalStatus.editSetting) {
        return;
      }

      if (this.modalSubmitting) {
        return;
      }

      this.modalSubmitting = true;

      let formData = {
        key: this.settingKey,
        value: this.settingValue,
      };

      try {
        const settingKeyValue = await agent.SettingsKeyValue.update(
          this.settingSlug,
          formData
        );
        this.$store.dispatch(
          'admin/settings-key-value/updateKeyValue',
          settingKeyValue
        );
        this.setModalStatus('editSetting', false);
      } catch (error) {
        if (error?.data?.errors) {
          let errors = error.data.errors;
          this.$refs?.keyValueEditForm?.setErrors(errors || {});
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

    async deleteSettingConfirmAction() {
      if (!this.modalStatus.deleteSetting) {
        return;
      }

      if (this.modalSubmitting) {
        return;
      }

      this.modalSubmitting = true;

      try {
        const settingKeyValue = await agent.SettingsKeyValue.delete(
          this.settingKey
        );
        this.$store.dispatch(
          'admin/settings-key-value/deleteKeyValue',
          settingKeyValue
        );
        this.setModalStatus('deleteSetting', false);
      } catch (error) {
        if (error?.data?.errors) {
          let errors = error.data.errors;
          this.$refs?.keyValueAddForm?.setErrors(errors || {});
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
  },
  async fetch() {
    try {
      this.error = false;
      this.loading = true;
      let keyValues = await agent.SettingsKeyValue.keyValues();
      this.$store.dispatch('admin/settings-key-value/keyValues', keyValues);
    } catch (error) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  },
  fetchOnServer: false,
  fetchDelay: 0,
};
</script>
