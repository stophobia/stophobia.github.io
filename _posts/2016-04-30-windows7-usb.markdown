---
published: true
title: windows7でusbキーボードだけ英語配列として認識
layout: post
---
windows 7のノートパソコンに、usbキーボードだけ英語配列として使うためのTIP。

1. cmd > regedit
2. [HKEY_LOCAL_MACHINE¥SYSTEM¥CurrentControlSet¥Services¥i8042prt¥Parameters]
3. [LayerDriver JPN] の値を [kbd106.dll] から [kbd101.dll] に変更
4. [OverrideKeyboardIdentifier] の値を [PCAT_106KEY] から [PCAT_101KEY] に変更
5. [OverrideKeyboardSubtype] の値を [2] から [0] に変更
6. regeditを終了して再起動

しかし、この方法では、ノートパソコンのキーボードも英語配列として認識されてしまう。USBキーボードのみ英語配列としたいなら、5. は変更しないこと。