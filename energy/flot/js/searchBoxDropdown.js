/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function createDropDown(src, dest, parent, hide)
{
    var srcjq = "#" + src;
    var destjq = "#" + dest;
    createDropDownAux(srcjq, dest, parent);

    if (hide==true) {
        var src = document.getElementById(src);
        src.style.display="none";
    }

    var txt = destjq + " dt a";
    $(txt).click(function() {
        var tmp = destjq + " dd ul";
        $(tmp).toggle();
    });

    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasid(dest))
            txt = destjq + " dd ul";
            $(txt).hide();
    });

    txt = destjq + " dd ul li a";
    $(txt).click(function() {
        var text = $(this).html();
        var tmp1 = destjq + " dt a";
        $(tmp1).html(text);
        var tmp2 = destjq + " dd ul";
        $(tmp2).hide();

        var source = $(srcjq);
        source.val($(this).find("span.value").html())
    });
};

function createDropDownAux(src, dest, parent){
    var destjq = "#" + dest;
    var parentjq = "#" + parent;
    var source = $(src);
    var selected = source.find("option[selected]");
    var options = $("option", source);

    var txt = '<dl id=' + dest + ' class="dropdown"></dl>'
    $(parentjq).append(txt)
    $(destjq).append('<dt><a href="#">' + selected.text() + 
        '<span class="value">' + selected.val() + 
        '</span></a></dt>')
    $(destjq).append('<dd><ul></ul></dd>')

    options.each(function(){
        var txt = destjq + " dd ul"
        $(txt).append('<li><a href="#">' + 
            $(this).text() + '<span class="value">' + 
            $(this).val() + '</span></a></li>');
    });
} 
