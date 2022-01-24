var emojilist = [];
var filelist = null;
var emojigroup = 0;
var rpt = null;

function report(mid)
{
    //console.log("OK1");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log("Response: " + this.response);
            if(this.response == "OK")
                console.log("Reportado");
            else
                console.log(this.response);
        }else if(this.status != 0 && this.status != 200){
            //console.log("Error " + this.status);
        }
    }
    xhttp.open("POST", "messageinteract.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send("mesid=" + mid + "&mode=10&data={\"sid\":\""+$("#sid").val()+"\"}");
}

function repost(mesid)
{
    if(!mesid || mesid < 0)
        return false;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log("Response: " + this.response);
        }else if(this.status != 0 && this.status != 200){
            //console.log("Error " + this.status);
        }
    }
    xhttp.open("POST", "repost.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    var sid = $("#sid").val();

    xhttp.send("sid=" + sid + "&mesid=" + mesid);
    //console.log("Sent");
}

function getemojilist()
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             setArray(this.response);
        }else if(this.status != 0 && this.status != 200){

        }
    }
    xhttp.open("GET", "json/emo/load.php?group=All", true);
    xhttp.send();
}

function postMessage()
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("Response: " + this.response);
            $("#userinput").val("");
            $("#text-counter").html("0/500");
            var oldcontent = $("#timelinecontent").html();
            $("#timelinecontent").html(this.response + oldcontent);
            filelist = null;
            $(".file-uploader").slideUp(500);
            $(".file-uploader").html("");
            rpt = null;
        }else if(this.status != 0 && this.status != 200){
            //console.log("Error " + this.status);
        }
    }
    xhttp.open("POST", "postmessage.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    var msg = $("#userinput").val();
    var sid = $("#sid").val();
    var files = null;
    if(filelist)
    {
        files = JSON.stringify(filelist);
        //console.log(files);
    }

    xhttp.send("sid=" + sid + "&userinput=" + msg + ((files)?"&filelist=" + files:"") + ((rpt)?"&replyto="+rpt:""));
    //console.log("Sent");
}

function likemsg(id)
{
    //console.log("OK1");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log("Response: " + this.response);

        }else if(this.status != 0 && this.status != 200){
            //console.log("Error " + this.status);
        }
    }
    xhttp.open("POST", "messageinteract.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send("mesid=" + id + "&mode=0&data={\"sesid\":\""+$("#sid").val()+"\",\"value\":1}");
}

function mainFileUpload(file)
{
    if(file != undefined)
    {
        var usid = $("#usid").val();
        var form_data = new FormData();
        form_data.append('file', file);
        form_data.append("usid",usid);
        $.ajax({
            type: 'POST',
            url: 'uploadmedia.php',
            contentType: false,
            processData: false,
            data: form_data,
            success:function(response) {
                if(filelist == null)
                    filelist = new Array();
                var jdata = JSON.parse(response);
                filelist.push(jdata["mid"]);
                //console.log("Array updated: " + filelist.length);
                //console.log("Item: " + jdata["name"]);
                $(".file-uploader").slideDown(500);
                $(".file-uploader").append('<div class="file-upload-box" id="upload-'+jdata["mid"]+'" upid="'+jdata["mid"]+'"><i class="fa fa-window-close"></i><img src="'+jdata["name"]+'" class="file-upload-box"></div>');
                $("#upload-"+jdata["mid"]+" .fa-window-close").on('click', function(){
                    removeMedia(parseInt($(this).parent().attr('upid')));
                    $(this).parent().remove();
                    filelist.splice(filelist.indexOf(jdata["mid"]),1);
                    console.log("filelist " + filelist.length);
                    if(filelist.length <= 0)
                        $(".file-uploader").slideUp(500);
                });
                //console.log(response);
            }
        });
    }
}

function removeMedia(id)
{
    //console.log("OK1");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("Response: " + this.response);

        }else if(this.status != 0 && this.status != 200){
            console.log("Error " + this.status);
        }
    }
    xhttp.open("POST", "removemedia.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send("meid="+id);
}

window.addEventListener("dragover", function(e){
    e = e || event;
    e.preventDefault();
}, false);

window.addEventListener("drop", function(e){
    e = e || event;
    e.preventDefault();
}, false);

function main_drop_handler(event)
{
    //console.log("Drop begin");
    event.preventDefault();
    var dt = event.dataTransfer;
    if(dt.items)
    {
        for(var i=0; i < dt.files.length; i++)
            if(dt.items[i].kind=="file")
            {
                var f = dt.items[i].getAsFile();
                //console.log("\nfile["+i+"].name = " + f.name);
                mainFileUpload(f);
            }
    }else{
        for(var i=0; i < dt.files.length; i++)
            //console.log("\nfile["+i+"].name = " + dt.files[i].name);
            mainFileUpload(dt.files[i]);
    }
}

function main_dragover_handler(event)
{
    //console.log("Drop over");
    event.preventDefault;
}

