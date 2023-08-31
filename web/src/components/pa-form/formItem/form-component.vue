<!--
 - PeanutAdmin is committed to providing solutions for quickly building web applications
-->
<template>
  <pa-form-item
    v-if="(typeof props.component.display == 'undefined' || props.component.display === true)"
    :component="props.component"
    :custom-field="props.customField"
  >
    <slot :name="`form-${props.component.dataIndex}`" v-bind="props.component">
      <component
        :is="props.component.dataIndex"
        :component="props.component"
        :customField="props.customField"
      />
    </slot>
  </pa-form-item>
</template>
  
<script setup>
import { onMounted, getCurrentInstance, watch } from 'vue'
import { get, set } from 'lodash'
import PaFormItem from './form-item.vue'
import { paEvent } from '../js/formItemMixin.js'

const props = defineProps({
  component: Object,
  customField: { type: String, default: undefined }
})

const app = getCurrentInstance().appContext.app

if (props.component.formType === 'component' && props.component.component && !app._context.components[props.component.dataIndex]) {
  app.component(props.component.dataIndex, props.component.component)
}

paEvent.handleCommonEvent(props.component, 'onCreated')
onMounted(() => {
  paEvent.handleCommonEvent(props.component, 'onMounted')
})
</script>