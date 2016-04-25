---
published: true
title: Node.jsで使うSSL認証キーの生成
layout: post
tags: [node.js, openssl, https, security]
categories: [nodejs]
---
$ openssl genrsa 2048 > server.key<br>
$ openssl req -new -key server.key > server.csr<br>
$ openssl x509 -req -in server.csr -signkey server.key -out server.crt