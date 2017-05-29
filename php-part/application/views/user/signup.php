<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="南开亿灵－登陆">
    <meta name="viewport"
        content="width=device-width, initial-scale=1">
  <title>南开亿灵－登陆</title>
  <link rel="stylesheet" type="text/css" href="/assets/css/amazeui.min.css">
  <link rel="stylesheet" type="text/css" href="/assets/css/animate.css">
  <link rel="stylesheet" type="text/css" href="/assets/css/login.css">
</head>
<body>

<div id="login-bg">
  <div class="login-container">
    <div class="login-icon">
      <a href="/"><img src="/assets/i/web_logo.png"></a>
    </div>

    <div class="login-body">
       <div data-am-widget="tabs" class="am-tabs am-tabs-login" data-am-tabs-noswipe="1">
            
            <ul class="am-tabs-nav am-cf">
                <li class="am-active to_login">
                  <a href="[data-tab-panel-0]">
                  <span>登陆</span>
                  </a>
                </li>
                <li class=" to_sign ">
                  <a href="[data-tab-panel-1]">
                    <span>注册</span>
                  </a>
                </li>
            </ul>
            <div class="am-tabs-bd">
                
                <!--登陆输入框组-->
                <div data-tab-panel-0 class="am-tab-panel am-active">
                  
                  <div class="login-input-box">
                    
                    <div class="login-input">
                      <input type="text" placeholder="请输入邮箱" id="login-username" maxlength="35" />  
                      <i class="am-icon-envelope am-icon-fw"></i>
                    </div>

                    <div class="login-input">
                      <input type="password" placeholder="请输入密码" id="login-password" maxlength="35"/> 
                      <i class="am-icon-lock am-icon-fw"></i>
                    </div>

                  </div>

                  <div class="check-btn">
                    <button id="login-btn">
                      登陆
                    </button>
                  </div>

                  <div class="login-info">
                    <a href="#" title="忘记密码?">忘记密码？</a>
                  </div>
                  <!--登陆输入框结束-->

                </div>
            
            <!--注册输入框组-->
                <div data-tab-panel-1 class="am-tab-panel ">
                  
                  <div class="login-input-box">
                    
                    <div class="login-input">
                      <input type="text" placeholder="请输入名字" id="sign-usernick" maxlength="35"/>  
                      <i class="am-icon-user am-icon-fw"></i>
                    </div>

              <div class="login-input">
                      <input type="text" placeholder="请输入邮箱" id="sign-username" maxlength="35"/>  
                      <i class="am-icon-envelope am-icon-fw"></i>
                    </div>

                    <div class="login-input">
                      <input type="password" placeholder="请输入密码" id="sign-password" maxlength="35"/>  
                      <i class="am-icon-lock am-icon-fw"></i>
                    </div>

                  </div>

                  <div class="check-btn ">
                    <button id="sign-btn">注册</button>
                  </div>

                  <div class="signup-info">
                    已有账号？<a href="#" id="click2login">点我登陆</a>
                  </div>
                  <!--注册输入框结束-->

                </div>

            </div>
        </div>
        <!--登陆注册的警告信息-->
        <div class="login-waring">
        </div>
    </div>
  </div>
</div>

  <script type="text/javascript" src="/assets/js/jquery.min.js"></script>
  <script type="text/javascript" src="/assets/js/md5.js"></script>
  <script type="text/javascript" src="/assets/js/amazeui.min.js"></script>
  <script type="text/javascript" src="/assets/js/particles.js"></script>
  <script type="text/javascript" src="/assets/js/login.js"></script>

  <script type="text/javascript">

