<!--
 - PeanutAdmin is committed to providing solutions for quickly building web applications
-->
<template>
  <a-tabs
    v-if="(typeof props.component?.display == 'undefined' || props.component?.display === true)"
    :class="[props.component?.customClass]"
    :trigger="props.component?.trigger"
    :position="props.component?.position"
    :size="props.component?.size"
    :type="props.component?.type"
    :direction="props.component?.direction"
    :editable="props.component?.editable"
    :animation="props.component?.animation"
    :justify="props.component?.justify"
    :show-add-button="props.component?.showAddButton"
    :hide-content="props.component?.hideContent"
    :lazy-load="props.component?.lazyLoad"
    :destroy-on-hide="props.component?.destroyOnHide"
    @change="paEvent.handleChangeEvent(props.component, $event)"
    @tab-click="paEvent.handleTabClickEvent(props.component, $event)"
    @add="paEvent.handleTabAddEvent(props.component)"
    @delete="paEvent.handleTabDeleteEvent(props.component, $event)"
  >
    <template #extra>
      <slot :name="`tabExtra-${props.component?.dataIndex ?? ''}`"></slot>
    </template>
    <a-tab-pane
      v-for="(tab, index) in props.component?.tabs ?? []"
      :key="tab.key ?? index"
      :disabled="tab?.disabled"
      :closable="tab?.closable"
    >
      <template #title>
        <slot :name="`tabPanelTitle-${props.component?.dataIndex ?? ''}-${tab.key ?? index}`">
          {{ tab.title ?? `Tab ${index + 1}` }}
        </slot>
      </template>
      <template v-for="(component, componentIndex) in (tab.formList ?? [])" :key="componentIndex">
        <component
          :is="getComponentName(component?.formType ?? 'input')"
          :component="component"
        >
          <template v-for="slot in Object.keys($slots)" #[slot]="component">
            <slot :name="slot" v-bind="component" />
          </template>
        </component>
      </template>
    </a-tab-pane>
  </a-tabs>
</template>

<script setup>
import { onMounted } from 'vue'
import { getComponentName } from '../js/utils.js'
import { paEvent } from '../js/formItemMixin.js'
const props = defineProps({ component: Object })

paEvent.handleCommonEvent(props.component, 'onCreated')
onMounted(() => {
  paEvent.handleCommonEvent(props.component, 'onMounted')
})
</script>