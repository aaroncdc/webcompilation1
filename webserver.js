const fs = require('fs');
const https = require('https');
//const WebSocket = require('ws');
//const WebSocketServer = WebSocket.Server;
const mimes = require('./mime.json');
const SHUtils = require('./utils.js').SHUtils;
const Log = require('./utils.js').Loging;

class WebServer {

    static initServer(serverdata, sslconfig, basedir)
    {
        Log.debug("Web server started",false,true);
        this.glob_basedir = basedir;
        this.server = https.createServer(sslconfig, this.handleRequest);
        this.server.listen(serverdata.port, serverdata.ip);
    }

    static sendFile(request, response, mime) {
        if(fs.existsSync(this.glob_basedir + request.url) === false)
        {
            response.writeHead(404);
            response.end("");
            return;
        }
        if(fs.lstatSync(this.glob_basedir + request.url).isFile() === false)
        {
            if(fs.lstatSync(this.glob_basedir + request.url).isDirectory() === true)
            {
                console.log("This is a directory");
                if(fs.existsSync(this.glob_basedir + request.url + '/index.html'))
                {
                    response.writeHead(301, {'Location': request.url + '/index.html'});
                    response.end("");
                    return;
                }else{
                    response.writeHead(404);
                    response.end("");
                    return;
                }
            }else{
                response.writeHead(404);
                response.end("");
                return;
            }
        }
        response.writeHead(200, {'Content-Type': mime});
        response.end(fs.readFileSync(this.glob_basedir + request.url));
    }

    static handlePOSTBody(data){
        let dFields = data.split('&');
        let res = {};
        for(let field of dFields) {
            let dParams = field.split('=');
            if(dParams.length > 1){
                res[dParams[0].toString()] = dParams[1].toString();
            }
        }
        return res;
    }

    static GetCookie(request, name)
    {
        if(request.headers.cookie !== undefined) {
            for(let cookie of request.headers.cookie.trim().split("; ")){
                let split = cookie.split("=");
                if(split[0] === name && split.length > 1){
                    return split.slice(1).join("=");
                }else if(split[0] === name){
                    return split[0];
                }
            }
        }else{
            return null;
        }
    }

    static POSTEndpoint(request, POST_, response)
    {
        switch(request.url) {
            /*case '/register':
                if(POST_["uspass1"] !== POST_["uspass2"])
                {
                    response.writeHead(420, {'Location': request.headers.referer});
                    response.end("<h1>Password verification failed</h1>");
                    return;
                }

                let randid = Math.floor(Math.random() * Math.floor(999999) + 1) + Math.floor(Math.random() * Math.floor(9999) + 1);

                SHUtils.SaltPasswordP(10,POST_["uspass1"])
                .then((res)=>serveruser.CreateP([0,randid,null,POST_["usname"],POST_["usmail"],
                    res[0],res[1], null,null,null,null,0,null,null,0,0,0]))
                .then((user) => {
                    response.writeHead(301, {'Location': request.headers.referer});
                    response.end("");   
                })
                .catch((err)=>{throw err});
            break;
            case '/login':
                let user = null;
                serveruser.GetP(POST_["usmail"], false)
                .then((user_)=>{ user = user_ })
                .then(()=>SHUtils.CheckPasswordP(POST_["uspass"], user.password))
                .then((res)=>SHUtils.RandomFillP(20, 'hex'))
                .then((session)=>{user.session = session})
                .then(()=>user.SyncP())
                .then((res)=>{
                    response.writeHead(301, {
                        'Set-Cookie': "superhighway_session=" + res.session,
                        'Location': '/chat'
                        //'Location': request.headers.referer
                    });
                    response.end("");
                })
                .catch((err)=>{throw err});
            break;*/
            default:
                response.writeHead(404);
                response.end("");
            break;
        }
    }

    static handleRequest(request, response) {
        let remoteAddress = request.connection.remoteAddress;
        let proxy = ((request.headers['X-Forwarded-For']!==undefined)?request.headers['X-Forwarded-For']:null);
        Log.debug( ((proxy !== null)?proxy:remoteAddress) + "> " + request.method + " " + request.url, false, true);

        if(request.method === 'POST'){
            let rawData = '';
            request.on('data', (chunk) => {rawData += chunk.toString();});
            request.on('end', ()=>{
                WebServer.POSTEndpoint(request,
                    WebServer.handlePOSTBody(decodeURIComponent(rawData)),
                    response);
            }).on('error', (e) => {
                console.error(`Got error: ${e.message}`);
              });
            return;
        }else if(request.method === 'GET'){
            if(request.url === '/') {
                response.writeHead(200, {'Content-Type': 'text/html'});
                try{
                response.end(fs.readFileSync(WebServer.glob_basedir + '/index.html'));
                }catch{
                    response.writeHead(404);
                    response.end("");
                }
            }else{
                let ext = request.url.split('.').pop();
                if(typeof mimes[ext] === 'undefined'){
                    let mime = mimes["default"]["mime"];
                    WebServer.sendFile(request, response, mime);
                }else{
                    let mime = mimes[ext]["mime"];
                    WebServer.sendFile(request, response, mime);
                }
            }
        }
    }

    static stopServer(){
        server.close(function(err){
            if(err) {
                throw err;
            }
        });
    }
}

module.exports = WebServer;
