import { request } from '@/utils/request.js'

export default {
  /**
   * 获取代码生成列表
   * @returns
   */
  getPageList (params = {}) {
    return request({
      url: 'backend/code/index',
      method: 'get',
      params
    })
  },

  /**
   * 删除
   * @returns
   */
  deletes (data) {
    return request({
      url: 'backend/code/delete',
      method: 'delete',
      data
    })
  },

  /**
   * 编辑生成信息
   * @returns
   */
  update (data = {}) {
    return request({
      url: 'backend/code/update',
      method: 'post',
      data
    })
  },

  readTable (params = {}) {
    return request({
      url: 'backend/code/readTable',
      method: 'get',
      params
    })
  },

  /**
   * 生成代码
   * @returns
   */
  generateCode (data = {}) {
    return request({
      url: 'backend/code/generate',
      method: 'post',
      responseType: 'blob',
      timeout: 20 * 1000,
      data,
    })
  },

  /**
   * 装载数据表
   * @returns
   */
  loadTable (data = {}) {
    return request({
      url: 'backend/code/loadTable',
      method: 'post',
      data
    })
  },

  /**
   * 同步数据表
   * @returns
   */
  sync (data) {
    return request({
      url: 'backend/code/sync/' + data,
      method: 'put'
    })
  },

  /**
   * 预览代码
   * @returns
   */
  preview (params = {}) {
    return request({
      url: 'backend/code/preview',
      method: 'get',
      params
    })
  },

  // 获取表中字段信息
  getTableColumns(params = {}) {
    return request({
      url: 'backend/code/getTableColumns',
      method: 'get',
      params
    })
  },

  // 获取数据源列表
  getDataSourceList(params = {}) {
    return request({
      url: 'backend/code/getDataSourceList',
      method: 'get',
      params
    })
  },

  // 获取所有模型
  getModels() {
    return request({
      url: 'backend/code/getModels',
      method: 'get',
    })
  }
}