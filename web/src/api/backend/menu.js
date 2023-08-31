import { request } from '@/utils/request.js'

export default {
  /**
   * 获取菜单树
   * @returns
   */
  getList(params = {}) {
    return request({
      url: 'backend/menu/index',
      method: 'get',
      params
    })
  },

  /**
   * 从回收站获取菜单树
   * @returns
   */
  getRecycleList(params = {}) {
    return request({
      url: 'backend/menu/recycle',
      method: 'get',
      params
    })
  },

  /**
   * 获取菜单选择树
   * @returns
   */
  tree(params = {}) {
    return request({
      url: 'backend/menu/tree',
      method: 'get',
      params
    })
  },

  /**
   * 添加菜单
   * @returns
   */
  save(params = {}) {
    return request({
      url: 'backend/menu/save',
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
      url: 'backend/menu/delete',
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
      url: 'backend/menu/recovery',
      method: 'put',
      data
    })
  },

  /**
   * 真实删除
   * @returns
   */
  realDeletes(data) {
    return request({
      url: 'backend/menu/realDelete',
      method: 'delete',
      data
    })
  },

  /**
   * 更新数据
   * @returns
   */
  update(id, data = {}) {
    return request({
      url: 'backend/menu/update/' + id,
      method: 'put',
      data
    })
  },

  /**
   * 数字运算操作
   * @returns
   */
  numberOperation(data = {}) {
    return request({
      url: 'backend/menu/numberOperation',
      method: 'put',
      data
    })
  },

  /**
   * 更改菜单状态
   * @returns
   */
  changeStatus(data = {}) {
    return request({
      url: 'backend/menu/changeStatus',
      method: 'put',
      data
    })
  },
}
