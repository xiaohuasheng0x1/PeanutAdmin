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
      <a-rate
        v-model="value"
        :size="props.component.size"
        :allow-clear="props.component.allowClear"
        :disabled="props.component.disabled"
        :readonly="props.component.readonly"
        :count="props.component.count"
        :allow-half="props.component.allowHalf"
        :grading="props.component.grading"
        :color="props.component.color"
        @change="paEvent.handleInputEvent(props.component, $event)"
        @hover-change="paEvent.customeEvent(props.component, $event, 'onHoverChange')"
      >
      </a-rate>
    </slot>
  </pa-form-item>
</template>

<script setup>
import { ref, inject, onMounted, watch } from 'vue'
import { get, set } from 'lodash'
import PaFormItem from './form-item.vue'
import { paEvent } from '../js/formItemMixin.js'
const props = defineProps({
  component: Object,
  customField: { type: String, default: undefined }
})

const formModel = inject('formModel')
const index = props.customField ?? props.component.dataIndex
const value = ref(get(formModel.value, index))

watch( () => get(formModel.value, index), vl => value.value = vl )
watch( () => value.value, v => {
  set(formModel.value, index, v)
  index.indexOf('.') > -1 && delete formModel.value[index]
} )

paEvent.handleCommonEvent(props.component, 'onCreated')
onMounted(() => {
  paEvent.handleCommonEvent(props.component, 'onMounted')
})
</script>