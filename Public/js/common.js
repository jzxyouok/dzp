function show(sid, zt, cname, zid) { //显示页脚二级菜单
    var sm = document.getElementById(sid);
    sm.style.display = zt;
    $("#" + zid).addClass(cname);
}


//随机数
function getRand() {
    var sb = [];
    while (sb.length < 4)
        sb.push(Math.floor(Math.random() * 9 + 1));
    return sb.join("");
}

//解析URL传递的参数
function request(paras) {
    var url = location.href;   //url
    var paraString = url.substring(url.indexOf("?") + 1, url.length).split("&");
    var paraObj = {}   //参数组
    for (i = 0; j = paraString[i]; i++) {
        paraObj[j.substring(0, j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=") + 1, j.length);
    }
    var returnValue = paraObj[paras.toLowerCase()];
    if (typeof (returnValue) == "undefined") {
        return "";
    } else {
        return returnValue;
    }
}

//ajax数据
var dataService = {
    ajaxGet: function (url, callback, isAsync) {
        if (typeof (isAsync) == "undefined")
            isAsync = true;
        $.ajax({
            type: "get",
            async: isAsync,
            url: url,
            success: function (data, textStatus) {
                callback(data);
            }
        });
    },
    ajaxPost: function (url, arrData, callback) {
        $.ajax({
            type: "post",
            url: url,
            data: arrData,
            success: function (data, textStatus) {
                callback(data);
            }
        });
    }
};
