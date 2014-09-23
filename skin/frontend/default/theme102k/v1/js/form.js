
//姓名验证              
function check_surname(str) {  
    var str = str.substr(0, 1); //截取用户提交的用户名的前两字节，也就是姓。   
    var surname = " 赵钱孙李周吴郑王冯陈褚卫蒋沈韩杨朱秦尤许何吕施张孔曹严华金魏陶姜戚谢邹喻柏水窦章云苏潘葛奚范彭郎鲁韦昌马苗凤花方俞任袁柳酆鲍史唐费廉岑薛雷贺倪汤 滕殷罗毕郝邬安常乐于时傅皮卞齐康伍余元卜顾孟平黄和穆萧尹姚邵堪汪祁毛禹狄米贝明臧计伏成戴谈宋茅庞熊纪舒屈项祝董粱杜阮蓝闵席季麻强贾路娄危江童颜郭 梅盛林刁钟徐邱骆高夏蔡田樊胡凌霍虞万支柯咎管卢莫经房裘缪干解应宗宣丁贲邓郁单杭洪包诸左石崔吉钮龚程嵇邢滑裴陆荣翁荀羊於惠甄魏加封芮羿储靳汲邴糜松 井段富巫乌焦巴弓牧隗山谷车侯宓蓬全郗班仰秋仲伊宫宁仇栾暴甘钭厉戎祖武符刘姜詹束龙叶幸司韶郜黎蓟薄印宿白怀蒲台从鄂索咸籍赖卓蔺屠蒙池乔阴郁胥能苍双 闻莘党翟谭贡劳逄姬申扶堵冉宰郦雍郤璩桑桂濮牛寿通边扈燕冀郏浦尚农温别庄晏柴瞿阎充慕连茹习宦艾鱼容向古易慎戈廖庚终暨居衡步都耿满弘匡国文寇广禄阙东 殴殳沃利蔚越夔隆师巩厍聂晁勾敖融冷訾辛阚那简饶空曾毋沙乜养鞠须丰巢关蒯相查后江红游竺权逯盖益桓公万俟司马上官欧阳夏侯诸葛闻人东方赫连皇甫尉迟公羊 澹台公冶宗政濮阳淳于仲孙太叔申屠公孙乐正轩辕令狐钟离闾丘长孙慕容鲜于宇文司徒司空亓官司寇仉督子车颛孙端木巫马公西漆雕乐正壤驷公良拓拔夹谷宰父谷粱 晋楚闫法汝鄢涂钦段干百里东郭南门呼延妫海羊舌微生岳帅缑亢况後有琴梁丘左丘东门西门商牟佘佴伯赏南宫墨哈谯笪年爱阳佟第五言福";  
    r = surname.search(str); // 查找字符串。  
    if (r == -1) {
        return false;
    }  
    else{  
        return true;  
    }  
}

function nameV(id) {

    var $nIpt = $('#' + id).find('input');
    var $nErrMsg = $('#' + id).find('.form_errMsg');
    var $nBuff = $('#' + id).find('i');
    var nFlag = 0;
    // $nIpt.blur(function () {
        if ($nIpt.val() != '') {
            if ($nIpt.val().length <= 1) {
                $nErrMsg.text('请输入真实姓名！');
                $nBuff.removeClass().addClass('buff_ico_e');
                return false;
            }
            var reg = /^([\u4E00-\u9FA5])*$/;
            if (arr = $nIpt.val().match(reg)) {  
                if (!check_surname($nIpt.val())) {
                    $nErrMsg.text('真实姓名格式错误！');
                    $nBuff.removeClass().addClass('buff_ico_e');
                    return false;  
                }  
            } else {
                $nErrMsg.text('真实姓名必须全部为中文！');
                $nBuff.removeClass().addClass('buff_ico_e');
                return false;  
            }  
            $nErrMsg.text("姓名格式正确！");
            nFlag = 1;
            $nBuff.removeClass().addClass('buff_ico_s');
            return true;
        } else {
            $nErrMsg.text('请输入姓名！');
            $nBuff.removeClass().addClass('buff_ico_e');
            return false;
        }
    // })
console.log(nFlag);
    if (!nFlag) {
        return false;
    }
}

// 手机号码验证
function mobileV(id) {

    var $mIpt = $('#' + id).find('input');
    var $mErrMsg = $('#' + id).find('.form_errMsg');
    var $mBuff = $('#' + id).find('i');
    var mFlag = 0;
    // $mIpt.blur(function () {
        var regBox = {
            regMobile : /^0?1[3|4|5|8][0-9]\d{8}$/,//手机
        }
        var mc_tel = $mIpt.val();
        var mflag = regBox.regMobile.test(mc_tel);
        if (!mflag) {
            $mErrMsg.text("手机格式有误！");
            $mBuff.removeClass().addClass('buff_ico_e')
            return false;
        }
        $mErrMsg.text("手机格式正确！");
        $mBuff.removeClass().addClass('buff_ico_s');
        mFlag = 1;
        return true;
    // })
    console.log(mFlag)
    if (!mFlag) {
        return false;
    }
}

// 地址验证
function addrV(id) {

    var $aIpt = $('#' + id).find('textarea');
    var $aErrMsg = $('#' + id).find('.form_errMsg');
    var $aBuff = $('#' + id).find('i');
    var aFlag = 0;
    // $aIpt.blur(function () {
        if ($aIpt.val().length >= 5) {
            var reg = /^([\u4E00-\u9FA5])*$/;
            if (arr = $aIpt.val().match(reg)) {  
                $aErrMsg.text('地址正确！');
                aFlag = 1;
                $aBuff.removeClass().addClass('buff_ico_s');
                return true;
            } else {
                $aErrMsg.text('地址必须全部为中文');
                $aBuff.removeClass().addClass('buff_ico_e')
                return false;  
            }
        } else {
            $aErrMsg.text("地址过短");
            $aBuff.removeClass().addClass('buff_ico_e')
            return false;
        }
    // })
    console.log(aFlag);

    if (!aFlag) {
        return false;
    }
}

