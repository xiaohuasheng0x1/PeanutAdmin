import { request } from '@/utils/request.js'

export const dictType = {

  /**
   * 获取字典类型，无分页
   * @returns
   */
  getTypeList(params = {}) {
    return request({
      url: 'backend/dictType/index',
      method: 'get',
      params
    })
  },

  /**
   * 从回收站获取字典类型
   * @returns
   */
  getRecycleTypeList(params = {}) {
    return request({
      url: 'backend/dictType/recycle',
      method: 'get',
      params
    })
  },

  /**
   * 添加字典类型
   * @returns
   */
  save(params = {}) {
    return request({
      url: 'backend/dictType/save',
      method: 'post',
      data: params
    })
  },

  /**
   * 移到回收站
   * @returns
   */
  deletes(data) {
    return request({
      url: 'backend/dictType/delete',
      method: 'delete',
      data
    })
  },

  /**
   * 恢复数据
   * @returns
   */
  recoverys(data) {
    return request({
      url: 'backend/dictType/recovery',
      method: 'put',
      data
    })
  },

  /**
   * 真实删除
   * @returns
   */
  realDelete(data) {
    return request({
      url: 'backend/dictType/realDelete',
      method: 'delete',
      data
    })
  },

  /**
   * 更新数据
   * @returns
   */
  update(id, params = {}) {
    return request({
      url: 'backend/dictType/update/' + id,
      method: 'put',
      data: params
    })
  },

  /**
   * 更改字典类型状态
   * @returns
   */
  changeStatus(data = {}) {
    return request({
      url: 'backend/dictType/changeStatus',
      method: 'put',
      data
    })
  },
}

export const dict = {
  /**
   * 快捷查询字典
   * @param {*} params
   * @returns
   */
  getDict(code) {
    return request({
      url: 'backend/dataDict/list?code=' + code,
      method: 'get'
    })
  },

  /**
   * 快捷查询多个字典
   * @param {*} params
   * @returns
   */
  getDicts(codes) {
    return request({
      url: 'backend/dataDict/lists?codes=' + codes.join(','),
      method: 'get'
    })
  },

  /**
   * 获取字典数据分页列表
   * @returns
   */
  getPageList(params = {}) {
    return request({
      url: 'backend/dataDict/index',
      method: 'get',
      params
    })
  },

  /**
   * 从回收站获取字典数据
   * @returns
   */
  getRecyclePageList(params = {}) {
    return request({
      url: 'backend/dataDict/recycle',
      method: 'get',
      params
    })
  },

  /**
   * 添加字典数据
   * @returns
   */
  saveDictData(data = {}) {
    return request({
      url: 'backend/dataDict/save',
      method: 'post',
      data
    })
  },

  /**
   * 移到回收站
   * @returns
   */
  deletesDictData(data) {
    return request({
      url: 'backend/dataDict/delete',
      method: 'delete',
      data
    })
  },

  /**
   * 恢复数据
   * @returns
   */
  recoverysDictData(data) {
    return request({
      url: 'backend/dataDict/recovery',
      method: 'put',
      data
    })
  },

  /**
   * 真实删除
   * @returns
   */
  realDeletesDictData(data) {
    return request({
      url: 'backend/dataDict/realDelete',
      method: 'delete',
      data
    })
  },

  /**
   * 更新数据
   * @returns
   */
  updateDictData(id, data = {}) {
    return request({
      url: 'backend/dataDict/update/' + id,
      method: 'put',
      data
    })
  },

  /**
   * 清空缓存
   * @returns
   */
  clearCache() {
    return request({
      url: 'backend/dataDict/clearCache',
      method: 'post'
    })
  },

  /**
   * 数字运算操作
   * @returns
   */
  numberOperation(data = {}) {
    return request({
      url: 'backend/dataDict/numberOperation',
      method: 'put',
      data
    })
  },

  /**
   * 更改字典状态
   * @returns
   */
  changeStatus(data = {}) {
    return request({
      url: 'backend/dataDict/changeStatus',
      method: 'put',
      data
    })
  },
}