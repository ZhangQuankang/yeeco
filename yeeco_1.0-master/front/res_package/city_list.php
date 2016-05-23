<?php
    $pro=$_POST['pro'];
	if( $pro == '北京' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="北京市">北京市</option></select>';
		exit;
    }else if( $pro == '上海' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="上海市">上海市</option></select>';
		exit;
	}else if( $pro == '天津' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="天津市">天津市</option></select>';
		exit;
	}else if( $pro == '重庆' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="重庆市">重庆市</option></select>';
		exit;
	}else if( $pro == '黑龙江' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="哈尔滨市">哈尔滨市</option><option value="七台河市">七台河市</option><option value="齐齐哈尔市">齐齐哈尔市</option><option value="黑河市">黑河市</option><option value="大庆市">大庆市</option><option value="鹤岗市">鹤岗市</option><option value="伊春市">伊春市</option><option value="佳木斯市">佳木斯市</option><option value="双鸭山市">双鸭山市</option><option value="鸡西市">鸡西市</option><option value="牡丹江市">牡丹江市</option><option value="绥化市">绥化市</option><option value="大兴安岭地区">大兴安岭地区</option></select>';
	exit;
	}else if( $pro == '吉林' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="长春市">长春市</option><option value="白城市">白城市</option><option value="松原市">松原市</option><option value="吉林市">吉林市</option><option value="四平市">四平市</option><option value="辽源市">辽源市</option><option value="通化市">通化市</option><option value="白山市">白山市</option><option value="延边朝鲜族自治州">延边朝鲜族自治州</option></select>';
	exit;
	}else if( $pro == '辽宁' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="沈阳市">沈阳市</option><option value="朝阳市">朝阳市</option><option value="阜新市">阜新市</option><option value="铁岭市">铁岭市</option><option value="抚顺市">抚顺市</option><option value="本溪市">本溪市</option><option value="辽阳市">辽阳市</option><option value="鞍山市">鞍山市</option><option value="丹东市">丹东市</option><option value="大连市">大连市</option><option value="营口市">营口市</option><option value="盘锦市">盘锦市</option><option value="锦州市">锦州市</option><option value="葫芦岛市">葫芦岛市</option></select>';
	exit;
	}else if( $pro == '安徽' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="合肥市">合肥市</option><option value="宿州市">宿州市</option><option value="淮北市">淮北市</option><option value="亳州市">亳州市</option><option value="阜阳市">阜阳市</option><option value="蚌埠市">蚌埠市</option><option value="淮南市">淮南市</option><option value="滁州市">滁州市</option><option value="马鞍山市">马鞍山市</option><option value="芜湖市">芜湖市</option><option value="铜陵市">铜陵市</option><option value="安庆市">安庆市</option><option value="黄山市">黄山市</option><option value="六安市">六安市</option><option value="巢湖市">巢湖市</option><option value="池州市">池州市</option><option value="宣城市">宣城市</option></select>';
	exit;
	}else if( $pro == '江苏' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="南京市">南京市</option><option value="徐州市">徐州市</option><option value="连云港市">连云港市</option><option value="宿迁市">宿迁市</option><option value="淮安市">淮安市</option><option value="盐城市">盐城市</option><option value="扬州市">扬州市</option><option value="泰州市">泰州市</option><option value="南通市">南通市</option><option value="镇江市">镇江市</option><option value="常州市">常州市</option><option value="无锡市">无锡市</option><option value="苏州市">苏州市</option></select>';
	exit;
	}else if( $pro == '浙江' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="杭州市">杭州市</option><option value="湖州市">湖州市</option><option value="嘉兴市">嘉兴市</option><option value="舟山市">舟山市</option><option value="宁波市">宁波市</option><option value="绍兴市">绍兴市</option><option value="衢州市">衢州市</option><option value="金华市">金华市</option><option value="泰州市">台州市</option><option value="温州市">温州市</option><option value="丽水市">丽水市</option></select>';
	exit;
	}else if( $pro == '陕西' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="西安市">西安市</option><option value="延安市">延安市</option><option value="铜川市">铜川市</option><option value="渭南市">渭南市</option><option value="咸阳市">咸阳市</option><option value="宝鸡市">宝鸡市</option><option value="汉中市">汉中市</option><option value="榆林市">榆林市</option><option value="安康市">安康市</option><option value="商洛市">商洛市</option></select>';
	exit;
	}else if( $pro == '湖北' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="武汉市">武汉市</option><option value="十堰市">十堰市</option><option value="襄樊市">襄樊市</option><option value="荆门市">荆门市</option><option value="孝感市">孝感市</option><option value="黄冈市">黄冈市</option><option value="鄂州市">鄂州市</option><option value="黄石市">黄石市</option><option value="咸宁市">咸宁市</option><option value="荆州市">荆州市</option><option value="宜昌市">宜昌市</option><option value="随州市">随州市</option><option value="恩施土家族苗族自治州">恩施土家族苗族自治州</option></select>';
	exit;
	}else if( $pro == '广东' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="广州市">广州市</option><option value="清远市">清远市</option><option value="韶关市">韶关市</option><option value="河源市">河源市</option><option value="梅州市">梅州市</option><option value="潮州市">潮州市</option><option value="汕头市">汕头市</option><option value="揭阳市">揭阳市</option><option value="汕尾市">汕尾市</option><option value="惠州市">惠州市</option><option value="东莞市">东莞市</option><option value="深圳市">深圳市</option><option value="珠海市">珠海市</option><option value="中山市">中山市</option><option value="江门市">江门市</option><option value="佛山市">佛山市</option><option value="肇庆市">肇庆市</option><option value="云浮市">云浮市</option><option value="阳江市">阳江市</option><option value="茂名市">茂名市</option><option value="湛江市">湛江市</option></select>';
	exit;
	}else if( $pro == '湖南' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="长沙市">长沙市</option><option value="张家界市">张家界市</option><option value="常德市">常德市</option><option value="益阳市">益阳市</option><option value="岳阳市">岳阳市</option><option value="株洲市">株洲市</option><option value="湘潭市">湘潭市</option><option value="衡阳市">衡阳市</option><option value="郴州市">郴州市</option><option value="永州市">永州市</option><option value="邵阳市">邵阳市</option><option value="怀化市">怀化市</option><option value="娄底市">娄底市</option><option value="湘西土家族苗族自治州">湘西土家族苗族自治州</option></select>';
	exit;
	}else if( $pro == '甘肃' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="兰州市">兰州市</option><option value="嘉峪关市">嘉峪关市</option><option value="金昌市">金昌市</option><option value="白银市">白银市</option><option value="天水市">天水市</option><option value="武威市">武威市</option><option value="酒泉市">酒泉市</option><option value="张掖市">张掖市</option><option value="庆阳市">庆阳市</option><option value="平凉市">平凉市</option><option value="定西市">定西市</option><option value="陇南市">陇南市</option><option value="临夏回族自治州">临夏回族自治州</option><option value="甘南藏族自治州">甘南藏族自治州</option></select>';
	exit;
	}else if( $pro == '四川' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="成都市">成都市</option><option value="广元市">广元市</option><option value="绵阳市">绵阳市</option><option value="德阳市">德阳市</option><option value="南充市">南充市</option><option value="广安市">广安市</option><option value="遂宁市">遂宁市</option><option value="内江市">内江市</option><option value="乐山市">乐山市</option><option value="自贡市">自贡市</option><option value="泸州市">泸州市</option><option value="宜宾市">宜宾市</option><option value="攀枝花市">攀枝花市</option><option value="巴中市">巴中市</option><option value="达州市">达州市</option><option value="资阳市">资阳市</option><option value="眉山市">眉山市</option><option value="雅安市">雅安市</option><option value="阿坝藏族羌族自治州">阿坝藏族羌族自治州</option><option value="甘孜藏族自治州">甘孜藏族自治州</option><option value="凉山彝族自治州">凉山彝族自治州</option></select>';
	exit;
	}else if( $pro == '山东' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="济南市">济南市</option><option value="聊城市">聊城市</option><option value="德州市">德州市</option><option value="东营市">东营市</option><option value="淄博市">淄博市</option><option value="潍坊市">潍坊市</option><option value="烟台市">烟台市</option><option value="威海市">威海市</option><option value="青岛市">青岛市</option><option value="日照市">日照市</option><option value="临沂市">临沂市</option><option value="枣庄市">枣庄市</option><option value="济宁市">济宁市</option><option value="泰安市">泰安市</option><option value="莱芜市">莱芜市</option><option value="滨州市">滨州市</option><option value="菏泽市">菏泽市</option></select>';
	exit;
	}else if( $pro == '福建' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="福州市">福州市</option><option value="南平市">南平市</option><option value="莆田市">莆田市</option><option value="三明市">三明市</option><option value="泉州市">泉州市</option><option value="厦门市">厦门市</option><option value="漳州市">漳州市</option><option value="龙岩市">龙岩市</option><option value="宁德市">宁德市</option></select>';
	exit;
	}else if( $pro == '河南' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="郑州市">郑州市</option><option value="三门峡市">三门峡市</option><option value="洛阳市">洛阳市</option><option value="焦作市">焦作市</option><option value="新乡市">新乡市</option><option value="鹤壁市">鹤壁市</option><option value="安阳市">安阳市</option><option value="濮阳市">濮阳市</option><option value="开封市">开封市</option><option value="商丘市">商丘市</option><option value="许昌市">许昌市</option><option value="漯河市">漯河市</option><option value="平顶山市">平顶山市</option><option value="南阳市">南阳市</option><option value="信阳市">信阳市</option><option value="周口市">周口市</option><option value="驻马店市">驻马店市</option></select>';
	exit;
	}else if( $pro == '云南' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="昆明市">昆明市</option><option value="曲靖市">曲靖市</option><option value="玉溪市">玉溪市</option><option value="保山市">保山市</option><option value="昭通市">昭通市</option><option value="丽江市">丽江市</option><option value="普洱市">普洱市</option><option value="临沧市">临沧市</option><option value="德宏傣族景颇族自治州">德宏傣族景颇族自治州</option><option value="怒江傈僳族自治州">怒江傈僳族自治州</option><option value="迪庆藏族自治州">迪庆藏族自治州</option><option value="大理白族自治州">大理白族自治州</option><option value="楚雄彝族自治州">楚雄彝族自治州</option><option value="红河哈尼族彝族自治州">红河哈尼族彝族自治州</option><option value="文山壮族苗族自治州">文山壮族苗族自治州</option><option value="西双版纳傣族自治州">西双版纳傣族自治州</option></select>';
	exit;
	}else if( $pro == '河北' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="石家庄市">石家庄市</option><option value="张家口市">张家口市</option><option value="承德市">承德市</option><option value="秦皇岛市">秦皇岛市</option><option value="唐山市">唐山市</option><option value="廊坊市">廊坊市</option><option value="保定市">保定市</option><option value="衡水市">衡水市</option><option value="沧州市">沧州市</option><option value="邢台市">邢台市</option><option value="邯郸市">邯郸市</option></select>';
	exit;
	}else if( $pro == '江西' ){
        echo '<option id="city" selected="selected" value="">城市</option><option value="南昌市">南昌市</option><option value="九江市">九江市</option><option value="景德镇市">景德镇市</option><option value="鹰潭市">鹰潭市</option><option value="新余市">新余市</option><option value="萍乡市">萍乡市</option><option value="赣州市">赣州市</option><option value="上饶市">上饶市</option><option value="抚州市">抚州市</option><option value="宜春市">宜春市</option><option value="吉安市">吉安市</option></select>';
	exit;
	}else if( $pro == '山西' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="太原市">太原市</option><option value="朔州市">朔州市</option><option value="大同市">大同市</option><option value="阳泉市">阳泉市</option><option value="长治市">长治市</option><option value="晋城市">晋城市</option><option value="忻州市">忻州市</option><option value="晋中市">晋中市</option><option value="临汾市">临汾市</option><option value="吕梁市">吕梁市</option><option value="运城市">运城市</option></select>';
	exit;
	}else if( $pro == '贵州' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="贵阳市">贵阳市</option><option value="六盘水市">六盘水市</option><option value="遵义市">遵义市</option><option value="安顺市">安顺市</option><option value="毕节地区">毕节地区</option><option value="铜仁地区">铜仁地区</option><option value="黔东南苗族侗族自治州">黔东南苗族侗族自治州</option><option value="黔南布依族苗族自治州">黔南布依族苗族自治州</option><option value="黔西南布依族苗族自治州">黔西南布依族苗族自治州</option></select>';
	exit;
	}else if( $pro == '广西' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="南宁市">南宁市</option><option value="桂林市">桂林市</option><option value="柳州市">柳州市</option><option value="梧州市">梧州市</option><option value="贵港市">贵港市</option><option value="玉林市">玉林市</option><option value="钦州市">钦州市</option><option value="北海市">北海市</option><option value="防城港市">防城港市</option><option value="崇左市">崇左市</option><option value="百色市">百色市</option><option value="河池市">河池市</option><option value="来宾市">来宾市</option><option value="贺州市">贺州市</option></select>';
	exit;
	}else if( $pro == '内蒙古' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="呼和浩特市">呼和浩特市</option><option value="包头市">包头市</option><option value="乌海市">乌海市</option><option value="赤峰市">赤峰市</option><option value="通辽市">通辽市</option><option value="呼伦贝尔市">呼伦贝尔市</option><option value="鄂尔多斯市">鄂尔多斯市</option><option value="乌兰察布市">乌兰察布市</option><option value="巴彦淖尔市">巴彦淖尔市</option><option value="兴安盟">兴安盟</option><option value="锡林郭勒盟">锡林郭勒盟</option><option value="阿拉善盟">阿拉善盟</option></select>';
	exit;
	}else if( $pro == '宁夏' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="银川市">银川市</option><option value="石嘴山市">石嘴山市</option><option value="吴忠市">吴忠市</option><option value="固原市">固原市</option><option value="中卫市">中卫市</option></select>';
		echo '<option id="city" selected="selected" value="">城市</option><option value="银川市">银川市</option><option value="石嘴山市">石嘴山市</option><option value="吴忠市">吴忠市</option><option value="固原市">固原市</option><option value="中卫市">中卫市</option></select>';
	exit;
	}else if( $pro == '青海' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="西宁市">西宁市</option><option value="海东地区">海东地区</option><option value="海北藏族自治州">海北藏族自治州</option><option value="海南藏族自治州">海南藏族自治州</option><option value="黄南藏族自治州">黄南藏族自治州</option><option value="果洛藏族自治州">果洛藏族自治州</option><option value="玉树藏族自治州">玉树藏族自治州</option><option value="海西蒙古族藏族自治州">海西蒙古族藏族自治州</option></select>';
	exit;
	}else if( $pro == '新疆' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="60029001">乌鲁木齐市</option><option value="克拉玛依市">克拉玛依市</option><option value="喀什地区">喀什地区</option><option value="阿克苏地区">阿克苏地区</option><option value="和田地区">和田地区</option><option value="吐鲁番地区">吐鲁番地区</option><option value="哈密地区">哈密地区</option><option value="克孜勒苏柯尔克孜自治州">克孜勒苏柯尔克孜自治州</option><option value="博尔塔拉蒙古自治州">博尔塔拉蒙古自治州</option><option value="昌吉回族自治州">昌吉回族自治州</option><option value="巴音郭楞蒙古自治州">巴音郭楞蒙古自治州</option><option value="伊犁哈萨克自治州">伊犁哈萨克自治州</option><option value="塔城地区">塔城地区</option><option value="阿勒泰地区">阿勒泰地区</option></select>';
	exit;
	}else if( $pro == '海南' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="海口市">海口市</option><option value="三亚市">三亚市</option></select>';
	exit;
	}else if( $pro == '西藏' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="拉萨市">拉萨市</option><option value="那曲地区">那曲地区</option><option value="昌都地区">昌都地区</option><option value="林芝地区">林芝地区</option><option value="山南地区">山南地区</option><option value="日喀则地区">日喀则地区</option><option value="阿里地区">阿里地区</option></select>';
	exit;
	}else if( $pro == '香港' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="香港特别行政区">香港特别行政区</option></select>';
	exit;
	}else if( $pro == '澳门' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="澳门特别行政区">澳门特别行政区</option></select>';
		exit;
	}else if( $pro == '台湾' ){
		echo '<option id="city" selected="selected" value="">城市</option><option value="台北市">台北市</option><option value="高雄市">高雄市</option><option value="基隆市">基隆市</option><option value="台中市">台中市</option><option value="台南市">台南市</option><option value="新竹市">新竹市</option><option value="嘉义市">嘉义市</option></select>';
	exit;
	}else if( $pro == '省份' ){
		echo '<option id="city" selected="selected" value="">城市</option></select>';
		exit;
	}
?>