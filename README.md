# ManuscriptList
可以与问卷网（<https://www.wenjuan.design/>）开放平台对接，用作公众号接收大众投稿的稿件队列

## 后端  
暂时使用 `php` 封装接口，前端页面可使用 `get` 方式从 `./api/` 获取相关信息。  
#### 现有接口
 - getList：`./api/?method=getList` | 获取问卷列表  
 - getNotice：`./api/?method=getNotice` | 获取通知  
 - getDetail：`./api/?method=getDetail&seq={ 问卷id }` | 跳转到问卷详情页面

## Todo List
- [ ] 稿件列表倒序显示
- [X] 分页
