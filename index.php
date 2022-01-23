<!doctype html>
<html>
    <head>
        <title>稿件队列（Beta）</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div id="title" class="navbar-header">
                    <a class="navbar-brand" href="#">稿件队列</a>
                </div>
            </div>
        </nav>
        
        <div class="container">
            <div id="notice">
                <div class="alert alert-success" role="alert" v-if="seen">
                    <!-- notice  -->
                    <center>{{ text }}</center>
                </div>
            </div>
            <div id="list">
                <!-- 稿件列表 -->
                <h3>队列中现有稿件：{{ count }} 个</h3>
                <h5>第 {{ pos }} 页，共 {{ pageCount }} 页</h5>
                <!-- <div v-for="(item, index) in reverseList"> -->
                    <div v-for="item in items">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">{{ item.id }}. 投稿人：{{ item.name }}</h3>
                            </div>
                            <div class="panel-body">
                                <!--<p> 任务ID：{{ item.id }}</p>-->
                                <p> 提交IP：{{ item.ip }} </p>
                                <p> 提交时间：{{ item.time }} </p>
                                <p v-if="item.text"> 稿件文本：{{ item.text }} </p>
                                <p v-if="item.image.url"> 稿件图像：<a :href="item.image.url">{{ item.image.name }}</a></p>
                                <p v-if="item.video.url"> 稿件附件：<a :href="item.video.url">{{ item.video.name }}</a></p>
                                <!--<p> 稿件负责人：{{ item.occupiedBy }} </p>-->
                                <!--<p><a class="btn btn-primary" :href="item.detailUrl" role="button">查看推送</a></p>-->
                            </div>
                        </div>
                </div>
                <center>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li v-if="pos != 1">
                                <a :href="'?p='+(pos-1)" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li v-for="page in pageCount">
                                <a :href="'?p='+page">{{page}}</a>
                            </li>
                            <li v-if="pos != pageCount && pageCount != 1">
                                <a :href="'?p='+(pos+1)" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </center>
            </div>
        </div>
        
        <br>
        <center>
            <p>Author: lym12321 | Version: 20220122</p>
            <!--<p>此页面信息实时更新</p>-->
            <!--<p>所有信息仅供晞南志行队内部使用，严禁外传！</p>-->
        </center>
        
        <!-- axios -->
        <script src="https://cdn.bootcdn.net/ajax/libs/axios/0.21.1/axios.min.js"></script>
        <!-- jQuery -->
        <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
        <!-- Vue.js -->
        <script src="https://cdn.bootcdn.net/ajax/libs/vue/3.2.0-beta.7/vue.global.min.js"></script>
        <!--<script src="src/getList.php"></script>-->
        <script src="src/getConfig.php"></script>
        <!--<script src="src/config.js"></script>-->
    </body>
</html>