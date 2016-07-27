var i = {
    pageSize: 30,
    init: function ()
    {

        $("#LoadTimes").val(parseInt($("#LoadTimes").val()) + 1);
        if (parseInt($("#LoadTimes").val()) > 1)
        {
            $("#PageIndex").val(parseInt($("#PageIndex").val()) - 1);
            i.backData();
        }
        else
        {
            i.bindData();
        }
        $("#btnSearch").click(function ()
        {
            $("#PageIndex").val("1");
            i.bindData();
        });
        $("#btnMore").click(function ()
        {
            i.bindData();
        });
    },
    serverUrl: "/Service/VoteRank.ashx?action=3",
    bindData: function ()
    {
        var key = $("[id$=txtKey]").val(); //选手编号或姓名查询
        var pageIndex = $("#PageIndex").val();
        var code = $("#VoteCode").val();
        var orgID = $("#OrgID").val();
        if (pageIndex == "" || typeof (pageIndex) == "undefined")
            pageIndex = "1";
        pageIndex = parseInt(pageIndex);
        var u = i.serverUrl + "&pageIndex=" + pageIndex + "&pageSize=" + i.pageSize + "&orgID=" + orgID + "&key=" + encodeURI(key);
        dataService.ajaxGet(u, function (data)
        {
            if (key != "")
            { //查询时清除所有的分页数据
                $("#memberL").html("");
                $("#memberR").html("");
            }
            if (data == "" || data == "-1@[]")
            {
                $("#memberL").html("<div style='color:red; text-align:center;margin:20px;'>未查询到数据</div>");
                $("#btnMore").html("");
                return;
            }
            var arrData = data.split('@');
            var total = parseInt(arrData[0]);
            var strData = arrData[1];
            if (total < 1)
            {
                $("#btnMore").html("");
                lock = true;
            }
            else
            {
                lock = false;
            }
            $("#PageIndex").val((pageIndex + 1));
            var arrLeft = [];//左侧图片
            var arrRight = [];//右侧图片
            $(eval(strData)).each(function (idx)
            {
                if (idx % 2 == 0)
                {
                    arrLeft.push(i.fnAppendNode(code, this));
                } else
                {
                    arrRight.push(i.fnAppendNode(code, this));
                }
            });
            $("#memberL").append(arrLeft.join(""));
            $("#memberR").append(arrRight.join(""));
        });
    },
    fnAppendNode: function (code, obj)
    { //选手图片资料
        var arr = [];
        var url = "/" + code + "/member/" + obj.No;
        arr.push("<div class=\"listinfo\" id=\"xs" + obj.No + "\">");
        arr.push("<div class=\"listimg\">");
        arr.push("<a onclick=\"$('#LastClickID').val('" + obj.No + "')\" href='" + url + "'><img src='" + obj.CoverUrl + "' />");
        arr.push("<span class=\"sp01\">编号:" + obj.No + "</span>");
        arr.push("<span class=\"sp02\">");
        arr.push("<p>" + obj.NickName + "</p>");
        arr.push("<p>" + obj.VoteNum + "票</p>");
        arr.push("</span>");
        arr.push("</a>");
        arr.push("</div>");
        arr.push("<div class=\"listbtn\">");
        arr.push("<a href='" + url + "'>投一票</a>");
        arr.push("</div>");
        arr.push("</div>");
        return arr.join("");
    },
    ///返回上一页时直接加载之前的全部刷出来的数据
    backData: function ()
    {
        var key = $("[id$=txtKey]").val(); //选手编号或姓名查询
        var pageIndex = $("#PageIndex").val();
        var code = $("#VoteCode").val();
        var orgID = $("#OrgID").val();
        if (pageIndex == "" || typeof (pageIndex) == "undefined")
            pageIndex = "1";
        pageIndex = parseInt(pageIndex);
        var u = i.serverUrl + "&pageIndex=1&pageSize=" + i.pageSize * pageIndex + "&orgID=" + orgID + "&key=" + encodeURI(key);
        dataService.ajaxGet(u, function (data)
        {
            if (key != "")
            { //查询时清除所有的分页数据
                $("#memberL").html("");
                $("#memberR").html("");
            }
            if (data == "" || data == "-1@[]")
            {
                $("#memberL").html("<div style='color:red; text-align:center;margin:20px;'>未查询到数据</div>");
                $("#btnMore").html("");
                return;
            }
            var arrData = data.split('@');
            var total = parseInt(arrData[0]);
            var strData = arrData[1];
            if (total < 1)
            {
                $("#btnMore").html("");
                lock = true;
            }
            else
            {
                lock = false;
            }
            $("#PageIndex").val((pageIndex + 1));
            var arrLeft = [];//左侧图片
            var arrRight = [];//右侧图片
            $(eval(strData)).each(function (idx)
            {
                if (idx % 2 == 0)
                {
                    arrLeft.push(i.fnAppendNode(code, this));
                } else
                {
                    arrRight.push(i.fnAppendNode(code, this));
                }
            });
            $("#memberL").append(arrLeft.join(""));
            $("#memberR").append(arrRight.join(""));

            if ($("#LastClickID").val() != "")
            {
                setTimeout(function ()
                {
                    $('#xs' + $("#LastClickID").val()).addClass("last");
                    dingwei('#xs' + $("#LastClickID").val());
                }, 500);
            }
        });
    }
};

function dingwei(str)
{
    window.location.hash = str;
    if (0 < $(str).offset().top - $(document).scrollTop() < $(window).height())
    {
        return;
    }
    else
    {
        setTimeout(function () { dingwei(str); }, 100);
    }
}

$(function ()
{
    i.init();
});