function main_dragend_handler(event)
{
    //console.log("Drop Ends");
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

function setArray(data){
    emojilist = JSON.parse(data);
    for(emote in emojilist[emojigroup]["data"])
    {
        //console.log(emojilist[emojigroup]["data"][emote]["value"]);
        var code = emojilist[emojigroup]["data"][emote]["key"];
        $(".emoji-list").append("<div class='emoji-button' rel='"+code+"' title='"+code+"'>"+emojilist[emojigroup]["data"][emote]["value"]+"</div>");
        //$(".emoji-cat-button[rel=\""+emojigroup+"\"]").removeClass("emoji-cat-button");
        $(".emoji-cat-button[rel=\""+emojigroup+"\"]").addClass("emoji-cat-selected");
    }
    
    $(document).on('click', '.emoji-button', function(){
        $("#userinput").val($("#userinput").val() + findEmoji($(this).attr('rel')));
        var ln = $("#userinput").val().length;
            $("#text-counter").html(ln + "/500");
            if(ln > 500)
            {
                $("#text-counter").removeClass("text-counter");
                $("#text-counter").addClass("text-counter-error");
            }else{
                $("#text-counter").removeClass("text-counter-error");
                $("#text-counter").addClass("text-counter");
            }
            $(".emoji-menu").slideUp(350);
    });
    
}

function findEmoji(code)
{
    //console.log(emojilist[emojigroup]["data"]);
    for(i in emojilist[emojigroup]["data"])
    {
        if(emojilist[emojigroup]["data"][i]["key"] == code)
            return emojilist[emojigroup]["data"][i]["value"];
    }
    console.log("Not found");
    return "";
}

function updateEmojiList()
{
    $(".emoji-list").html("");
    for(emote in emojilist[emojigroup]["data"])
    {
        var code = emojilist[emojigroup]["data"][emote]["key"];
        $(".emoji-list").append("<div class='emoji-button' rel='"+code+"' title='"+code+"'>"+emojilist[emojigroup]["data"][emote]["value"]+"</div>");
        $(".emoji-cat-button[rel=\""+emojigroup+"\"]").addClass("emoji-cat-selected");
    }
}

$(window).on('load', function(){
    $(".emoji-menu").animate({width:'toggle'},0);
    getemojilist();
    $(".login-form").slideUp(0);
    $(".button-login").on('click', function(){
        $(".login-form").slideToggle(300);
    });
    $(".emoji-cat-button").on('click', function(){
        $(".emoji-cat-button[rel=\""+emojigroup+"\"]").removeClass("emoji-cat-selected");
        emojigroup = $(this).attr('rel');
        $(".emoji-cat-button[rel=\""+emojigroup+"\"]").addClass("emoji-cat-selected");
        updateEmojiList();
    });
    $("#userinput").on('keyup', function(e){
        if(ln > 500 && e.keyCode != 80)
        {
            return false;
        }else{
            var ln = $("#userinput").val().length;
            $("#text-counter").html(ln + "/500");
            if(ln > 500)
            {
                $("#text-counter").removeClass("text-counter");
                $("#text-counter").addClass("text-counter-error");
            }else{
                $("#text-counter").removeClass("text-counter-error");
                $("#text-counter").addClass("text-counter");
            }
        }
    });
    $(".file-uploader").slideUp(0);
    $(".fa-heart").on('click', function(){
        likemsg($(this).attr('rel'));
        $(this).addClass("liked-message");
    });
    $(".fa-retweet").on('click', function(){
        repost($(this).attr('rel'));
        $(this).addClass("repost-message");
    });
    $("#emoji-menu-button").on('click',function(){
        $(".emoji-menu").slideToggle(350);
    });
    $("#post-message").on('click', function(){
        postMessage();
    });
    $(".fa-mail-reply[author]").on('click', function(){
        rpt = $(this).attr('rel');
        $("#userinput").val("@"+$(this).attr('author') + " " + $("#userinput").val());
        $("#main-container").scrollTop();
        $(this).css('color', 'lightgreen');
    });
    $(".fa-camera").on('click', function(){
        $("#upload-image-field").trigger('click');
    });
    $("#upload-image-field").on('change', function(ev){
        //console.log("File trigger");
        for(var x = 0; x < $("#upload-image-field")[0].files.length && x < 3; x++)
        {
            mainFileUpload($("#upload-image-field")[0].files[x]);
            //console.log("File: " + $("#upload-image-field")[0].files[x]);
        }
    });

    $(".message-dropbutton").each(function(){
        $('.message-menu-drop', this).slideUp(0);
    });
    $(".message-dropbutton").on('click', function(){
        $('.message-menu-drop', this).slideToggle(300);
    });
    $(".message-report").on('click', function(){
        report($(this).parent().parent().attr("msgid"));
        $(this).parent().slideUp(300);
        return false;
    });
    $("#loading-screen").fadeOut(300);
});