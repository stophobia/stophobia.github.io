---
published: true
title: 無料でnodejs+mongodbサーバー構築
layout: post
tags: [nodejs, express, mongodb, heroku, mlab, free, web, hosting]
---
nodejsを勉強しながら一番壁になるのはただで使えるサーバーがないこと。herokuとかは有名だけど、dbを一緒に使う場合は有料プランを利用することになる。海外のウェブで調べてみたら、herokuと無料のdbを連携して使う方法があったのでここで紹介。<br>
<br>
まず、最小限のパッケージをローカル環境に備えておく。<br>
<ul>
<li>nodejs</li>
<li>expressjs</li>
<li>mongodb</li>
<li>mongoose</li>
</ul>
次は、mongodbを無料でサービスしている<a href="https://mlab.com/">mLab</a>というところでアカウントを作成する。<br>
<br>
cloudを選択することになるが、これはプロバイダーなので、自分のmlabアカウントやawsなどのアカウントとは関係ない。普段使っている、または親しみのあるサービスを選ぶだけで十分。<br>
ただ、決済が発生しないように容量などには気を付ける。<br>
<br>
herokuとの連携を想定しているので、それに沿って説明。<br>
<br>
mlabで自分のdb情報を参考にindex.jsにコネクトを宣言。<br>
<pre class="brush: js;">
var connect = function(callback){
	mongoose.connect('mongodb://user:password@ds037647.mongolab.com:37647/db-name',callback);
}
</pre>
<br>
herokuには、<a href="https://toolbelt.heroku.com/">heroku toolbelt</a>をインストールする。<br>
そして、herokuにログインすると関連ミドルウェアがインストールされる。もちろん、package.jsonに記録される。<br>
<br>
<pre class="brush: js;">
$ heroku login
</pre>
ここまでしたら、heroku上のnode.js環境でmongodbを使える環境になる。<br>
<br>
<address>
<p>参考</p>
<a href="http://blog.koenromers.com/deploying-your-node-js-mongodb-application-for-free/">DEPLOYING YOUR NODE.JS + MONGODB APPLICATION FOR FREE</a>
</address>