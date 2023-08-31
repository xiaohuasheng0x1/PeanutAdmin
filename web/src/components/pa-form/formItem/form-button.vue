<!--
 - PeanutAdmin is committed to providing solutions for quickly building web applications
-->
<template>
  <slot :name="`form-${props.component.dataIndex}`" v-bind="props.component">
    <a-button
      :type="props.component.type"
      :status="props.component.status"
      :size="props.component.size"
      :shape="props.component.shape"
      :disabled="props.component.disabled"
      :long="props.component.long"
      :loading="props.component.loading"
      :html-type="props.component.htmlType"
      :href="props.component.href"
      @click="paEvent.handleCommonEvent(props.component, 'onClick')"
    >
      <template #icon v-if="props.component.icon">
        <component :is="props.component.icon" />
      </template>
      {{ props.component.title ?? 'button' }}
    </a-button>
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