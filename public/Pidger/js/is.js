$(window).on('load', function(){
    var page = 1;
    var mode = 0;

    function getNextMessages()
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                page++;
                console.log(this.response);
                $("#timelinecontent").html($("#timelinecontent").html() + this.response);
                $(".message-dropbutton").each(function(){
                    $(this).on('click', function(){
                        $('.message-menu-drop', this).slideToggle(300);
                    });
                });
                $(".message-report").each(function(){
                    $(this).on('click', function(){
                        report($(this).parent().parent().attr("msgid"));
                        $(this).parent().slideUp(300);
                        return false;
                    });
                });
            }else if(this.status != 0 && this.status != 200){

            }
        }
        var sid = null;
        if($("#sid"))
            sid = $("#sid").val();
        xhttp.open("GET", "api.php?mode="+$("#scroll-mode").val()+"&start="+(page*10)+"&count=10" + ((sid)?"&sid="+sid:""), true);
        xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhttp.send();
    }

    $("#main-container").scroll(function(e) {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            console.log("Bottom!");
            getNextMessages();
        }
     });
});