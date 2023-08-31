import { request } from '@/utils/request.js'

export default {
  /**
   * 获取岗位分页列表
   * @returns
   */
  getPageList(params = {}) {
    return request({
      url: 'backend/post/index',
      method: 'get',
      params
    })
  },

  /**
   * 获取岗位列表
   * @returns
   */
  getList(params = {}) {
    return request({
      url: 'backend/post/list',
      method: 'get',
      params
    })
  },

  /**
   * 从回收站获取岗位
   * @returns
   */
  getRecyclePageList(params = {}) {
    return request({
      url: 'backend/post/recycle',
      method: 'get',
      params
    })
  },

  /**
   * 添加岗位
   * @returns
   */
  save(params = {}) {
    return request({
      url: 'backend/post/save',
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
      url: 'backend/post/delete',
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
      url: 'backend/post/recovery',
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
      url: 'backend/post/realDelete',
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
      url: 'backend/post/update/' + id,
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
      url: 'backend/post/numberOperation',
      method: 'put',
      data
    })
  },

  /**
   * 更改岗位状态
   * @returns
   */
  changeStatus(data = {}) {
    return request({
      url: 'backend/post/changeStatus',
      method: 'put',
      data
    })
  },

}