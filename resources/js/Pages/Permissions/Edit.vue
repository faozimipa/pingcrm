<template>
  <layout :title="form.name">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-light hover:text-indigo-dark" :href="route('permissions')">Permissions</inertia-link>
      <span class="text-indigo-light font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="permission.deleted_at" class="mb-6" @restore="restore">
      This permission has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-hidden max-w-lg">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :errors="$page.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
        </div>
        <div class="px-8 py-4 bg-grey-lightest border-t border-grey-lighter flex items-center">
          <div v-can="'permission-delete'">
            <button v-if="!permission.deleted_at" class="text-red hover:underline" tabindex="-1" type="button" @click="destroy">Delete permission</button>
          </div>
          <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Update Permission</loading-button>
        </div>
      </form>
    </div>
  </layout>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import TextInput from '@/Shared/TextInput'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Layout,
    LoadingButton,
    TextInput,
    TrashedMessage,
  },
  props: {
    permission: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.permission.name,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('permissions.update', this.permission.id), this.form)
        .then(() => this.sending = false)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this permission?')) {
        this.$inertia.delete(this.route('permissions.destroy', this.permission.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this permission?')) {
        this.$inertia.put(this.route('permission.restore', this.permission.id))
      }
    },
  },
}
</script>
