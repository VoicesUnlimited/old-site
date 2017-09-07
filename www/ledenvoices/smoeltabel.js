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
        document.write('<td align="center">')
        if(data[idx].foto) {
            document.write('<a href="' + data[idx].foto + '"><img src="' + data[idx].foto + '" height="140" border="0"><br/>');
        }
        else {
            document.write('Nog geen foto!<br/><br/>')
        }
        document.write(data[idx].name);
        if(data[idx].foto) {
            document.write('</a>');
        }
        document.write('</td>');
    }
    document.write("</tr>");
    document.write("</table>");
}