function createPictureTable(data) {
    var picsPerRow = 3;
    document.write('<table width="85%" BORDER=2 align="center" bgcolor="#FFFFFF">');
    document.write("<tr>");
    for (var idx = 0; idx < data.length; idx++) {
        if (idx % picsPerRow === 0) {
            if (idx !== 0) {
                document.write("</tr><tr>");
            }
        }
        document.write('<td align="center"><a href="' + data[idx].foto + '"><img src="' + data[idx].foto + '" height="140" border="0"><br/>' + data[idx].name + '</a></td>')
    }
    document.write("</tr>");
    document.write("</table>");
}