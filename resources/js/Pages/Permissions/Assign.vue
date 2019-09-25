<template>
    <layout title="Assign Permissions">
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-light hover:text-indigo-dark" :href="route('permissions')">
                Permissions
            </inertia-link>
            <span class="text-indigo-light font-medium">/</span> Create Assign Permissions
        </h1>
        <div class="mb-6 flex justify-between items-center">
            <inertia-link v-can="'permission-assign'" class="btn-indigo" :href="route('permissions.create')">
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
                    <th v-for="role in roles" class="px-6 pt-6 pb-4">{{ role.name }}</th>
                </tr>
                <tr v-for="permission in permissions" :key="permission.id"
                    class="hover:bg-grey-lightest focus-within:bg-grey-lightest">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo"
                                      :href="route('permissions.edit', permission.id)">
                            {{ permission.name }}
                            <icon v-if="permission.deleted_at" name="trash"
                                  class="flex-no-shrink w-3 h-3 fill-grey ml-2"/>
                        </inertia-link>
                    </td>
                    <td v-for="rolev in roles" class="border-t">
                        <span v-if="assign[rolev.id][permission.id]"
                              @click="assignData(rolev.id, permission.id, !assign[rolev.id][permission.id])"
                              class="border rounded-full border-grey flex items-center cursor-pointer w-12 bg-green justify-end">
                            <span class="rounded-full border w-6 h-6 border-grey shadow-inner bg-white shadow">
                            </span>
                          </span>
                        <span v-else
                              @click="assignData(rolev.id, permission.id, !assign[rolev.id][permission.id])"
                              class="border rounded-full border-grey flex items-center cursor-pointer w-12 justify-start">
                            <span class="rounded-full border w-6 h-6 border-grey shadow-inner bg-white shadow">
                            </span>
                          </span>
                    </td>
                </tr>
                <tr v-if="permissions.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No permissions found.</td>
                </tr>
            </table>
        </div>
    </layout>
</template>

<script>
  import Icon from '@/Shared/Icon'
  import Layout from '@/Shared/Layout'

  export default {
    components: {
      Layout,
      Icon,
    },

    remember: 'form',

    props: {
      permissions: Array,
      roles: Array,
      assign: Array,
    },

    data() {
      return {
        sending: false,
        form: {
          role_id: null,
          permission_id: null,
          use_it: null,
        },
      }
    },

    methods: {
      assignData(roleId, permissionId, useIt) {
        this.sending = true
        this.form.role_id = roleId
        this.form.permission_id = permissionId
        this.form.use_it = useIt
        this.$inertia.post(this.route('permissions.assign.update'), this.form)
          .then(() => this.sending = false)
      },
    }
    ,
  }
</script>
