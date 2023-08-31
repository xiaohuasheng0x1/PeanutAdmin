<!--
 - PeanutAdmin is committed to providing solutions for quickly building web applications
-->
<template>
  <slot :name="`form-${props.component.dataIndex}`" v-bind="props.component">
    <div
      v-if="(typeof props.component.display == 'undefined' || props.component.display === true)"
      :class="[ 'static-text', props.component.customClass ]"
      :style="props.component.style"
    >{{ props.component.title ?? '' }}</div>
  </slot>
</template>
  
<script setup>
import { onMounted } from 'vue'
import { paEvent } from '../js/formItemMixin.js'
const props = defineProps({
  component: Object,
})

paEvent.handleCommonEvent(props.component, 'onCreated')
onMounted(() => {
  paEvent.handleCommonEvent(props.component, 'onMounted')
})
</script>