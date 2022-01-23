<?php
    include "config.php";
    
    function report($code, $message, $result){
        die(json_encode(array('code'=>$code, 'message'=>$message, 'result'=>$result)));
    }
    function get($url){
        $s = file_get_contents($url);
        return $s;
    }
    
    $method = $_GET['method'];
    if(!$method){
        report(404, "缺少参数", array());
    }
    
    if($method == "getList"){
        // Q1 - 匿名/实名
        // Q2 - 真实姓名
        // Q3 - 昵称
        // Q4 - 稿件类型
        // Q5 - 文本
        // Q6 - 图片
        // Q7 - 音视频
        // 这里还留个锅：倒序显示还没做
        
        $page = $_GET['page'];
        if($page < 1) $page = 1; 
        
        $timestamp = time();
        $signature = md5($AppKey.$page.$formId.$timestamp.$AppSecret);
        
        $json = json_decode(get("https://open.wenjuan.com/openapi/v4/get_rspd_list?app_key=".$AppKey."&timestamp=".$timestamp."&page=".$page."&short_id=".$formId."&signature=".$signature), true);
        if($_GET['debug']) print_r($json);
        
        $res = array();
        
        $total = $json["data"]["total_count"];
        $cnt = $total - ($page - 1) * $json["data"]["page_size"];
        if($cnt < 0) $cnt = 0;
        if($cnt > $json["data"]["page_size"]) $cnt = $json["data"]["page_size"];
        
        $list = $json["data"]["rspd_list"];
        
        for($i = 0; $i < $cnt; $i++){
            // print_r($list[$i]);
            
            if($list[$i]["Q1"]["answer"] == '匿名'){
                $name = $list[$i]["Q3"]["answer"];
            }else{
                $name = $list[$i]["Q2"]["answer"];
            }
            if($list[$i]["Q6"]["answer"]) $image = explode("&&", $list[$i]["Q6"]["answer"]);
            else $image = [];
            if($list[$i]["Q7"]["answer"]) $video = explode("&&", $list[$i]["Q7"]["answer"]);
            else $video = [];
            array_push($res, array(
                'id' => $i + ($page - 1) * $json["data"]["page_size"] + 1,
                'name' => $name, 
                'time' => $list[$i]["finish"], 
                'ip' => $list[$i]["ip"], 
                'text' => $list[$i]["Q5"]["answer"],
                'image' => array('name' => $image[0], 'url' => $image[1]),
                'video' => array('name' => $video[0], 'url' => $video[1])
            ));

        }
        report(200, "success", array('total' => $total, 'size' => $json["data"]["page_size"], 'count' => $cnt,'list' => $res));
    }
?>