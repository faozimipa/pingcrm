<template>
  <div>
    <div class="form-switch inline-block align-middle">
      <input id="1" v-model="isToggleOn" :value="value" type="checkbox" name="1" class="form-switch-checkbox" @change="$emit('input', $event.target.checked)">
      <label class="form-switch-label" for="1" />
    </div>
    <label class="text-xs text-grey-dark" for="1">{{ `${ isToggleOn ? onText : offText }` }}</label>
  </div>
</template>

<script>
export default {
  props: ['value', 'onText', 'offText'],
  data () {
    return {
      isToggleOn: false,
    }
  },
  mounted () {
    this.isToggleOn = this.value
  },
}
</script>