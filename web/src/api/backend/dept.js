import { request } from '@/utils/request.js'

export default {
  /**
   * 获取部门树
   * @returns
   */
  getList(params = {}) {
    return request({
      url: 'backend/dept/index',
      method: 'get',
      params
    })
  },

  /**
   * 获取部门领导列表
   * @returns
   */
  getLeaderList(params = {}) {
    return request({
      url: 'backend/dept/getLeaderList',
      method: 'get',
      params
    })
  },

  /**
   * 新增部门领导
   * @returns
   */
  addLeader(data = {}) {
    return request({
      url: 'backend/dept/addLeader',
      method: 'post',
      data
    })
  },


  /**
   * 删除部门领导
   * @returns
   */
  delLeader(data = {}) {
    return request({
      url: 'backend/dept/delLeader',
      method: 'delete',
      data
    })
  },

  /**
   * 从回收站获取部门树
   * @returns
   */
  getRecycleList(params = {}) {
    return request({
      url: 'backend/dept/recycle',
      method: 'get',
      params
    })
  },

  /**
   * 获取部门选择树
   * @returns
   */
  tree() {
    return request({
      url: 'backend/dept/tree',
      method: 'get'
    })
  },

  /**
   * 添加部门
   * @returns
   */
  save(params = {}) {
    return request({
      url: 'backend/dept/save',
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
      url: 'backend/dept/delete',
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
      url: 'backend/dept/recovery',
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
      url: 'backend/dept/realDelete',
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
      url: 'backend/dept/update/' + id,
      method: 'put',
      data: params
    })
  },
  
  /**
   * 数字运算操作
   * @returns
   */
   numberOperation(data = {}) {
    return request({
      url: 'backend/dept/numberOperation',
      method: 'put',
      data
    })
  },

  /**
   * 更改部门状态
   * @returns
   */
  changeStatus(data = {}) {
    return request({
      url: 'backend/dept/changeStatus',
      method: 'put',
      data
    })
  },
}