$(document).ready(function(){
    //切换注册和登陆的监听
    $to_login = $(".to_login a"); 
    $to_sign = $(".to_sign a");

    //监听登陆注册的点击按钮
    $login_btn = $("#login-btn");
    $sign_btn = $("#sign-btn");

    //登陆警告
    $login_waring = $(".login-waring");

    //登陆的用户名和密码
    $login_username = $("#login-username");
    $login_password = $("#login-password");
    //注册的用户名和密码
    $sign_usernick = $("#sign-usernick");
    $sign_username = $("#sign-username");
    $sign_password = $("#sign-password");

    //错误定义
    const WHITE_SPACE_ERROR = -101;
    const EMAIL_FORMAT_ERROR = -102;
    const ILLEGAL_SYMBOL_ERROR = -103;
    const TOO_LONG_ERROR = -104;
    const SERVER_ERROR = -105;
    var waring_word = {};

    waring_word[WHITE_SPACE_ERROR] = "不能为空";
    waring_word[EMAIL_FORMAT_ERROR] = "邮箱格式错误";
    waring_word[ILLEGAL_SYMBOL_ERROR] = "非法的符号(只支持汉字,英文和下划线)";
    waring_word[TOO_LONG_ERROR] = "字符串太长了";
    waring_word[SERVER_ERROR] = "服务器发生错误，请刷新重试，或者联系管理员";

    //登陆监听开始
    $login_btn.click(function(e){
      login_fn(e,function(err,data){
        if(err){
          login_waring("错误代码:" + err.Flag  + "错误信息" + err.Content);
          return ;
        }else{
          login_waring("登陆成功，正在跳转");
          //登陆成功跳转
          setTimeout(function(){
            window.location.href = "/index.php";
          },1000);
        }
      });
    });

    $sign_btn.click(function(e){
      sign_fn(e,function(err,data){
        if(err){
          login_waring("错误代码:" + err.Flag + "错误信息" + err.Content);
          return ;
        }else{
          login_waring("注册成功，我们将会发一封验证邮件到你的邮箱，请注意查收");
        }
      });
    });

    $("#click2login").click(function(e){
      $to_login.click();
    });

    //监听回车事件
    $('.login-input-box').on('keydown','input',function(e){
        if(e.which == 13){
          var btn = $('.am-active').find('button')[0];
          $(btn).click();
        }
    });

    //----------------------------------------->登陆用函数
    var login_fn = function(e,cb){
        //检查输入框的字符串
        var username = $login_username.val().trim();
        var password = $login_password.val().trim();
        //检查

        if(username_check(username) < 0){
          login_waring("用户名" + waring_word[username_check(username)])
          return ;
        }

        if(password_check(password) < 0){
          login_waring("密码" + waring_word[username_check(username)])
          return ; 
        }

        //加载登陆动画
        var word = disableBtn(e).trim();

        //发送ajax请求
        $.ajax({
          url:'/index.php/api/user/Signin',
          type:'post',
          data:{
            Account:username,
            Password:password//hex_md5(password)
          },
          success:function(data){
            //简单处理信息
            try{
              data = JSON.parse(data);  
            }catch(e){
              login_waring(waring_word[SERVER_ERROR]);
              return;
            }
            //返回错误
            if(data.Flag < 0){
              return cb(data);
            }

            enableBtn(e,word);
            cb(null,data);
          },
          error:function(data){
            enableBtn(e,word);
            login_waring("服务器发生错误，请刷新重试，或者联系管理员");
          }
        });
    }

    //--------------------------------------------->注册用函数
    var sign_fn = function(e,cb){
      console.log(typeof $sign_username.val());
      var username = $sign_username.val().trim();
      var password = $sign_password.val().trim();
      var usernick = $sign_usernick.val().trim();

      if(username_check(username) < 0){
        login_waring("用户名" + waring_word[username_check(username)])
        return ;
      }

      if(password_check(password) < 0){
        login_waring("密码" + waring_word[password_check(username)])
        return ; 
      }

      if(usernick_check(usernick) < 0){
        login_waring("昵称" + waring_word[usernick_check(usernick)]);
        return ;
      }

      //字符串检测
      var word = disableBtn(e).trim();
      $.ajax({
        url:'/index.php/api/user/signup',
        type:'post',
        data:{
          Account:username,
          Password:password,//hex_md5(password)
          Usernick:usernick
        },
        success:function(data){
          //简单处理信息
          try{
            data = JSON.parse(data);  
          }catch(e){
            login_waring(waring_word[SERVER_ERROR]);
            return;
          }
          //返回错误
          if(data.Flag < 0){
            return cb(data);
          }

          cb(null,data);
          enableBtn(e,word);
        },
        error:function(data){
          cb(data);
          enableBtn(e,word);
          login_waring(waring_word[SERVER_ERROR])
        }
      });
    } 

    //警告函数
    var login_waring = function(str){
      $login_waring.text(str);
    }


    var loading = '<i class="am-icon-spinner am-icon-pulse"></i>';
    //加载登陆动画
    function disableBtn(e){
      var $elem = $(e.currentTarget);
      var word = $elem.text();
      //设置不能够再点击
      $elem.attr({"disabled":"true"});
      $elem.html(loading);

      return word;
    }

    //恢复按钮
    function enableBtn(e,word){
      var $elem = $(e.currentTarget);
      //设置不能够再点击
      $elem.removeAttr("disabled");
      $elem.html(word);
    }

    //用户名校验
    //必须是邮箱
    function username_check(username){
      //用户名为空
      
      if(username.trim().length == 0){
        return WHITE_SPACE_ERROR;
      }

      var reg_email = /[a-zA-Z0-9_]+@[a-zA-Z0-9_]+/;
      //邮箱格式错误
      if(!reg_email.test(username)){
        return EMAIL_FORMAT_ERROR;
      }

      //正确
      return 100;
    }

    //密码校验
    function password_check(password){
      //密码为空
      if(password.trim().length == 0){
        return WHITE_SPACE_ERROR;
      }
      //正确
      return 100; 
    }

    //用户昵称校验
    function usernick_check(usernick){
      if(usernick.trim().length == 0){
        return WHITE_SPACE_ERROR;
      }

      //不能含有非法字符
      var reg_usernick = /[a-zA-Z0-9_\u4e00-\u9fa5]+/
      if(!reg_usernick.test(usernick.trim())){
        return ILLEGAL_SYMBOL_ERROR;
      }

      return 100;
    }
});

  </script>
</body>
</html>