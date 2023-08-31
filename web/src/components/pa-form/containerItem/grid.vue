<!--
 - PeanutAdmin is committed to providing solutions for quickly building web applications
-->
<template>
  <a-row
      v-if="(typeof props.component?.display == 'undefined' || props.component?.display === true)"
      :class="[props.component?.customClass]"
      :gutter="props.component?.gutter"
      :justify="props.component?.justify"
      :align="props.component?.align"
      :div="props.component?.div"
      :wrap="props.component?.wrap"
  >
    <template v-for="(col, colIndex) in (props.component?.cols ?? [])" :key="colIndex">
      <pa-grid-col :component="col">
        <template v-for="slot in Object.keys($slots)" #[slot]="component">
          <slot :name="slot" v-bind="component" />
        </template>
      </pa-grid-col>
    </template>
  </a-row>
</template>

<script setup>
import { onMounted } from 'vue'
import PaGridCol from './grid-col.vue'
import { paEvent } from '../js/formItemMixin.js'
const props = defineProps({ component: Object })

paEvent.handleCommonEvent(props.component, 'onCreated')
onMounted(() => {
  paEvent.handleCommonEvent(props.component, 'onMounted')
})
</script>