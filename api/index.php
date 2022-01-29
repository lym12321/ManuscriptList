<?php
    include "config.php";
    
    function report($code, $message, $result){
        die(json_encode(array('code'=>$code, 'message'=>$message, 'result'=>$result)));
    }
    function get($url){
        $s = file_get_contents($url);
        return $s;
    }
    function cut_str($str,$len,$suffix=" ... ... "){
        $strlen = strlen($str);
        if($strlen > $len){
            if(function_exists('mb_substr')){
                $str = mb_substr($str,0,$len/2,'utf-8').$suffix.mb_substr($str,-$len/2,$len/2,'utf-8');
                // die($str);
            }else{
                report(-1, "未支持 mb_substr 函数", array());
            }     
        } 
        return $str; 
    }
    
    $method = $_GET['method'];
    if(!$method){
        report(-1, "缺少参数", array());
    }

    if($method == "getNotice"){
        if(!$notice) report(404, "不存在公告", array());
        report(200, "success", array('notice' => $notice));
    }
    
    if($method == "getDetail"){
        // 跳转到答卷详情页面（由问卷网提供）
        $seq = $_GET['seq'];
        if(!$seq) report(-1, "缺少参数", array());
        if(!is_numeric($seq)) report(-1, "参数不合法", array());
        
        $url = "https://open.wenjuan.com/openapi/v4/get_rspd_url/";
        
        $timestamp = time();
        $signature = md5($AppKey.$seq.$formId.$timestamp.$AppSecret);
        $tmp = get($url."?app_key=".$AppKey."&timestamp=".$timestamp."&seq=".$seq."&short_id=".$formId."&signature=".$signature);
        
        if($_GET['debug'] == "true") die($tmp);
        
        $json = json_decode($tmp, true);
        header('location:'.$json["data"]["url"]);
    }
    
    if($method == "getList"){
        $url = "https://open.wenjuan.com/openapi/v4/get_rspd_list/";
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
        
        $tmp = get($url."?app_key=".$AppKey."&timestamp=".$timestamp."&page=".$page."&short_id=".$formId."&signature=".$signature);
        
        if($_GET['debug'] == "true") die($tmp);
        
        $json = json_decode($tmp, true);
        // if($_GET['debug']) print_r($json);
        
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
                'id' => $i + ($page - 1) * $json["data"]["page_size"] + 1, // 这是正序的 id ，注意！
                'name' => $name, 
                'time' => $list[$i]["finish"], 
                'ip' => $list[$i]["ip"], 
                'text' => cut_str($list[$i]["Q5"]["answer"], 200),
                'image' => array('name' => $image[0], 'url' => $image[1]),
                'video' => array('name' => $video[0], 'url' => $video[1])
            ));

        }
        report(200, "success", array('total' => $total, 'size' => $json["data"]["page_size"], 'count' => $cnt,'list' => $res));
    }
?>
