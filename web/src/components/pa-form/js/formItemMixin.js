import { isString, isFunction } from 'lodash'
export const paEvent = {
  customeEvent: async (component, value, evName) => {
    if (component[evName]) {
      if ( isFunction(component[evName]) ) {
        return await component[evName](value)
      }
      if ( isString(component[evName]) ) {
        let customFn = new Function('value', component[evName])
        return await customFn.call(component, value)
      }
    }
  },

  handleCommonEvent: (component, evName) => {
    if (component[evName]) {
      if ( isFunction(component[evName]) ) {
        return component[evName]()
      }
      if ( isString(component[evName]) ) {
        let customFn = new Function('value', component[evName])
        return customFn.call(component[evName])
      }
    }
  },

  handleInputEvent: (component, value) => {
    paEvent.customeEvent(component, value, 'onInput')
  },

  handleChangeEvent: (component, value) => {
    paEvent.customeEvent(component, value, 'onChange')
  },

  handleInputSearchEvent: (component, value) => {
    paEvent.customeEvent(component, value, 'onInputSearch')
  },

  handleTabClickEvent: (component, value) => {
    paEvent.customeEvent(component, value, 'onTabClick')
  },

  handleTabAddEvent: (component) => {
    paEvent.customeEvent(component, component?.tabs, 'onTabAdd')
  },

  handleTabDeleteEvent: (component, value) => {
    paEvent.customeEvent(component, { tabs: component?.tabs, value }, 'onTabDelete')
  },
}
