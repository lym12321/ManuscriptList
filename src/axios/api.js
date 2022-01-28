import { get } from './index.js'

/**
 * 获取答卷列表
 * @param {string} page 
 * @param {string} pageSize 
 * @author lym12321
 */
export function getList(page, pageSize = "20"){
    return get("/api/", {'method': 'getList', 'page': page, 'pageSize': pageSize})
}

/**
 * 获取公告状态
 */
export function getNotice(){
    return get("/api/", {'method': 'getNotice'})
}