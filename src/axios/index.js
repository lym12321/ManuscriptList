/**
 * @description axios 封装
 * @author lym12321
 */

import axios from 'axios'
// var qs = require('qs')
import qs from 'qs'

axios.defaults.baseURL = './'
axios.defaults.timeout = 5000
axios.defaults.withCredentials = true
axios.defaults.withCredentials = true

axios.interceptors.request.use(config => {
    config.headers = {
        'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
    }
    return config
}, err => {
    return Promise.reject(err)
})

axios.interceptors.response.use(response => {
    return response
}, err => {
    return Promise.reject(err)
})

/**
 * get请求
 * @param {string} url 请求url
 * @param {Object} data 请求参数
 */
export function get(url, data = {}){
    return axios.get(url, {params: data})
}

/**
 * post请求
 * @param {string} url 请求url
 * @param {Object} data 请求参数
 */
export function post(url, data = {}){
    return axios.post(url, qs.stringify(data))
}

/**
 * post json请求
 * @param {string} url 请求url
 * @param {Object} data 请求参数
 */
export function postWithJson(url, data = {}){
    return axios.post(url, data)
}

/**
 * post form请求
 * @param {string} url 请求url
 * @param {Object} data 发送的数据
 * @return {Promise}
 */
export function postForm(url, data = {}){
    return axios.post(url, 
        qs.stringify(data),
        {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }
    )
}