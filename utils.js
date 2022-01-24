const fs = require('fs');
const bcrypt = require('bcrypt');
const crypto = require('crypto');

class SHUtils {

    static RandomFillP(bytes, mode='hex'){
        return new Promise((resolve, reject)=>{
            let buf = Buffer.alloc(bytes);
            crypto.randomFill(buf, 0, bytes, (err, buf)=>{
                if(err) reject(err);
                resolve(buf.toString(mode));
            });
        });
    }
    
    static CheckPasswordP(input, original){
        return new Promise((resolve, reject) => {
            bcrypt.compare(input, original, (err, res) => {
                if(err) reject(err);
                if(!res) reject("Verification failed");
                resolve(res);
            });
        });
    }

    static GenSaltP(passes){
        return new Promise((resolve, reject)=>{
            bcrypt.genSalt(passes, (err, salts)=>{
                if(err) reject(err);
                resolve(salts);
            });
        });
    }

    static SaltPasswordP(passes, password){
        return new Promise((resolve, reject)=>{
            bcrypt.genSalt(passes, (err, salts)=>{
                if(err) reject(err);
                bcrypt.hash(password, salts, (err2, hash)=>{
                    if(err2) reject(err2);
                    resolve([hash, salts]);
                });
            }); 
        });
    }
}

class Loging {

    static Initialize(log_dir, log_file, debugMode = false){
        if(!fs.existsSync(log_dir)) {
            fs.mkdir(log_dir, function(err){
                if(err)
                    throw err;
            });
        }

        this.logf = fs.createWriteStream(log_file,{
            flags: 'a'
        });
        console.log("Log file: " + log_dir + '/' + log_file + "\n");
        this.debugMode = debugMode;
    }

    static debug(msgstring, trace=false, log=true){
        let curdate = new Date();
        let msg = msgstring + "\n" + (trace?("\n\n-- STACK --\n" + new Error().stack):"");
        if(this.debugMode)
        {
            console.log("[" + curdate.toUTCString() + "]: " + msg);
            if(log)
                this.logf.write("[" + curdate.toUTCString() + "]: " + msg);
        }else if(log){
            this.logf.write("[" + curdate.toUTCString() + "]: " + msg);
        }
    }

    static Error(msgstring){
        let curdate = new Date();
        let msg = "-- ERROR [" + curdate.toUTCString() + "]: " + msgstring + " --\n\n-- STACK --\n" + new Error().stack;
        if(this.debugMode)
            console.log(msg);
        this.logf.write(msg);
    }

    static Close(){
        this.logf.close();
    }
}

module.exports = {SHUtils, Loging};