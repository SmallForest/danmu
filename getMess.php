<?php
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    
    $mysql_server_name='192.168.7.6'; //改成自己的mysql数据库服务器
 
    $mysql_username='root'; //改成自己的mysql数据库用户名
     
    $mysql_password='root'; //改成自己的mysql数据库密码
     
    $mysql_database='2015_09_fangchanjn'; //改成自己的mysql数据库名

    $conn = mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
 
    mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.
     
    mysql_select_db($mysql_database); //打开数据库
    $sql = 'select * from danmu where addtime >= '.(getMillisecond()-1000).'  and sender !='.$_GET['id'];
    $i = 0;
    do{
        // 查询结果为空，继续查询 3毫秒
        // $i != 0 ? usleep(10*1000) : $i++;        
        $result = mysql_query($sql);
        $num_rows = mysql_num_rows($result);
    }while($num_rows == 0);    
    
    while ($row = mysql_fetch_array($result , MYSQL_ASSOC)) {
       $res[] = $row;
    }
    if(is_null($res)){
        exit;
    }
    $json = json_encode($res);

    echo "data: {$json} \n\n";
    flush();
    mysql_close();

    function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
    }
    

   
