/**
 * 2019/8/17
 * */
$('.demoTable .layui-btn').on('click', function(){
    var type = 'b';
    test[type] ? test[type].call(this) : '';
});
var test = {
    a:function(){
        console.log('a');
    },
    b:function(){
        console.log('b');
    }
};