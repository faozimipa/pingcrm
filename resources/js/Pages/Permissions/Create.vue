<template>
    <layout title="Create Organization">
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-light hover:text-indigo-dark" :href="route('permissions')">
                Permissions
            </inertia-link>
            <span class="text-indigo-light font-medium">/</span> Create
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-lg">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.name" :errors="$page.errors.name" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Name"/>
                </div>
                <div class="px-8 py-4 bg-grey-lightest border-t border-grey-lighter flex justify-end items-center">
                    <loading-button :loading="sending" class="btn-indigo" type="submit">Create Permissions
                    </loading-button>
                </div>
            </form>
        </div>
    </layout>
</template>

<script>
  import Layout from '@/Shared/Layout'
  import LoadingButton from '@/Shared/LoadingButton'
  import TextInput from '@/Shared/TextInput'

  export default {
    components: {
      Layout,
      LoadingButton,
      TextInput,
    },
    remember: 'form',
    data() {
      return {
        sending: false,
        form: {
          name: null,
        },
      }
    },
    methods: {
      submit() {
        this.sending = true
        this.$inertia.post(this.route('permissions.store'), this.form)
          .then(() => this.sending = false)
      },
    },
  }
</script>
