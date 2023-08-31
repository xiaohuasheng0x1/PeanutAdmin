<!--
 - PeanutAdmin is committed to providing solutions for quickly building web applications
-->
<template>
  <table
    v-if="(typeof props.component?.display == 'undefined' || props.component?.display === true)"
    :class="['table-container', props.component?.customClass]"
    :style="props.component?.style"
  > 
    <tbody>
      <tr
        v-for="(row, rowIndex) in (props.component?.rows ?? [])"
        :key="rowIndex"
        :class="['table-row', row?.customClass]"
        :style="row?.style"
      >
        <template v-for="(col, colIndex) in (row.cols ?? [])" :key="colIndex">
          <pa-table-cell :component="col">
            <template v-for="slot in Object.keys($slots)" #[slot]="component">
              <slot :name="slot" v-bind="component" />
            </template>
          </pa-table-cell>
        </template>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { onMounted } from 'vue'
import PaTableCell from './table-cell.vue'
import { paEvent } from '../js/formItemMixin.js'
const props = defineProps({ component: Object })

paEvent.handleCommonEvent(props.component, 'onCreated')
onMounted(() => {
  paEvent.handleCommonEvent(props.component, 'onMounted')
})
</script>

<style lang="less">
table.table-container {
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
  .table-cell {
    border: 1px solid var(--color-neutral-3);
    padding: 0.2em;
  }
}
</style>