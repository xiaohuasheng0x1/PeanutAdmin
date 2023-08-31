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
      <a-input
        v-model="value"
        :placeholder="props.component.placeholder ?? '请输入验证码'"
        allow-clear
      >
        <template #append>
          <pa-verify-code ref="formVerifyCode"
            :height="props.component.height ?? 32"
            :width="props.component.width"
            :size="props.component.size"
            :pool="props.component.pool"
            :showError="false"
          />
        </template>
      </a-input>
    </slot>
  </pa-form-item>
</template>

<script setup>
import { ref, inject, onMounted, watch } from 'vue'
import { get, set } from 'lodash'
import PaVerifyCode from '@/components/pa-verifyCode/index.vue'
import PaFormItem from './form-item.vue'
import { paEvent } from '../js/formItemMixin.js'

const props = defineProps({
  component: Object,
  customField: { type: String, default: undefined }
})

const formVerifyCode = ref()
const formModel = inject('formModel')
const index = props.customField ?? props.component.dataIndex
const value = ref(get(formModel.value, index))

watch( () => get(formModel.value, index), vl => value.value = vl )
watch( () => value.value, v => {
  set(formModel.value, index, v)
  index.indexOf('.') > -1 && delete formModel.value[index]
} )

const component = props.component
component.rules = [
  { required: true, message: '请输入验证码' },
  {
    validator: (value, callback) => {
      if (! formVerifyCode.value.checkResult(value)) {
        callback('验证码错误')
        return false
      }
    }
  }
]

paEvent.handleCommonEvent(props.component, 'onCreated')
onMounted(() => {
  paEvent.handleCommonEvent(props.component, 'onMounted')
})
</script>

<style scoped>
:deep(.arco-input-append) {
  padding: 0;
}
</style>