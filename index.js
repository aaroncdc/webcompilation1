/* Module requirement */
const path = require('path');
const fs = require('fs');
const WebServer = require('./webserver.js');
const Log = require('./utils.js').Loging;

/* GLobal variables */
var debugMode = false;
var curdate = new Date();

const main_dir = path.resolve('.');
const server_dir = main_dir;
const public_dir = main_dir + '/public';
const cert_dir = server_dir + '/ssl';
const log_dir = server_dir + '/logs';
const log_file = log_dir + '/log_' + curdate.getMonth() + '_' + curdate.getDay() + '_' + curdate.getFullYear() + '.log';

/* JSON requirements */
const sconfig = require(main_dir + '/serverconfig.json');

/* Server configuration */
const webconfig = {
    bind: sconfig["web_options"]["bind_to"],
    port: sconfig["web_options"]["port"]
};

/* SSL certificate configuration */
const sslconfig = {
    key: fs.readFileSync(cert_dir + '/' + sconfig["ssl_options"]["ssl_key"]),
    cert: fs.readFileSync(cert_dir + '/' + sconfig["ssl_options"]["ssl_cert"])
};

/* Program initialization */
Log.Initialize(log_dir, log_file, debugMode);

WebServer.initServer(webconfig, sslconfig, public_dir);

/* Handle SIGINT interrupt (Ctrl+C) */
if (process.platform === "win32") {
    var rl = require("readline").createInterface({
      input: process.stdin,
      output: process.stdout
    });
  
    rl.on("SIGINT", function () {
      process.emit("SIGINT");
    });
  }
  
  process.on("SIGINT", function () {
      process.exit();
  });
