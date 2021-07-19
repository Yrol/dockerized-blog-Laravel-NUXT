<template>
  <div>
    <Header />

    <div class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <!-- Card -->
        <Card
          v-bind:tags="tags"
          :dataReady="true"
          :toLocation="toLocation"
          :postData="articleData"
        />
        <!-- Card Skeleton mode (will be used when loading the posts)-->
        <Card :dataReady="false" />
      </div>
      <div class="w-ful md:w-1/4 lg:pl-0 md:pl-0 p-4">
        <!-- Categories Card -->
        <CategoriesCard />
      </div>
    </div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <Vue2Editor v-model="richTextContent" />
      </div>
    </div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <span v-html="richTextBody"></span>
      </div>
    </div>
    <!-- Show only if logged in using nuxt auth-->
    <div v-if="isAuthenticated" class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <span>User has logged and the token is</span>
        <p class="flex flex-wrap">{{ `${this.$auth.getToken('local')}` }}</p>
      </div>
    </div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <client-only>
          <FormText
            rules="required"
            name="Article title"
            label="Article title"
            placeholder="Article title"
            class="my-4"
            icon="camera"
            v-model="formText"
          ></FormText>
        </client-only>
      </div>
    </div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <client-only>
          <DropDown
            name="category"
            label="Category"
            rules="required"
            icon="folder"
            placeholder="Please choose a category"
            :options="categoriesList"
            :initialSelected="selectedCategory"
            class="my-4"
            v-model="categories"
          />
        </client-only>
        <client-only>
          <FormSelect
            v-model="selectedBrand"
            :options="carbrands"
            rules="required"
            label="Brand"
            icon="folder"
            name="speed"
          ></FormSelect>
        </client-only>
      </div>
    </div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <client-only>
          <FormCheckbox
            v-for="(brand, index) in carbrands"
            :key="index"
            :val="brand"
            v-model="checkBoxRequirement[index]"
          >
            {{ brand }}
          </FormCheckbox>
        </client-only>
      </div>
    </div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <client-only>
          <FormRadio
            v-for="(val, index) in radio"
            :key="index"
            class="mx-2"
            :val="radio[index]"
            name="myRadio"
            rules="required"
            v-model="defaultCheck"
            >{{ val }}</FormRadio
          >
        </client-only>
      </div>
    </div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-2/4 p-4">
        <client-only>
          <FormDatePicker
            v-model="processingDate"
            name="processingDate"
            rules="required"
            label="Processing Date"
            placeholder="01-01-1970"
          ></FormDatePicker>
        </client-only>
      </div>
    </div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-2/4 p-4">
        <client-only>
          <FormDatePicker
            v-model="processingDate"
            name="processingDate"
            :showOptional="false"
            :dateRange="{ enable: true, end: processingDate, start: endDate }"
            rules="required"
            label="Limited date range (Allow only 1 month from today)"
            placeholder="01-01-1970"
          ></FormDatePicker>
        </client-only>
      </div>
    </div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <client-only>
          <FormTextarea
            v-model="textAreaData"
            name="textarea"
            label="Additional information"
            placeholder="Optional"
            icon="camera"
          ></FormTextarea>
        </client-only>
      </div>
    </div>
    <div class="flex flex-wrap">
      <Modal :visible="showModal" @close="showModal = false">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div
              class="
                mx-auto
                flex-shrink-0 flex
                items-center
                justify-center
                h-12
                w-12
                rounded-full
                bg-red-100
                sm:mx-0
                sm:h-10
                sm:w-10
              "
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
                  This can cause many issues. Do you want to proceed?
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button
              @click="modalOk"
              type="button"
              class="
                inline-flex
                justify-center
                w-full
                rounded-md
                border border-transparent
                px-4
                py-2
                bg-red-600
                text-base
                leading-6
                font-medium
                text-white
                shadow-sm
                hover:bg-red-500
                focus:outline-none
                focus:border-red-700
                focus:shadow-outline-red
                transition
                ease-in-out
                duration-150
                sm:text-sm
                sm:leading-5
              "
              :class="{ submitting: modalSubmitting }"
            >
              Yes, Proceed

              <div class="loading"></div>
            </button>
          </span>

          <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <button
              @click="showModal = false"
              type="button"
              class="
                inline-flex
                justify-center
                w-full
                rounded-md
                border border-gray-300
                px-4
                py-2
                bg-white
                text-base
                leading-6
                font-medium
                text-gray-700
                shadow-sm
                hover:text-gray-500
                focus:outline-none
                focus:border-purple-300
                focus:shadow-outline-purple
                transition
                ease-in-out
                duration-150
                sm:text-sm
                sm:leading-5
              "
            >
              No
            </button>
          </span>
        </div>
      </Modal>
    </div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <client-only>
          <Button
            variant="success"
            :loading="false"
            :disableButton="false"
            icon="sign-in-alt"
            @click="showModalAction"
          >
            Show Modal
          </Button>
        </client-only>
      </div>
    </div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <client-only>
          <FormToggle v-model="formToggle"></FormToggle>
        </client-only>
      </div>
    </div>
    <div class="flex flex-wrap">
      <div class="w-full md:w-3/4 p-4">
        <client-only><FileDrop v-model="file"> </FileDrop> </client-only>
      </div>
    </div>
    <div class="flex flex-wrap border-t border-gray-200">
      <div class="w-full md:w-3/4">
        <Pagination
          :total="20"
          :perPage="2"
          totalPosts="8"
          @update-pagenumber="updatePageNumber"
          :paginationMeta="paginationMeta"
          toPageName="posts-page-page"
        />
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import Header from '~/components/Site/Header';
import Card from '~/components/Site/Card';
import CategoriesCard from '~/components/Site/CategoriesCard';
import Footer from '~/components/Site/Footer';
import Pagination from '~/components/Site/Pagination';
import FormText from '~/components/Input/FormText';
import FormTextarea from '~/components/Input/FormTextarea';
import FormCheckbox from '~/components/Input/FormCheckbox';
import FormDatePicker from '~/components/Input/FormDatePicker';
import FormToggle from '~/components/Input/FormToggle';
import FileDrop from '~/components/Input/FileDrop';
import DropDown from '~/components/Input/DropDown';
import Button from '~/components/Input/Button';
import FormRadio from '~/components/Input/FormRadio';
import FormSelect from '~/components/Input/FormSelect';
import Modal from '~/components/Site/Modal';
import Vue2Editor from '~/components/Input/Vue2Editor';
import { mapGetters } from 'vuex';

