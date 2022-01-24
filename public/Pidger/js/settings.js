var bctitle = "Configuración de cuenta > ";

function unfollow(target, frame)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             //setArray(this.response);
             console.log(this.response);
             if(this.response == "OK")
                frame.remove();
        }else if(this.status != 0 && this.status != 200){

        }
    }
    var usid = $("#usses").val();
    xhttp.open("POST", "userinteraction.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');    
    xhttp.send("sid="+usid+"&action=0&target="+target);
}

function unblock(target, frame)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             //setArray(this.response);
             console.log(this.response);
             if(this.response == "OK")
                frame.remove();
        }else if(this.status != 0 && this.status != 200){

        }
    }
    var usid = $("#usses").val();
    xhttp.open("POST", "userinteraction.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');    
    xhttp.send("sid="+usid+"&action=1&target="+target);
}

function setField(table, field, value)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             //setArray(this.response);
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
    $("#settings-breadcumb").html(bctitle + "Datos de usuario");
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

    /*var dragging = false;
    var mx = 0;
    var my = 0;
    var magx = 0;
    var magy = 0;*/
    /*$(".profile-editor").on('mousedown', function(ev){
        dragging = true;
        mx = event.clientX;
        my = event.clientY;
    });
    $(".profile-editor").on('mouseup', function(){
        dragging = false;
    });
    $(".profile-editor").on('mouseleave', function(){
        dragging = false;
    });*/
    /*$(".profile-editor").on('mousemove', function(ev){
        if(dragging)
        {
            magx = Math.round(event.clientX - mx);
            magy = Math.round(event.clientY - my);
            console.log(magx + " - " + magy);
            $("#profile-editor").css('background-position-x', '+='+Math.ceil(magx/25)+'px');
            $("#profile-editor").css('background-position-y', '+='+Math.ceil(magy/25)+'px');
            if(event.clientX > mx)
                magx = Math.round(event.clientX - mx);
            else
            magx = Math.round(event.clientX + mx);

            if(event.clientY > my)
                console.log("Down");
            else
                console.log("Up");
        }
        $("#profile-editor-range").on('change', function(ev){
            //alert($(this).val());
            $("#profile-editor").css('background-size', $(this).val() + "%");
        });
    });*/
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
});