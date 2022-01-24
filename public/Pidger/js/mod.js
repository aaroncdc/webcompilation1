var bctitle = "Moderación > ";

function ignorereport(mid, action=2)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             //setArray(this.response);
             console.log(this.response);
             $('.reported-message[msgid="'+mid+'"]').remove();
        }else if(this.status != 0 && this.status != 200){
            console.log("Failed");
        }
    }
    var usid = $("#usses").val();
    xhttp.open("POST", "modactions.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send("usid="+usid+"&target="+mid+"&action="+action);
}

function banuser(userid,expire,reason)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             //setArray(this.response);
             console.log(this.response);
             $("#search-results").html(this.response);
        }else if(this.status != 0 && this.status != 200){
            console.log("Failed");
        }
    }
    var usid = $("#usses").val();
    var data = {
        "expire": expire,
        "reason": reason
    };
    xhttp.open("POST", "modactions.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send("usid="+usid+"&target="+userid+"&action=0&data="+JSON.stringify(data));
}

function unbanuser(userid)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             //setArray(this.response);
             console.log(this.response);
             //$("#search-results").html(this.response);
        }else if(this.status != 0 && this.status != 200){
            console.log("Failed");
        }
    }
    var usid = $("#usses").val();
    xhttp.open("POST", "modactions.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send("usid="+usid+"&target="+userid+"&action=1");
}

function search()
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             //setArray(this.response);
             console.log(this.response);
             $("#search-results").html(this.response);
             $(".mod-user-ban").on('click', function(){
                console.log("Click");
                var usid = $(this).attr('user');
                if($('.mod-ban-options[user="'+usid+'"]').css('display') == 'none')
                    $('.mod-ban-options[user="'+usid+'"]').css('display', 'block');
                else
                    $('.mod-ban-options[user="'+usid+'"]').css('display', 'none');
            });
            $('.dotheban').on('click', function(){
                var div = $(this).parent().parent().parent().parent().parent(); //🤔
                var usid = div.attr('user');
                console.log(usid + " is now banned");
                banuser(usid,div.find('input[name="ban-expire"]').val(),div.find('input[name="ban-reason"]').val());
                div.find('mod-user-ban').toggleClass('mod-user-ban mod-user-unban');
            });
        }else if(this.status != 0 && this.status != 200){

        }
    }
    var usid = $("#usses").val();
    xhttp.open("POST", "search.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');    
    xhttp.send("usid="+usid+"&search="+$("#mod-search-box").val());
}

function setField(table, field, value)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             console.log(this.response);
        }else if(this.status != 0 && this.status != 200){

        }
    }
    var usid = $("#usid").val();
    xhttp.open("POST", "setsettings.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');    
    xhttp.send("table="+table+"&field="+field+"&value="+value+
"&usid="+usid);
}

window.addEventListener("dragover", function(e){
    e = e || event;
    e.preventDefault();
}, false);

window.addEventListener("drop", function(e){
    e = e || event;
    e.preventDefault();
}, false);

function fileUpload(file)
{
    if(file != undefined)
    {
        var usid = $("#usid").val();
        var form_data = new FormData();
        form_data.append('file', file);
        form_data.append("usid",usid);
        $.ajax({
            type: 'POST',
            url: 'profileupload.php',
            contentType: false,
            processData: false,
            data: form_data,
            success:function(response) {
                console.log(response);
                $(".option-avatar-preview").attr('src', response);
                $(".useravatar").attr('src', response);
                $(".user-avatar").attr('src', response);
            }
        });
    }
}

function drop_handler(event)
{
    console.log("Drop begin");
    event.preventDefault();
    var dt = event.dataTransfer;
    if(dt.items)
    {
        for(var i=0; i < dt.files.length; i++)
            if(dt.items[i].kind=="file")
            {
                var f = dt.items[i].getAsFile();
                console.log("\nfile["+i+"].name = " + f.name);
                fileUpload(f);
            }
    }else{
        for(var i=0; i < dt.files.length; i++)
            console.log("\nfile["+i+"].name = " + dt.files[i].name);
            fileUpload(dt.files[i]);
    }
}

function dragover_handler(event)
{
    console.log("Drop over");
    event.preventDefault;
}

function dragend_handler(event)
{
    console.log("Drop Ends");
    var dt = event.dataTransfer;
    if(dt.items)
    {
        for(var i = 0; i < dt.items.length; i++){
            dt.items.remove(i);
        }
    }else{
        ev.dataTransfer.clearData();
    }
}

$(window).on('load', function(){
    $("#config-section-1").css('display', 'block');
    $("#settings-breadcumb").html(bctitle + "Moderación de usuarios");
    $(".options-menu a").on('click', function(){
        var p = $(this).attr('panel');
        $(".config-section").each(function(){
            $(this).css('display', 'none');
        });
        $("#config-section-" + p).css('display', 'block');
        $("#settings-breadcumb").html(bctitle + $(this).children().html());
    });

    $(".field-option").each(function(){
        $(this).css('display', 'none');
    });
    $(".edit-button").each(function(){
        $(this).on('click', function(){
            var tf = $(this).attr('togglefield');
            $(this).css('display', 'none');
            $("#"+tf).css('display', 'block');
        });
    });

    $(".field-option button").each(function(){
        $(this).on('click', function(){
            var field = $(this).parent().attr('id');
            var parent = $(this).parent();
            //alert(field);
            setField(parent.attr('table'), parent.attr('field'), parent.children().val());
            $("i[togglefield=\""+field+"\"]").css('display', 'inline');
            $("#toggle-"+field).html(parent.children().val());
            parent.css('display', 'none');
        });
    });
    $("#mod-search-button").on('click', function(){
        search();
    });
    $(".mod-user-unban").on('click', function(){
        unbanuser($(this).attr('user'));
        $(this).parent().remove();
    });

    $("#load-profile-image").on('click', function(){
        fileUpload($("#load-profile-field")[0].files[0]);
    });
    $("#accept-news").change(function(){
        //console.log("news " + status);
        var status = $(this).is(":checked");
        setField("userdata", "news", (status)?1:0);
    });
    $("#mail-search").change(function(){
        //console.log("news " + status);
        var status = $(this).is(":checked");
        setField("userprivacy", "publicmail", (status)?1:0);
    });
    $('input[name="name-visibility"]').change(function(){
        //console.log("news " + status);
        if($(this).is(":checked"))
            setField("userprivacy", "showname", $(this).attr('value'));
    });
    $(".profile-unfollow").on('click', function(){
        unfollow($(this).parent().attr('val'), $(this).parent());
    });
    $(".profile-unblock").on('click', function(){
        unblock($(this).parent().attr('val'), $(this).parent());
    });

    $(".ignore-message").on('click', function(){
        console.log("Ignore message " + $(this).parent().attr('msgid'));
        ignorereport($(this).parent().attr('msgid'),2);
    });
    $(".delete-message").on('click', function(){
        console.log("Delete message " + $(this).parent().attr('msgid'));
        ignorereport($(this).parent().attr('msgid'),3);
    });
    $(".ban-user").on('click', function(){
        console.log("Ban user " + $(this).parent().attr('usid'));
        var d = new Date,
        dformat = [d.getMonth()+1,
                   d.getDate(),
                   d.getFullYear()].join('-')+' '+
                  [d.getHours(),
                   d.getMinutes(),
                   d.getSeconds()].join(':');
        banuser($(this).parent().attr('usid'),d,"Uso inadecuado del servicio");
    });
});