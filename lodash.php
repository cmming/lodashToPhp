<?php

// 数组类
class Arrays{
    // 求平均值 (非数字自动跳过)
    public static function average($arr){
        $result = 0;
        $count = count($arr);
        if($count){
            foreach($arr as $val){
                is_numeric($val)&&($result+=$val);
            }
            $result = $result/$count;
        }
        return $result;
    }

    // value 是否包含
    public static function container($str,$arr,$is_check_type = false){
        return in_array($str,$arr,$is_check_type);
    }

    // key 值检验
    public static function has($str,$arr){
        return array_key_exists($str,$arr);
    }

    // matches 所有项目匹配的真理测试
    // call_user_func_array和call_user_func 的区别 就是 前者传参数 使用数组 后者使用普通的形式
    public static function matches($arr,callable $func){
        $reault = true;
        foreach($arr as $val){
            $reault = call_user_func($func,$val);
            if(!$reault){return $reault;}
        }
        return $reault;
    }
    // 至少一个项目相匹配返回true
    public static function matchesAny($arr,callable $func){
        $reault = false;
        foreach($arr as $val){
            $reault = call_user_func($func,$val);
            if($reault){return $reault;}
        }
        return $reault;
    }
    // 数组求和
    public static function sum($arr){
        $sum = 0 ;
        foreach($arr as $val){
            is_numeric($val)&&($sum+=$val);
        }
        return $sum;
    }
    // 最大
    public static function max($arr){
        return array_search(max($arr),$arr);
    }
    // 最小
    public static function min($arr){
        return array_search(min($arr),$arr);
    }
    // 数组的深度计算
    public static function arrayDepth($array) {
        if(!is_array($array)) return 0;
        $max_depth = 1;
        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = self::arrayDepth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }
        return $max_depth;
    }

    // 获取一个数组 n维度的 key 值
    public static function arrayKeys($arr,$deep){
        $keys_arr = array();
        $arr_deep = self::arrayDepth($arr);
        $now_depth = 1;
        foreach($arr as $key=>$value){
            if(is_array($value)){
                if($deep>$now_depth){
                    $now_depth+=1;
                    var_dump($value);exit();
                    self::arrayKeys($value,$deep-1);
                }else{
                    // 进入数组  深度 为 $deep 的位置 
                    var_dump($arr);exit();
                    if(!in_array($key,$keys_arr)){
                        $keys_arr[] = $key;
                    }
                }
            }
        }
        return $keys_arr;
        // var_dump($arr_deep,$deep);

    }

    // 将 自数组中 key 相等的进行合并
    public static function union_by_key($arr){
        // 创建 临时变量存储 key 
        $son_keys = array();
        
        foreach($arr as $key=>$val){
            if(!empty($val)){
                foreach($val as $k=>$v){
                    if(!in_array($k,$son_keys)){
                        // 存储key
                        $son_keys[] = $k;
                        // 
                    }
                }
            }
        }
        // 存储合并后的结果
        // var_dump($son_keys);exit();
        $res_arr = array();
        foreach($arr as $key=>$val){
            if(!empty($val)){
                foreach($val as $k=>$v){
                    if(in_array($k,$son_keys)){
                        $res_arr[$k] = isset($res_arr[$k])?array_merge($res_arr[$k],$v):$v;
                    }
                }
            }
        }
         var_dump($res_arr);exit();
    }

    
}


// echo Arrays::average(array('d','s'))."<br/>";
$result = Arrays::matches(array('1','3'),function($val){
    return $val==1;
});

var_dump($result);
$result1 = Arrays::matchesAny(array('1','3'),function($val){
    return $val==1;
});

var_dump($result1);

$result2 = Arrays::sum(array('1','3'));

var_dump($result2);

$result3 = Arrays::max(array('1','3'));

var_dump($result3);


$test_arr = array(
    array(
        '102'=>array('a'=>1),
        '106'=>array('b'=>2)
    ),
    array(
        '102'=>array('c'=>1),
        '106'=>array('d'=>2)
    ),
    array(
        '102'=>array('e'=>1),
        '106'=>array('f'=>2)
    ),

    );


var_dump(Arrays::arrayDepth(array($test_arr)));
Arrays::union_by_key($test_arr);
// echo Arrays::sum(array('1','4'))."<br/>";

?>