// config.js
// @Author: lym12321
// @Date: 2022/01/21

console.log("config.js Version 20220121")

const notice = {
    data(){
        return{
            seen: true,
            text: '本页面数据实时更新！！！'
        }
    }
}
Vue.createApp(notice).mount('#notice');

const list = {
    data(){
        return{
            pos: 1,
            pageCount: 1,
            count: '',
            items: []
        }
    },
    methods: {
        getVal(variable){
               var query = window.location.search.substring(1);
               var vars = query.split("&");
               for (var i=0;i<vars.length;i++) {
                       var pair = vars[i].split("=");
                       if(pair[0] == variable){return pair[1];}
               }
               return(false);
        },
        init(){
            var that = this;
            that.pos = Number(that.getVal('p'));
            if(!that.pos) that.pos = 1;
            axios.get("api/?method=getList&page="+that.pos).then((res)=>{
                if(res.data.code == 200){
                    console.log(res.data);
                    that.count = res.data.result.total;
                    that.items = res.data.result.list;
                    that.pageCount = Math.floor(res.data.result.total / res.data.result.size) + 1;
                    if(res.data.result.total % res.data.result.size == 0) that.pageCount--;
                    // console.log(this.pageCount);
                }
            }).catch((err)=>{
                alert("你遇到了不明原因的错误，请把 lym 拽过来修 bug.\n详细信息：" + err);
            })
        }
    },
    created(){
        this.init()
    },
    computed: {
        reverseList() {
            return this.items.reverse();
        }
    }
}
Vue.createApp(list).mount('#list');