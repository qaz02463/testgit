<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <!-- <form id="form1"> -->
    <form action="" method="post">
        推送方式:<select name="pushType">
                    <option value="0">不用推送(推荐)返回提取码</option>
                    <option value="1">电子发票（直接返回电子发票pdf文件</option>
                    <option value="3">微信卡劵推送,返回插卡url</option>
                    <option value="5">微信二维码(加密的提取码json的png)</option>
                </select><br>
        销售单据号:<input type="text" name="XSF_BILLNO" value="A20190508016423198590"><br />
        开票类型:<input type="text" name="KPLX" value="0"><br />
        编码表版本号:<input type="text" name="BMB_BBH" value="33.0"><br />
        清单标志:<input type="text" name="QD_BZ" value="0"><br />
        清单发票项目名称:<input type="text" name="QDXMMC" value=""><br />
        销售方纳税人识别号:<input type="text" name="XSF_NSRSBH" value="912101007600936848"><br />
        销售方名称:<input type="text" name="XSF_MC" value="辽宁航天信息有限公司"><br />
        销售方地址、电话:<input type="text" name="XSF_DZDH" value="辽宁省沈阳市和平区抚顺路15号(4门、5门、6门)23472665"><br />
        销售方银行账号:<input type="text" name="XSF_YHZH" value="中国农业银行沈阳西塔支行06-135101040003893"><br />
        购买方纳税人识别号:<input type="text" name="GMF_NSRSBH" value="912101127695587831"><br />
        购买方名称:<input type="text" name="GMF_MC" value="沈阳巨谷装备制造有限公司"><br />
        购买方地址、电话:<input type="text" name="GMF_DZDH" value="17696665192"><br />
        购买方银行账号:<input type="text" name="GMF_YHZH" value=""><br />
        开票人:<input type="text" name="KPR" value="吴润泽"><br />
        收款人:<input type="text" name="SKR" value="刘宁宁"><br />
        复核人:<input type="text" name="FHR" value="韩璐"><br />
        原发票代码:<input type="text" name="YFP_DM" value=""><br />
        原发票号码:<input type="text" name="YFP_HM" value=""><br />
        价税合计:<input type="text" name="JSHJ" value="50"><br />
        合计金额:<input type="text" name="HJJE" value="47.17"><br />
        合计税额:<input type="text" name="HJSE" value="2.83"><br />
        备注信息:<input type="text" name="BZ" value=""><br />
        <br>
        <br>
        <br>
        发票行性质:<input type="text" name="FPHXZ" value="0"><br />
        商品编码:<input type="text" name="SPBM" value="3040201030000000000"><br />
        自行编码:<input type="text" name="ZXBM" value=""><br />
        优惠政策标识:<input type="text" name="YHZCBS" value="0"><br />
        <!-- 零税率标识:<input type="text" name="LSLBS" value=""><br /> -->
        <!-- 增值税特殊管理:<input type="text" name="ZZSTSGL" value=""><br /> -->
        项目名称:<input type="text" name="XMMC" value="服务费-其他"><br />
        规格型号:<input type="text" name="GGXH" value=""><br />
        单位:<input type="text" name="DW" value="年"><br />
        项目数量:<input type="text" name="XMSL" value="1.0"><br />
        项目单价:<input type="text" name="XMDJ" value="47.17"><br />
        项目金额:<input type="text" name="XMJE" value="47.17"><br />
        税率:<input type="text" name="SL" value="0.06"><br />
        税额:<input type="text" name="SE" value="2.83"><br />
        <!-- <input type="submit" onclick="dianji()"> -->
        <input type="submit" name="">
    </form>
</body>
</html>