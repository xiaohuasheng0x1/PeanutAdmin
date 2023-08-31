import { request } from '@/utils/request.js'

export default {

  /**
   * 获取配置列表
   * @returns
   */
  getConfigList(params) {
    return request({
      url: 'backend/config/index',
      method: 'get',
      params
    })
  },

  /**
   * 清除缓存
   * @returns
   */
  clearCache(data = {}) {
    return request({
      url: 'backend/config/clearCache',
      method: 'post',
      data
    })
  },

  /**
   * 删除配置
   * @returns
   */
  delete(data) {
    return request({
      url: 'backend/config/delete',
      method: 'delete',
      data
    })
  },

  /**
   * 保存配置
   * @returns
   */
  save(data = {}) {
    return request({
      url: 'backend/config/save',
      method: 'post',
      data
    })
  },

  /**
   * 更新配置
   * @returns
   */
  update(key = '', data = {}) {
    return request({
      url: 'backend/config/update',
      method: 'post',
      data
    })
  },

  /**
   * 按 keys 更新配置
   * @returns 
   */
  updateByKeys(data) {
    return request({
      url: 'backend/config/updateByKeys',
      method: 'post',
      data
    })
  },

  /**
   * 获取组列表
   * @returns
   */
  getConfigGroupList(params = {}) {
    return request({
      url: 'backend/configGroup/index',
      method: 'get',
      params
    })
  },

  /**
   * 保存配置组
   * @returns
   */
  saveConfigGroup(data = {}) {
    return request({
      url: 'backend/configGroup/save',
      method: 'post',
      data
    })
  },

  /**
   * 更新配置组
   * @returns
   */
  updateConfigGroup(data = {}) {
    return request({
      url: 'backend/configGroup/update',
      method: 'post',
      data
    })
  },

  /**
   * 删除配置组
   * @returns
   */
   deleteConfigGroup(data = {}) {
    return request({
      url: 'backend/configGroup/delete',
      method: 'delete',
      data
    })
  },
}