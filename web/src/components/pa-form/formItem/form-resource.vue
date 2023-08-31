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
      <pa-resource
        v-if="(props.component.type ?? 'preview') == 'preview'"
        v-model="value"
        :multiple="props.component.multiple"
        :onlyData="props.component.onlyData"
        :returnType="props.component.returnType"
      />
      <pa-resource-button
        v-else
        v-model="value"
        :multiple="props.component.multiple"
        :onlyData="props.component.onlyData"
        :returnType="props.component.returnType"
      />
    </slot>
  </pa-form-item>
</template>

<script setup>
import { ref, inject, onMounted, watch } from 'vue'
import { get, set } from 'lodash'
import PaResource from '@/components/pa-resource/index.vue'
import PaResourceButton from '@/components/pa-resource/button.vue'
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

if (props.component.multiple && ! value.value) {
  value.value = []
}

paEvent.handleCommonEvent(props.component, 'onCreated')
onMounted(() => {
  paEvent.handleCommonEvent(props.component, 'onMounted')
})
</script>