function modal(url) {
    var str = "<div class=\"modal fade\" id=\"myModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">\n" +
        "    <div class=\"modal-dialog\" role=\"document\">\n" +
        "        <div class=\"modal-content\">\n" +
        "            <div class=\"modal-header\">\n" +
        "                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>\n" +
        "                <h4 class=\"modal-title\" id=\"myModalLabel\">友情提示</h4>\n" +
        "            </div>\n" +
        "            <div class=\"modal-body\">\n" +
        "                确认删除吗？删除之后将不能恢复\n" +
        "            </div>\n" +
        "            <div class=\"modal-footer\">\n" +
        "                <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n" +
        "                <a href='"+url+"' class=\"btn btn-primary\">确定</a>\n" +
        "            </div>\n" +
        "        </div>\n" +
        "    </div>\n" +
        "</div>"
    $('body').append(str);
    $('#myModal').modal('show');
}