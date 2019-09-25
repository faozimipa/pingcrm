<template>
    <layout title="Permissions">
        <h1 class="mb-8 font-bold text-3xl">Permissions</h1>
        <div class="mb-6 flex justify-between items-center">
            <inertia-link v-can="'permission-assign'" class="btn-indigo" :href="route('permissions.assign')">
                <span>Assign</span>
                <span class="hidden md:inline">Permissions</span>
            </inertia-link>
            <inertia-link v-can="'permission-create'" class="btn-indigo" :href="route('permissions.create')">
                <span>Add New</span>
                <span class="hidden md:inline">Permissions</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Name</th>
                    <th class="px-6 pt-6 pb-4">Guard</th>
                </tr>
                <tr v-for="permission in permissions.data" :key="permission.id" class="hover:bg-grey-lightest focus-within:bg-grey-lightest">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo" :href="route('permissions.edit', permission.id)">
                            {{ permission.name }}
                            <icon v-if="permission.deleted_at" name="trash" class="flex-no-shrink w-3 h-3 fill-grey ml-2" />
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('permissions.edit', permission.id)" tabindex="-1">
                            {{ permission.guard_name }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('permissions.edit', permission.id)" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-grey" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="permissions.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No permissions found.</td>
                </tr>
            </table>
        </div>
        <pagination :links="permissions.links" />

    </layout>
</template>

<script>
  import _ from 'lodash'
  import Icon from '@/Shared/Icon'
  import Layout from '@/Shared/Layout'
  import Pagination from '@/Shared/Pagination'

  export default {
    components: {
      Layout,
      Icon,
      Pagination,
    },

    props: {
      permissions: Object,
      filters: Object,
    },


    data() {
      return {
        form: {
          search: this.filters.search,
        },
      }
    },

    watch: {
      form: {
        handler: _.throttle(function() {
          let query = _.pickBy(this.form)
          this.$inertia.replace(this.route('permissions', Object.keys(query).length ? query : { remember: 'forget' }))
        }, 150),
        deep: true,
      },
    },

    methods: {
      reset() {
        this.form = _.mapValues(this.form, () => null)
      },
    },
  }
</script>
