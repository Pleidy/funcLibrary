<?php

/**
 * @todo 判断传入数据是否在数据库中已经存在
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