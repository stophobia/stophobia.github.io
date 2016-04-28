---
published: true
title: Node.js + Express.jsでHTTPSを使う
layout: post
---
<p>まず自分の署名を作る</p>

<pre class="brush: js;">
$ openssl req -x509 -newkey rsa:2048 -keyout key.pem -out cert.pem -days 365
</pre>

<p>Windowsの場合はGit ShellやGit Bashを使う。<br>
いくつかの質問に答えて進むと、自分の署名ファイルが作れる。例文では365日だけ使える例文になっている。</p>

<pre class="brush: js;">
var fs = require('fs'),
https = require('https'),
express = require('express'),
app = express();

https.createServer({
  key: fs.readFileSync('key.pem'),
  cert: fs.readFileSync('cert.pem')
}, app).listen(55555);

app.get('/', function (req, res) {
  res.header('Content-type', 'text/html');
  return res.end('Hello, Secure World!');
});
</pre>

<p>
これで、HTTPSが稼働できるようになった。
</p>

<pre class="brush: js;">
$ node index.js
</pre>

<p>
通常通り実行すると署名を作った際に入力したパスワードを聞かれるので、それに応える。<br>
もし下のようなエラーが出たら、パスを削除する。
</p>
<div>
<pre class="brush: js;">
mgechev → MinBook Pro ~/Desktop/test Thu Apr 30 11:56:03
 $ node index.js
_tls_common.js:67
      c.context.setKey(options.key);
                ^
Error: error:0906A068:PEM routines:PEM_do_header:bad password read
  at Error (native)
  at Object.createSecureContext (_tls_common.js:67:17)
  at Server (_tls_wrap.js:595:25)
  at new Server (https.js:36:14)
  at Object.exports.createServer (https.js:56:10)
  at Object.&lt;anonymous&gt; (/Users/mgechev/Desktop/test/index.js:6:11)
  at Module._compile (module.js:449:26)
  at Object.Module._extensions..js (module.js:467:10)
  at Module.load (module.js:349:32)
  at Function.Module._load (module.js:305:12)
</pre>
</div>
<p>これでいける。</p>

<pre class="brush: js;">
openssl rsa -in key.pem -out newkey.pem && mv newkey.pem key.pem
</pre>

<p>これは、以前失敗した例。参考にするため保存。</p>

<pre class="brush: js;">
$ openssl genrsa 2048 > server.key<br>
$ openssl req -new -key server.key > server.csr<br>
$ openssl x509 -req -in server.csr -signkey server.key -out server.crt
</pre>