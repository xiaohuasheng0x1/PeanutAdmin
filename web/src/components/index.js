import { use } from 'echarts/core'
import { CanvasRenderer } from 'echarts/renderers'
import { BarChart, LineChart, PieChart, RadarChart, GaugeChart } from 'echarts/charts'
import {
  GridComponent,
  TooltipComponent,
  LegendComponent,
  DataZoomComponent,
  GraphicComponent,
} from 'echarts/components'

import PaCrud from './pa-crud/index.vue'
import PaForm from './pa-form/index.vue'
import PaChart from './pa-charts/index.vue'
import PaUpload from './pa-upload/index.vue'
import PaTreeSlider from './pa-treeSlider/index.vue'
import PaResource from './pa-resource/index.vue'
import PaResourceButton from './pa-resource/button.vue'
import PaUser from './pa-user/index.vue'
import PaEditor from './pa-editor/index.vue'
import PaWangEditor from './pa-wangEditor/index.vue'
import PaIcon from './pa-icon/index.vue'
import PaCodeEditor from './pa-codeEditor/index.vue'
import PaUserInfo from './pa-userInfo/index.vue'
import PaCityLinkage from './pa-cityLinkage/index.vue'

use([
  CanvasRenderer,
  BarChart,
  LineChart,
  PieChart,
  RadarChart,
  GaugeChart,
  GridComponent,
  TooltipComponent,
  LegendComponent,
  DataZoomComponent,
  GraphicComponent,
]);

export default {
  install(Vue) {
    Vue.component('PaChart', PaChart)
    Vue.component('PaCrud', PaCrud)
    Vue.component('PaForm', PaForm)
    Vue.component('PaUpload', PaUpload)
    Vue.component('PaTreeSlider', PaTreeSlider)
    Vue.component('PaResource', PaResource)
    Vue.component('PaResourceButton', PaResourceButton)
    Vue.component('PaUser', PaUser)
    Vue.component('PaEditor', PaEditor)
    Vue.component('PaWangEditor', PaWangEditor)
    Vue.component('PaIcon', PaIcon)
    Vue.component('PaCodeEditor', PaCodeEditor)
    Vue.component('PaUserInfo', PaUserInfo)
    Vue.component('PaCityLinkage', PaCityLinkage)
  }
}
