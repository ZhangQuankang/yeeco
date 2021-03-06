<?php
error_reporting(E_ALL & ~E_NOTICE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>注册</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<meta name="Keywords" content="易可社团,易可平台,易可高校社团,中国高校社团,高校社团管理平台,社团管理系统,线上社团,学生社团">
<meta name="Description" content="易可社团，作为一款适应于中国国内高校社团的线上管理系统，创建线上管理与线下活动相结合的新模式；构建围绕社团活动开展的网络社区，吸引高校生长期活跃的互联网社区。">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/register.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="res_package/school.css"/>
</head>
 
<body> 
<div class="top_back">
  <div class="top">
      <ul>
        <li class="a">注&nbsp;册</li>
        <li class="b">已有账号？马上&nbsp;<a href="../index.php">登录</a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>

<div style="height:20px;"></div>
 
<form name="registerForm" id="registerForm" action="../background/background_person/form_register.php" method="post"><!--指向后台的登录模块.php-->
  <div class="register_box"> 
      <div class="page">
        <ul>  
          <li>
            <div class="icon icon_1"></div>
            <input type="text" id="usertel" name="usertel" class="text-input" onfocus="register_text_in(this)" onkeydown="disappear('span_1');disappear('otel');" onblur="register_text_out(this);checking_1(this)" placeholder="您的手机号码"/>
          </li>
          <span id="otel" style="display:none"></span>
          <span id="span_1" style="display:none">请输入合法的手机号码!</span>
          <li>
            <div class="icon icon_2"></div>
            <input type="password" id="password1" name="password1" class="text-input" onfocus="register_text_in(this)" onkeydown="disappear('span_2');" onblur="register_text_out(this);checking_2(this)" placeholder="设置密码"/>
          </li>
          <span id="span_2" style="display:none">密码长度至少6位！</span>
          <li>
            <div class="icon icon_3"></div>
            <input type="password" id="password2" name="password2" class="text-input" onfocus="register_text_in(this)" onkeydown="disappear('span_3');" onblur="register_text_out(this);checking_3(this)" placeholder="确认密码"/>
          </li>
          <span id="span_3" style="display:none">两次密码不一致！</span>
        </ul>
        <div style="clear:both;"></div>
      </div>
      <div class="page">  
        <ul>  
          <li>
            <div class="icon icon_4"></div>
            <input type="text" id="realname" name="realname" class="text-input" onfocus="register_text_in(this)" onblur="register_text_out(this)" onkeydown="disappear('span_4');" placeholder="您的真实姓名"/>
          </li>
          <span id="span_4" style="display:none">请输入您的真实姓名！</span>
          <li>
            <div class="icon icon_5"></div>
            <input type="text" id="school" name="school" class="text-input" onclick="chooseSchool();disappear('span_5');" readonly="readonly" placeholder="您所在的学校"/>

          </li>
          <span id="span_5" style="display:none">请选择您所在的学校！</span>
        </ul>
      </div>
      <div class="page_3"> 
        <ul> 
          <li>
            <label class="checkbox"><input type="checkbox" id="server" checked disabled>我同意<a href="service_agreement.html" target="_blank">《易可服务协议》</a></label>
          </li>
          <li>
            <input type="button" onclick="toTest()" class="register" value="注册" >
          </li>
        </ul>
        <div style="clear:both;"></div>
      </div>
  </div>

<div class="test" style="display:none;" >
    <div style="height:80px;"></div>
    <div class="left_pic"></div>
    <div class="right_test">
        <ul> 
          <li>
              <p>欢迎您加入易可社团的大家庭！！！</p>
              <p>验证码已发送至手机&nbsp;：<span id="target_number"></span></p>
          </li>
          <li>
              <p>若<strong class="time">60</strong>秒后您还未收到，请点击<a id="resend" class="gray">重新发送</a></p>
          </li>
          <li>
            <input type="text" id="test" placeholder="输入验证码继续完成注册" onfocus="outline_new(this)" onblur="outline_old(this)"/>
          </li>
          <li>
            <input type="button" onclick="toRegister()" class="register" value="返回" onclick=""/>
            <input type="button" class="register" onclick="verify_Code()" value="提交" />
          </li>
        </ul>    
    </div>
    <div style="clear:both;"></div>
</div>
</form>


<!--弹出选择学校对话框-->
<div class="school" id="school_box" style="display:none;">
    <div class="shead">
    	<strong>选择学校:</strong>
    	<div class="ui-select" data-level="1">
          <div class="ui-select-dock">
               <div class="ui-select-selected">北京</div>
               <div class="ui-icon-triangleb"></div>
          </div>    
          <div class="ui-select-options" style="display:none;">
            <ul id="ui-id-48" class="ui-menu" role="menu" tabindex="0" aria-activedescendant="ui-id-50" style="position:absolute;top:2px;">       
                <li data-value="1" class="ui-select-optionselected ui-menu-item" id="ui-id-49" tabindex="-1" role="menuitem">北京</li>        
                <li data-value="2" class="ui-menu-item" id="ui-id-50" tabindex="-1" role="menuitem">上海</li>
                <li data-value="3" class="ui-menu-item" id="ui-id-51" tabindex="-1" role="menuitem">黑龙江</li>
                <li data-value="4" class="ui-menu-item" id="ui-id-52" tabindex="-1" role="menuitem">吉林</li>
                <li data-value="5" class="ui-menu-item" id="ui-id-53" tabindex="-1" role="menuitem">辽宁</li>
                <li data-value="6" class="ui-menu-item" id="ui-id-54" tabindex="-1" role="menuitem">天津</li>
                <li data-value="7" class="ui-menu-item" id="ui-id-55" tabindex="-1" role="menuitem">安徽</li>
                <li data-value="8" class="ui-menu-item" id="ui-id-56" tabindex="-1" role="menuitem">江苏</li>
                <li data-value="9" class="ui-menu-item" id="ui-id-57" tabindex="-1" role="menuitem">浙江</li>
                <li data-value="10" class="ui-menu-item" id="ui-id-58" tabindex="-1" role="menuitem">陕西</li>
                <li data-value="11" class="ui-menu-item" id="ui-id-59" tabindex="-1" role="menuitem">湖北</li>
                <li data-value="12" class="ui-menu-item" id="ui-id-60" tabindex="-1" role="menuitem">广东</li>
                <li data-value="13" class="ui-menu-item" id="ui-id-61" tabindex="-1" role="menuitem">湖南</li>
                <li data-value="14" class="ui-menu-item" id="ui-id-62" tabindex="-1" role="menuitem">甘肃</li>
                <li data-value="15" class="ui-menu-item" id="ui-id-63" tabindex="-1" role="menuitem">四川</li>
                <li data-value="16" class="ui-menu-item" id="ui-id-64" tabindex="-1" role="menuitem">山东</li>
                <li data-value="17" class="ui-menu-item" id="ui-id-65" tabindex="-1" role="menuitem">福建</li>
                <li data-value="18" class="ui-menu-item" id="ui-id-66" tabindex="-1" role="menuitem">河南</li>
                <li data-value="19" class="ui-menu-item" id="ui-id-67" tabindex="-1" role="menuitem">重庆</li>
                <li data-value="20" class="ui-menu-item" id="ui-id-68" tabindex="-1" role="menuitem">云南</li>
                <li data-value="21" class="ui-menu-item" id="ui-id-69" tabindex="-1" role="menuitem">河北</li>
                <li data-value="22" class="ui-menu-item" id="ui-id-70" tabindex="-1" role="menuitem">江西</li>
                <li data-value="23" class="ui-menu-item" id="ui-id-71" tabindex="-1" role="menuitem">山西</li>
                <li data-value="24" class="ui-menu-item" id="ui-id-72" tabindex="-1" role="menuitem">贵州</li>
                <li data-value="25" class="ui-menu-item" id="ui-id-73" tabindex="-1" role="menuitem">广西</li>
                <li data-value="26" class="ui-menu-item" id="ui-id-74" tabindex="-1" role="menuitem">内蒙古</li>
                <li data-value="27" class="ui-menu-item" id="ui-id-75" tabindex="-1" role="menuitem">宁夏</li>
                <li data-value="28" class="ui-menu-item" id="ui-id-76" tabindex="-1" role="menuitem">青海</li>
                <li data-value="29" class="ui-menu-item" id="ui-id-77" tabindex="-1" role="menuitem">新疆</li>
                <li data-value="30" class="ui-menu-item" id="ui-id-78" tabindex="-1" role="menuitem">海南</li>
                <li data-value="31" class="ui-menu-item" id="ui-id-79" tabindex="-1" role="menuitem">西藏</li>
                <li data-value="32" class="ui-menu-item" id="ui-id-80" tabindex="-1" role="menuitem">香港</li>
                <li data-value="33" class="ui-menu-item" id="ui-id-81" tabindex="-1" role="menuitem">澳门</li>
                <li data-value="34" class="ui-menu-item" id="ui-id-82" tabindex="-1" role="menuitem">台湾</li>
            </ul>
            <div class="ui-scrollbar-bar" style="top:0;"></div>
          </div>
        </div>
        <a href="javascript:closeChoose();">&times;</a>
         <div style="clear:both;"></div>
    </div>
    <div class="school_list" id="school_list">
        <ul style="position:absolute;top:0;"><li><a href="#" data-value="1001">清华大学</a></li><li><a href="#" data-value="1002">北京大学</a></li><li><a href="#" data-value="1003">中国人民大学</a></li><li><a href="#" data-value="1004">北京航空航天大学</a></li><li><a href="#" data-value="1005">北京邮电大学</a></li><li><a href="#" data-value="1006">北京师范大学</a></li><li><a href="#" data-value="1007">中国传媒大学</a></li><li><a href="#" data-value="1008">北京语言大学</a></li><li><a href="#" data-value="1009">北京科技大学</a></li><li><a href="#" data-value="1010">中国农业大学</a></li><li><a href="#" data-value="1011">北京理工大学</a></li><li><a href="#" data-value="1012">北京林业大学</a></li><li><a href="#" data-value="1013">北京交通大学</a></li><li><a href="#" data-value="1014">中国矿业大学（北京）</a></li><li><a href="#" data-value="1015">北京信息科技大学</a></li><li><a href="#" data-value="1016">北京工业大学</a></li><li><a href="#" data-value="1017">北京化工大学</a></li><li><a href="#" data-value="1018">中国政法大学</a></li><li><a href="#" data-value="1019">对外经贸大学</a></li><li><a href="#" data-value="1020">中央民族大学</a></li><li><a href="#" data-value="1021">中国地质大学（北京）</a></li><li><a href="#" data-value="1022">中国科学院大学</a></li><li><a href="#" data-value="1023">北京中医药大学</a></li><li><a href="#" data-value="1024">首都经济贸易大学</a></li><li><a href="#" data-value="1025">中央财经大学</a></li><li><a href="#" data-value="1026">北方工业大学</a></li><li><a href="#" data-value="1027">中国石油大学（北京）</a></li><li><a href="#" data-value="1028">外交学院</a></li><li><a href="#" data-value="1029">首都师范大学</a></li><li><a href="#" data-value="1030">中央戏剧学院</a></li><li><a href="#" data-value="1031">中国青年政治学院</a></li><li><a href="#" data-value="1032">北京外国语大学</a></li><li><a href="#" data-value="1033">华北电力大学（北京）</a></li><li><a href="#" data-value="1034">中国人民公安大学</a></li><li><a href="#" data-value="1035">北京协和医学院</a></li><li><a href="#" data-value="1036">北京体育大学</a></li><li><a href="#" data-value="1037">北京工商大学</a></li><li><a href="#" data-value="1038">北京联合大学</a></li><li><a href="#" data-value="1039">首都医科大学</a></li><li><a href="#" data-value="1040">国际关系学院</a></li><li><a href="#" data-value="1041">中央美术学院</a></li><li><a href="#" data-value="1042">北京电子科技学院</a></li><li><a href="#" data-value="1043">中国劳动关系学院</a></li><li><a href="#" data-value="1044">中华女子学院</a></li><li><a href="#" data-value="1045">北京建筑大学</a></li><li><a href="#" data-value="1046">北京印刷学院</a></li><li><a href="#" data-value="1047">北京石油化工学院</a></li><li><a href="#" data-value="1048">首钢工学院</a></li><li><a href="#" data-value="1049">北京农学院</a></li><li><a href="#" data-value="1050">首都体育学院</a></li><li><a href="#" data-value="1051">北京第二外国语学院</a></li><li><a href="#" data-value="1052">北京物资学院</a></li><li><a href="#" data-value="1053">北京警察学院</a></li><li><a href="#" data-value="1054">中央音乐学院</a></li><li><a href="#" data-value="1055">中国戏曲学院</a></li><li><a href="#" data-value="1056">北京舞蹈学院</a></li><li><a href="#" data-value="1057">北京城市学院</a></li><li><a href="#" data-value="1058">北京电影学院</a></li><li><a href="#" data-value="1059">北京服装学院</a></li><li><a href="#" data-value="1060">青岛教育学院</a></li><li><a href="#" data-value="1061">北京体育职业学院</a></li><li><a href="#" data-value="1062">中国人民解放军装甲兵工程学院</a></li><li><a href="#" data-value="1067">中国石油勘探开发研究院</a></li><li><a href="#" data-value="1068">北京生命科学研究所</a></li><li><a href="#" data-value="1069">中国电影资料馆</a></li><li><a href="#" data-value="1070">北京工商大学嘉华学院</a></li><li><a href="#" data-value="1071">首都师范大学科德学院</a></li><li><a href="#" data-value="1072">北京工业大学耿丹学院</a></li><li><a href="#" data-value="1074">北京联合大学广告学院</a></li><li><a href="#" data-value="1075">北京邮电大学世纪学院</a></li><li><a href="#" data-value="1076">北京国际商务学院</a></li><li><a href="#" data-value="1078">中国林业科学研究院</a></li><li><a href="#" data-value="1079">北京航空材料研究院</a></li><li><a href="#" data-value="1080">北京京海研修学院</a></li><li><a href="#" data-value="1081">北京高等电力专科学校</a></li><li><a href="#" data-value="1082">中国空间技术研究院</a></li><li><a href="#" data-value="1083">北京企业管理研修学院 </a></li><li><a href="#" data-value="1084">现代软件学院</a></li><li><a href="#" data-value="1085">国家检察官学院</a></li><li><a href="#" data-value="1086">中国中医科学院</a></li><li><a href="#" data-value="1087">北京国家会计学院</a></li><li><a href="#" data-value="1088">北京华夏管理学院</a></li><li><a href="#" data-value="1089">中日友好临床医学研究所</a></li><li><a href="#" data-value="1090">北京京城学院</a></li><li><a href="#" data-value="1091">长江商学院</a></li><li><a href="#" data-value="1092">中国水利水电科学研究院</a></li><li><a href="#" data-value="1093">中国国际经济学院</a></li><li><a href="#" data-value="1094">北京卫生职业学院</a></li><li><a href="#" data-value="1095">北京市农工商联合总公司职工大学</a></li><li><a href="#" data-value="1096">北京艺术传媒职业学院 </a></li><li><a href="#" data-value="1097">公安部管理干部学院</a></li><li><a href="#" data-value="1098">华北电业联合职工大学</a></li><li><a href="#" data-value="1099">民航管理干部学院</a></li><li><a href="#" data-value="1100">中国记协职工新闻学院</a></li><li><a href="#" data-value="1101">北京大学医学部</a></li><li><a href="#" data-value="1102">北京政法职业学院</a></li><li><a href="#" data-value="1103">北京信息职业技术学院</a></li><li><a href="#" data-value="1104">北京现代职业技术学院</a></li><li><a href="#" data-value="1105">北京现代音乐研修学院</a></li><li><a href="#" data-value="1106">北京戏曲艺术职业学院</a></li><li><a href="#" data-value="1107">北京锡华国际经贸职业学院</a></li><li><a href="#" data-value="1108">北京盛基艺术学校</a></li><li><a href="#" data-value="1109">北京培黎职业学院</a></li><li><a href="#" data-value="1110">北京农业职业学院</a></li><li><a href="#" data-value="1111">北京科技职业学院</a></li><li><a href="#" data-value="1112">北京科技经营管理学院</a></li><li><a href="#" data-value="1113">北京经贸职业学院</a></li><li><a href="#" data-value="1114">北京经济技术职业学院</a></li><li><a href="#" data-value="1115">北京京北职业技术学院</a></li><li><a href="#" data-value="1116">北京交通职业技术学院</a></li><li><a href="#" data-value="1117">北京吉利大学</a></li><li><a href="#" data-value="1118">北京汇佳职业学院</a></li><li><a href="#" data-value="1119">北京工业职业技术学院</a></li><li><a href="#" data-value="1120">北京工商管理专修学院</a></li><li><a href="#" data-value="1121">北京电子科技职业学院</a></li><li><a href="#" data-value="1122">北京财贸职业学院</a></li><li><a href="#" data-value="1123">北京北大方正软件技术学院</a></li><li><a href="#" data-value="1124">北大资源美术学院</a></li><li><a href="#" data-value="1125">北京人文大学</a></li><li><a href="#" data-value="1126">北京高等秘书学院</a></li><li><a href="#" data-value="1127">北京应用技术大学</a></li><li><a href="#" data-value="1128">中国防卫科技学院</a></li><li><a href="#" data-value="1129">中国音乐学院</a></li><li><a href="#" data-value="1130">中国信息大学</a></li><li><a href="#" data-value="1131">北京青年政治学院</a></li><li><a href="#" data-value="1132">北京财经专修学院</a></li><li><a href="#" data-value="1133">北京经济管理职业学院</a></li><li><a href="#" data-value="1134">北京美国英语语言学院</a></li><li><a href="#" data-value="1135">中国管理软件学院</a></li><li><a href="#" data-value="1136">财政部财政科学研究所</a></li><li><a href="#" data-value="1137">北大资源学院</a></li><li><a href="#" data-value="1138">现代管理大学</a></li><li><a href="#" data-value="1139">北京民族大学</a></li><li><a href="#" data-value="1140">北京市劳动保障职业学院</a></li><li><a href="#" data-value="1141">北京市建设职工大学</a></li><li><a href="#" data-value="1142">北京市房地产职工大学</a></li><li><a href="#" data-value="1143">北京市汽车工业总公司职工大学</a></li><li><a href="#" data-value="1144">北京市西城经济科学大学</a></li><li><a href="#" data-value="1145">北京市丰台区职工大学</a></li><li><a href="#" data-value="1146">北京广播电视大学</a></li><li><a href="#" data-value="1147">北京教育学院</a></li><li><a href="#" data-value="1148">北京市东城区职工业余大学</a></li><li><a href="#" data-value="1149">北京市总工会职工大学</a></li><li><a href="#" data-value="1150">北京市海淀区职工大学</a></li><li><a href="#" data-value="1151">北京市崇文区职工大学</a></li><li><a href="#" data-value="1152">北京宣武红旗业余大学</a></li><li><a href="#" data-value="1153">北京市石景山区业余大学</a></li><li><a href="#" data-value="1154">北京市朝阳区职工大学</a></li><li><a href="#" data-value="1155">北京市机械工业局职工大学</a></li><li><a href="#" data-value="1156">北京医药集团职工大学</a></li><li><a href="#" data-value="1157">北京劳动保障职业学院</a></li><li><a href="#" data-value="1158">北京社会管理职业学院</a></li><li><a href="#" data-value="1159">中南海业余大学</a></li><li><a href="#" data-value="1160">北京演艺专修学院</a></li><li><a href="#" data-value="1161">北京兴华大学</a></li><li><a href="#" data-value="1162">北京新园明职业学院</a></li><li><a href="#" data-value="1163">中央党校研究生院</a></li><li><a href="#" data-value="1164">中国社科院</a></li><li><a href="#" data-value="1165">北京旅游专修学院</a></li><li><a href="#" data-value="1166">东方文化艺术学院</a></li><li><a href="#" data-value="1167">首都联合职工大学</a></li><li><a href="#" data-value="1168">中国农业科学院</a></li><li><a href="#" data-value="1169">北京影视研修学院</a></li><li><a href="#" data-value="1170">国家法官学院</a></li><li><a href="#" data-value="1171">北京建设大学</a></li><li><a href="#" data-value="1172">北京金融学院</a></li><li><a href="#" data-value="1173">北京黄埔大学</a></li><li><a href="#" data-value="1174">中瑞酒店管理学院</a></li><li><a href="#" data-value="1175">中国建筑设计研究院</a></li><li><a href="#" data-value="1176">北京文理研修学院</a></li><li><a href="#" data-value="1177">北京当代艺术学院</a></li><li><a href="#" data-value="1178">北京大学国际法学院</a></li><li><a href="#" data-value="1179">北京交通运输职业学院</a></li><li><a href="#" data-value="1180">中国艺术研究院</a></li><li><a href="#" data-value="1181">北京工业大学通州分校</a></li><li><a href="#" data-value="1182">北京八维研修学院</a></li><li><a href="#" data-value="1183">中央党校继续教育学院</a></li><li><a href="#" data-value="1184">中央广播电视大学</a></li><li><a href="#" data-value="1185">门头沟区委党校</a></li><li><a href="#" data-value="1186">电信科学技术研究院</a></li><li><a href="#" data-value="1187">首都经济贸易大学密云分校 </a></li><li><a href="#" data-value="1188">北京有色金属研究总院研究生部</a></li><li><a href="#" data-value="1189">国家行政学院</a></li><li><a href="#" data-value="1191">北京交通管理干部学院</a></li><li><a href="#" data-value="1192">中共北京市委党校（北京行政学院）</a></li><li><a href="#" data-value="1193">中国疾病预防控制中心</a></li><li><a href="#" data-value="1194">中国舰船研究院</a></li><li><a href="#" data-value="1195">空军指挥学院</a></li><li><a href="#" data-value="1196">北京大学国家发展研究院</a></li><li><a href="#" data-value="1197">解放军医学院</a></li><li><a href="#" data-value="1199">中国社会科学院研究生院</a></li><li><a href="#" data-value="1202">中国铁道科学研究院 </a></li><li><a href="#" data-value="1999">朝阳二外</a></li><li><a href="#" data-value="2000">中北国际演艺学校</a></li></ul>
        <div class="ui-scrollbar-bar_2" style="top:0;"></div>
    </div>
</div>

<script src="js/jquery-1.11.1.js"></script>
<script src="js/script_person.js" type="text/javascript"></script>
<script type="text/javascript" src="res_package/school.js"></script>
</body>
</html>