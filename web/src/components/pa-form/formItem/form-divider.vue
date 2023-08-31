<!--
 - PeanutAdmin is committed to providing solutions for quickly building web applications
-->
<template>
  <slot :name="`form-${props.component.dataIndex}`" v-bind="props.component">
    <a-divider
      v-if="(typeof props.component.display == 'undefined' || props.component.display === true)"
      :class="[ props.component.customClass ]"
      :margin="props.component.margin"
      :direction="props.component.direction"
      :orientation="props.component.orientation"
      :type="props.component.type"
      :size="props.component.size"
    >
      {{ props.component?.title ?? '' }}
    </a-divider>
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