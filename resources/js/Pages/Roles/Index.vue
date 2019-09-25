<template>
    <layout title="Roles">
        <h1 class="mb-8 font-bold text-3xl">Roles</h1>
        <div class="mb-6 flex justify-between items-center">
<!--            <search-filter v-model="form.search" class="w-full max-w-sm mr-4" @reset="reset">-->
<!--                <label class="block text-grey-darkest">Trashed:</label>-->
<!--                <select v-model="form.trashed" class="mt-1 w-full form-select">-->
<!--                    <option :value="null" />-->
<!--                    <option value="with">With Trashed</option>-->
<!--                    <option value="only">Only Trashed</option>-->
<!--                </select>-->
<!--            </search-filter>-->
            <inertia-link class="btn-indigo" :href="route('roles.create')">
                <span>Create</span>
                <span class="hidden md:inline">Roles</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Name</th>
                    <th class="px-6 pt-6 pb-4">Guard</th>
                    <th class="px-6 pt-6 pb-4">Action</th>
                </tr>
                <tr v-for="role in roles.data" :key="role.id" class="hover:bg-grey-lightest focus-within:bg-grey-lightest">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo">
                            {{ role.name }}
                            <icon v-if="role.deleted_at" name="trash" class="flex-no-shrink w-3 h-3 fill-grey ml-2" />
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center" tabindex="-1">
                            {{ role.guard_name }}
                        </p>
                    </td>
                    <td class="border-t w-px">
                        <div v-can="'role-delete'" class="px-4 flex items-center" @click="destroy(role.id)" tabindex="-1">
                           <icon v-can="'role-delete'" name="trash" class="block w-6 h-6 fill-red"/>
                        </div>
                    </td>
                </tr>
                <tr v-if="roles.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No roles found.</td>
                </tr>
            </table>
        </div>
        <pagination :links="roles.links" />

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
    roles: Object,
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
        this.$inertia.replace(this.route('roles', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },

  methods: {
    reset() {
      this.form = _.mapValues(this.form, () => null)
    },
    destroy(id) {
      if (confirm('Are you sure you want to delete this role?')) {
        this.$inertia.delete(this.route('roles.destroy', id))
      }
    },
  },
}
</script>
