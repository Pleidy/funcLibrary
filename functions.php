<?php

/**
 * @todo 判断传入数据是否在数据库中已经存 在
 * @author Pleid
 * @time 2019-7-27
 * @param $judgeData  传入数据
 * @param $table 需要判断的数据表
 * @param $field 判断的数据字段
 * @RETURN 返回不存在的数据
 */
public function getDataExist($judgeData,$table,$field){

    $judgeFields = ArrayHelper::getColumn($judgeData,$field);

    $existData = Db::name($table)
        ->where([
            $field =>  ['in',$judgeFields],
        ])
        ->field($field)
        ->select();

    $refreshData = [];//需要更新的数据容器
    foreach ($judgeData as $value) {
        if(!in_array($value[$field], array_column($existData, $field))){
            $refreshData[] = $value;
        }
    }

    return $refreshData;
}


/**
 * 数据库SQL原生查询
 * @param $sql 原生查询语句
 * @return $data 查询数据
 * @Time   2019.4.4
 * @AUTH   Pleid
 */
function sqlQuery($sql)
{
    $con = mysqli_connect("127.0.0.1", "root", "*******", "数据库名");
    $con->query("SET NAMES UTF8");

    if (!$con) die("连接失败: " . $con->connect_error);

    $result = mysqli_query($con, $sql);

    if (!$result) {
        printf("Error: %s\n", mysqli_error($con));//打印报错信息
        return false;
    }

    if ($result === true || $result === false) {
        return $result;
    }

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
}


/**
 * 错误信息日志文件
 * @param $data 存入数据
 * @Time 2019.4.4
 * @AUTH Pleid
 */
function logTxt($data)
{
    $years    = date('Y-m');
    $dir_name = dirname(__DIR__) . '/email/log/' . $years;
    if (!file_exists($dir_name)) {
        //iconv防止中文名乱码
        mkdir(iconv("UTF-8", "GBK", $dir_name), 0777, true);
    }
    $fp = fopen($dir_name . '/' . date('Ymd') . '_request_log.log', 'a');
    fwrite($fp, $data . "\r\n");//写入文件
    fclose($fp);//关闭资源通道
}