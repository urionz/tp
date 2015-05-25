//样式索引
var Index=0;
var ScrollIndex=0;
    //模糊查询
    $(document).ready(function(){
        
        //键盘监听
        $(document).keydown(function(event){
            
            if($('#output').children().children().size()>0){

                //方向键上监听
                if(event.keyCode==38){

                    $('#output').children().children().eq(Index--).removeClass('hovered');


                    if(Index<0){

                        Index=$('#output').children().children().size()-1;

                        //当前Index为索引为负值时,将scrollTop归位最大值
                        $('#output').scrollTop(25*$(output).children().children().size());

                        $('#output').children().children().eq(Index).addClass('hovered');

                    }else{
                        
                        $('#output').children().children().eq(Index).addClass('hovered');
                        
                        $('#output').scrollTop($('#output').scrollTop()-25);

                    }


                }
                //向键下监听
                if(event.keyCode==40){

                    $('#output').children().children().eq(Index++).removeClass('hovered');

                    //算法一，移动到最底端整体翻页
                    //下移判断每移动五条记录计算一次scrollTop的位置
                    //每次计算为当前div高度减去5个单位再乘当前索引除5的倍数
                    // if((Index%5)==0){

                    //     $('#output').scrollTop(($('#output').height()-5)*(Index/5));

                    // }
                    


                    //算法二，移动到底端翻页一个li的高度
                    if(Index>4){

                        $('#output').scrollTop($('#output').scrollTop()+25);

                    }

                    //当scrollTop下移到Index的索引值为li的数量时归零scrollTop
                    if(Index==$(output).children().children().size()){

                        $('#output').scrollTop(0);

                    }

                    if(Index>$('#output').children().children().size()-1){

                        Index=0;

                        $('#output').children().children().eq(Index).addClass('hovered');

                    }else{

                        $('#output').children().children().eq(Index).addClass('hovered');

                    }
                }

                //回车监听
                if(event.keyCode==13){

                    $('input[name="target"]').val($('#output').children().children().eq(Index).text());

                    $('#output').remove();

                    return false;
                }

                //ESC监听
                if(event.keyCode==27){

                    $('#output').remove();
                    
                }

            }
            
        })
        
});

    

    //监听输入栏
    function Listener(v){
        var _html="";
            //重置索引
            Index=0;
        var selected=$('#search').val();
        

        //每次换值前清除之前记录
        $('#output').remove();

        
        //空值销毁选项容器
        if($('input[name="target"]').val()=='')
            
            $('#output').remove();
        
        else{

                //注册选项容器
                $('input[name="target"]').after('<div id="output"></div>');

                //按合同查找
                if(selected==1){
        
                        $.post(searchUrl,{keywords:v,method:selected},function(data){
        
                        data=eval("("+data+")");
        
                        _html+="<ul class='am-nav'>";
        
                        $.each(data,function(element){
                                
                                    _html+="<li class='am-nav-item hover' onclick=getVal('"+data[element]['agree_num']+"')>"+data[element]['agree_num']+"</li>";
        
                        });
        
                        _html+="</ul>";
        
                        $('#output').append(_html);

                        //默认首个被选中
                        $('#output').children().children().eq(Index).addClass('hovered');


                        //监听鼠标修改样式
                        $('li.am-nav-item').each(function(){

                            $(this).mouseover(function(){

                                $('#output').children().children().eq($(this).index()).removeClass('hovered');

                            });
                        });

                    });
                }

                //按姓名查找
                if(selected==2){
                        
                        $.post(searchUrl,{keywords:v,method:selected},function(data){
                        
                        data=eval("("+data+")");
                        
                        _html+="<ul class='am-nav'>";

                        $.each(data,function(element){
                                
                                    _html+="<li class='am-nav-item hover' onclick=getVal('"+data[element]['cname']+"')>"+data[element]['cname']+"</li>";
                                
                        });
                        _html+="</ul>";

                        $('#output').append(_html);

                        $('#output').children().children().eq(Index).addClass('hovered');

                        //监听鼠标修改样式
                        $('li.am-nav-item').each(function(){
                            
                            $(this).mouseover(function(){
                                
                                $('#output').children().children().eq($(this).index()).removeClass('hovered');
                            
                            });

                        });

                    });
                }


        }

        

    }

    //点击取值
    function getVal(element){
        $('input[name="target"]').val(element);
        $('#output').remove();
    }