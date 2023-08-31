import { request } from '@/utils/request.js'

export default {
  /**
   * 获取用户列表
   * @returns
   */
  getUserList(params = {}) {
    return request({
      url: 'backend/common/getUserList',
      method: 'get',
      params
    })
  },

  /**
   * 通过id 列表获取用户基础信息
   * @returns
   */
   getUserInfoByIds(data = {}) {
    return request({
      url: 'backend/common/getUserInfoByIds',
      method: 'post',
      data
    })
  },

  /**
   * 获取部门列表
   * @returns
   */
  getDeptTreeList(params = {}) {
    return request({
      url: 'backend/common/getDeptTreeList',
      method: 'get',
      params
    })
  },

  /**
   * 获取角色列表
   * @returns
   */
  getRoleList(params = {}) {
    return request({
      url: 'backend/common/getRoleList',
      method: 'get',
      params
    })
  },

  /**
   * 获取岗位列表
   * @returns
   */
  getPostList(params = {}) {
    return request({
      url: 'backend/common/getPostList',
      method: 'get',
      params
    })
  },

  /**
   * 获取公告列表
   * @returns
   */
  getNoticeList(params = {}) {
    return request({
      url: 'backend/common/getNoticeList',
      method: 'get',
      params
    })
  },

  /**
   * 清除所有缓存
   * @returns
   */
  clearAllCache() {
    return request({
      url: 'backend/common/clearAllCache',
      method: 'get'
    })
  },

  /**
   * 获取所有文件
   * @returns
   */
   getAllFiles (params = {}) {
    return request({
      url: 'backend/getAllFiles',
      method: 'get',
      params
    })
  },

  /**
   * 上传图片接口
   * @returns
   */
  uploadImage (data = {}) {
    return request({
      url: 'backend/uploadImage',
      method: 'post',
      timeout: 30000,
      data
    })
  },

  /**
   * 上传文件接口
   * @returns
   */
  uploadFile (data = {}) {
    return request({
      url: 'backend/uploadFile',
      method: 'post',
      timeout: 30000,
      data
    })
  },

  /**
   * 分片上传接口
   * @returns
   */
  chunkUpload (data = {}) {
    return request({
      url: 'backend/chunkUpload',
      method: 'post',
      timeout: 30000,
      data
    })
  },

  /**
   * 保存网络图片
   * @returns
   */
  saveNetWorkImage (data = {}) {
    return request({
      url: 'backend/saveNetworkImage',
      method: 'post',
      data
    })
  },

  /**
   * 获取登录日志列表
   */
  getLoginLogList(params = {}) {
    return request({
      url: 'backend/common/getLoginLogList',
      method: 'get',
      params
    })
  },
  
  /**
   * 获取操作日志列表
   */
   getOperationLogList(params = {}) {
    return request({
      url: 'backend/common/getOperationLogList',
      method: 'get',
      params
    })
  },

  /**
   * 获取资源列表
   */
  getResourceList(params = {}) {
    return request({
      url: 'backend/common/getResourceList',
      method: 'get',
      params
    })
  },

  /**
   * 通用导入Excel 
   */
  importExcel (url, data) {
    return request({ url, method: 'post', data, timeout: 30 * 1000 })
  },

  /**
   * 下载通用方法
   */
  download(url, method = 'post') {
    return request({ url, method, responseType: 'blob' })
  },

  /**
   * 快捷查询字典
   */
  getDict(code) {
    return request({
      url: 'backend/dataDict/list?code=' + code,
      method: 'get'
    })
  },

  /**
   * 快捷查询多个字典
   */
  getDicts(codes) {
    return request({
      url: 'backend/dataDict/lists?codes=' + codes.join(','),
      method: 'get'
    })
  },

  downloadById(id) {
    return request({
      url: 'backend/downloadById?id=' + id,
      method: 'get',
    })
  },

  downloadByHash(hash) {
    return request({
      url: 'backend/downloadByHash?hash=' + hash,
      method: 'get',
    })
  },

  getFileInfoById(id) {
    return request({
      url: 'backend/getFileInfoById?id=' + id,
      method: 'get',
    })
  },

  getFileInfoByHash(hash) {
    return request({
      url: 'backend/getFileInfoByHash?hash=' + hash,
      method: 'get',
    })
  }
}
