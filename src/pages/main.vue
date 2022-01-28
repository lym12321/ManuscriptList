<template>
    <div class="container pt-3">
        <div v-if="hasNotice" class="alert alert-success ct">
            {{ notice }}
        </div>
        <h4>第 {{ pos }} 页，共 {{ pageCount }} 页</h4>
        <div v-if="!loaded" class="spinner-border"></div>
        <div class="row">
            <div v-for="item in list" :key="item.id" class="col-md-4 pt-3">
                <div class="card">
                    <div class="card-header">{{ item.id }}、投稿人：{{ item.name }}</div>
                    <div class="card-body">
                        <p>提交时间： {{ item.time }}</p>
                        <p>提交IP： {{ item.ip }}</p>
                        <p v-if="item.text">文本：{{ item.text }}</p>
                        <p v-if="item.image.url">图像：<a :href="item.image.url">{{ item.image.name }}</a></p>
                        <p v-if="item.video.url">附件：<a :href="item.video.url">{{ item.video.name }}</a></p>
                        <a type="button" class="btn btn-outline-primary" :href="'./api/?method=getDetail&seq='+item.id">查看详情</a>
                    </div>
                </div>
            </div>
        </div>

        <ul class="pagination justify-content-center pt-3">
            <li class="page-item" v-if="pos != 1"><a class="page-link" href="#" @click="changePage('with', -1)">&laquo;</a></li>
            <li class="page-item" v-for="page in pageCount" :key="page" :class="{active: page == pos}"><a class="page-link" href="#" @click="changePage('to', page)">{{ page }}</a></li>
            <li class="page-item" v-if="pos != pageCount && pageCount > 1"><a class="page-link" href="#" @click="changePage('with', 1)">&raquo;</a></li>
        </ul>
    </div>
</template>
<script>
import { getList, getNotice } from '../axios/api.js'

export default{
    data() {
        return {
            hasNotice: null,
            notice: '',
            loaded: false,
            total: null,
            pageCount: null,
            pos: null,
            pageSize: null,
            list: []
        }
    },
    methods: {
        initNotice(){
            var that = this;
            getNotice().then((res) => {
                if(res.data.code == 404) {
                    that.hasNotice = false;
                }
                if(res.data.code == 200) {
                    that.hasNotice = true;
                    that.notice = res.data.result.notice;
                }
            })
        },
        initPage(pos){
            // this.pos = Number(this.getVal('p'));
            this.pos = pos;
            var that = this;
            getList(this.pos).then((res) => {
                console.log(res);
                that.list = res.data.result.list;
                that.total = res.data.result.total;
                that.pageSize = res.data.result.size;
                that.pageCount = Math.floor(res.data.result.total / res.data.result.size) + 1;
                if(res.data.result.total % res.data.result.size == 0) that.pageCount--;
                that.loaded = true;
            }).catch((err) => {
                alert("你遇到了奇怪的错误，请把 lym 拽过来修 bug.\n详细信息：" + err);
                that.initNotice();
                that.initPage(pos);
            });
        },
        changePage(opt, val) {
            if(opt == "to") {
                this.loaded = false;
                this.pos = Number(val);
                this.initPage(this.pos);
            }
            if(opt == "with") {
                this.loaded = false;
                this.pos = this.pos + Number(val);
                this.initPage(this.pos);
            }
        }
    },
    created() {
        this.initNotice();
        this.initPage(1);
    }
}
</script>
<style scoped>
    .ct{
        text-align: center;
    }
</style>