export default {
  name: 'Showcase',
  components: {
    Header,
    Card,
    CategoriesCard,
    Footer,
    Pagination,
    FormText,
    FormCheckbox,
    FormToggle,
    FileDrop,
    DropDown,
    Modal,
    FormTextarea,
    FormDatePicker,
    Button,
    FormRadio,
    FormSelect,
    Vue2Editor,
  },
  head: {
    title: 'Showcase',
  },
  computed: {
    ...mapGetters(['isAuthenticated', 'loggedInUser']),
    richTextBody() {
      //return md.parse(this.richTextContent);
      return this.richTextContent;
    },
    now: function () {
      return Date.now();
    },
  },
  created() {
    this.richTextContent = '';
  },
  data() {
    return {
      formText: null,
      checkBoxRequirement: [true, false, true, true],
      crd: null,
      tags: ['#react', '#javascript', '#tailwind'],
      carbrands: ['Toyota', 'Nissan', 'Isuzu', 'Ford'],
      selectedBrand: 'Isuzu',
      processingDate: new Date(),
      endDate: new Date(+new Date() + 2678400000),
      radio: ['AM', 'PM'],
      defaultCheck: 'AM',
      textAreaData: null,
      formToggle: true,
      file: null,
      richTextContent: '',
      bodyText: '',
      toLocation: 'posts-slug',
      showModal: false,
      modalSubmitting: false,
      articleData: {
        title:
          'Pariatur quaerat voluptatem et cumque perspiciatis velit architecto.',
        body: "is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
        description:
          "is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
        category: { title: 'catrgory title' },
        slug: 'pariatur-quaerat-voluptatem-et-cumque-perspiciatis-velit-architecto',
        created_at_dates: { created_at: 'Aug 16 2020' },
      },
      categoriesList: [
        { value: '1', name: 'Nissan' },
        { value: '2', name: 'Toyota' },
      ],
      selectedCategory: '2',
      categories: '',
      paginationMeta: {
        from: 1,
        to: 5,
      },
    };
  },
  methods: {
    updatePageNumber(e) {
      console.log(e);
    },
    showModalAction() {
      this.showModal = true;
    },
    modalOk() {
      this.showModal = false;
      this.modalSubmitting = false;
    },
  },
  watch: {
    formText(value) {
      if (value) {
        console.log(value);
      }
    },
    richTextContent(value) {
      this.richTextContent = value;
    },
    categories(value) {
      if (value) {
        console.log(value);
      }
    },
  },
};
</script>
