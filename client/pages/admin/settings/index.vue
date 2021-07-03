<template>
  <nuxt-link class="mt-4" to="/admin/settings/keyvalue">
    <div class="flex flex-wrap -mx-6">
      <div class="w-full mt-3 px-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
        <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
          <div>
            <font-awesome-icon
              :icon="['fas', 'key']"
              class="fa-fw fa-3x mr-1 fa-square fa-w-14"
            />
          </div>
          <div class="mx-5">
            <div>
              <h4 class="text-2xl font-semibold text-gray-700">Key Value</h4>
            </div>
            <div class="text-gray-500">
              Add, remove and edit key value pairs.
            </div>
          </div>
        </div>
      </div>
    </div>
  </nuxt-link>
</template>
<script>
export default {
  name: 'Settings',
  head: {
    title: 'Settings',
  },
  layout: 'adminLayout',
};
</script>
