function block(sid, usid)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             //setArray(this.response);
             alert(this.response);
             if(this.response == "OK")
             {
                $(".block-icon").toggleClass('block-icon unblock-icon');
                $(".fa-ban").toggleClass('fa-ban fa-unlock');
             }
        }else if(this.status != 0 && this.status != 200){
            alert(this.status);
        }
    }
    //var usid = $("#usid").val();
    xhttp.open("POST", "block.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');    
    xhttp.send("sid="+sid+"&usid="+usid);
}

function unblock(sid, usid)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             //setArray(this.response);
             alert(this.response);
             if(this.response == "OK")
             {
                $(".unblock-icon").toggleClass('unblock-icon block-icon');
                $(".fa-unlock").toggleClass('fa-unlock fa-ban');
             }
        }else if(this.status != 0 && this.status != 200){
            alert(this.status);
        }
    }
    //var usid = $("#usid").val();
    xhttp.open("POST", "unblock.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');    
    xhttp.send("sid="+sid+"&usid="+usid);
}

function follow(sid, usid)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             //setArray(this.response);
             alert(this.response);
             if(this.response == "OK")
             {
                $(".follow-icon").toggleClass('follow-icon unfollow-icon');
                $(".fa-user-plus").toggleClass('fa-user-plus fa-user-times');
             }
        }else if(this.status != 0 && this.status != 200){
            alert(this.status);
        }
    }
    //var usid = $("#usid").val();
    xhttp.open("POST", "follow.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');    
    xhttp.send("sid="+sid+"&usid="+usid);
}

function unfollow(sid, usid)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             //setArray(this.response);
             alert(this.response);
             if(this.response == "OK")
             {
                $(".unfollow-icon").toggleClass('unfollow-icon follow-icon');
                $(".fa-user-times").toggleClass('fa-user-times fa-user-plus');
             }
        }else if(this.status != 0 && this.status != 200){
            alert(this.status);
        }
    }
    //var usid = $("#usid").val();
    xhttp.open("POST", "unfollow.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');    
    xhttp.send("sid="+sid+"&usid="+usid);
}

$(window).on('load', function(){
    $(".follow-icon").on('click', function(){
        var sid = $("#sid").val();
        var usid = $(this).attr('follow');
        follow(sid, usid);
    });
    $(".unfollow-icon").on('click', function(){
        var sid = $("#sid").val();
        var usid = $(this).attr('unfollow');
        unfollow(sid, usid);
    });
    $(".block-icon").on('click', function(){
        var sid = $("#sid").val();
        var usid = $(this).attr('block');
        block(sid, usid);
    });
    $(".unblock-icon").on('click', function(){
        var sid = $("#sid").val();
        var usid = $(this).attr('unblock');
        unblock(sid, usid);
    });
});