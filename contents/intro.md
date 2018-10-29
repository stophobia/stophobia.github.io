# Good Coding

## 이해하기 쉬운 코드

- 코드는 이해하기 쉬워야 한다.
- 코드는 단시간에 이해할 수 있도록 작성되어야 한다.
- 코드는 짧을수록 좋다.

### 표면상의 개선

#### 명명

- 이름에 정보를 포함시킨다.
- tmp 등 너무 범용적인 이름은 피한다.
- i, j, k 등은 루프의 변수로 사용한다.
- 스코프가 좁은 변수의 이름은 짧은 이름을 사용한다.
- 한계치를 나타내는 경우에은 "min", "max"등을 붙인다.
- 범위를 나타내는 경우에은 "first", "ㅣ ast"등을 붙인다.
- 표괄을 나타내는 경우에는 "begin", "end"등을 붙인다.
- 기능을 나타내는 경우에는 "get", "set"등을 붙인다.

#### 주석

- 주석은 코드를 읽을 시간을 절약하도록 작성한다.
- 주석을 작성하게 된 배경을 설명한다.
- 코드가 이해하기 쉬운 경우는 주석을 생략한다.
- 정수에는 왜 그 값인지 주석을 붙인다.

### 로직의 단순화

#### 제어 흐름을 파악하기 쉽도록 작성한다.

- if 문 작성법

```javascript
// 읽기 어렵다
if (10 < length) {
  //
}

// 읽기 쉽다
if (length > 10) {
  //
}
```

- 3 항연산자
  - 행이 짧아지만 읽기 어렵고 디버그시 단계 파악이 어렵다.
  - if~else 를 사용하는 것을 추천한다.
- 네스트를 얕게 유지한다.
- 함수에서 빨리 탈출한다. 실패 분기, 예외 분기나 완료 분기를 함수의 앞부분에 적용한다.
- 루프 안에는 루프를 적용하지 않는다.

#### 식의 분할

- 설명 변수를 사용하여 분할한다.

```javascript
// 읽기 어렵다
if line.split(':')[0].strip() == "root" {
  //
}

// 읽기 쉽다
username = line.split(':')[0].strip();
if(username == "root"){
  //
}
```

- 요약 변수를 사용하여 분할한다.

```javascript
// 읽기 어렵다
if(request.user.id == document.owner_id){
  // 유저가 사용할 수 있는 변수 / 기능
}
if(request.user.id != document.owner_id){
  // 유저가 사용할 수 없는 변수 / 기능
}

// 읽기 쉽다
final boolean user_owns_document = (request.user.id != document.owner_id)

if(!user_owns_document) {
 // 유저가 사용할 수 있는 변수 / 기능
}
if(user_owns_document) {
 // 유저가 사용할 수 없는 변수 / 기능
}
```

#### 변수

- 생략할 수 있다면 생략한다.

```javascript
// 읽기 어렵다
var remove_one = function(array, value_to_remove) {
  var index_to_remove = null
  for (var i = 0; i < array.length; i += 1) {
    if (array[i] === value_to_remove) {
      index_to_remove = i
      break
    }
  }
  if (index_to_remove !== null) {
    array.splice(index_to_remove, 1)
  }
}

// 읽기 쉽다
var remove_one = function(array, value_to_remove) {
  for (var i = 0; i < array.length; i += 1) {
    if (array[i] === value_to_remove) {
      array.splice(i, 1)
      return
    }
  }
}
```

- 제어 흐름 변수를 생략한다.

```javascript
// 읽기 어렵다
boolean done = false;
while(/* condition */ && !done){
  //
  if(...){
    done = true;
    continue;
  }
}

// 읽기 쉽다
while(/* condition */){
  //
  if(...){
    break;
  }
}
```

- 변수의 스코프를 좁힌다.
- 전역 변수는 될수 있는 한 사용하지 않는다.
- 멤버 변수를 될수 있는 한 사용하지 않는다.

```javascript
// 멤버 변수
class LargeClass {
  string str_;
  void Method1() {
    str_ = ...;
    Method2();
  }
  void Method2() {
    // str_변수를 사용
  }
}

// 지역 변수
class LargeClass {
  void Method1() {
    string str_ = ...;
    Method2(str_);
  }
  void Method2(String str_) {
    // str_변수를 사용
  }
}
```

- class 의 멤버 변수로의 접근 횟수를 줄이기 위해 메소드는 될수 있는 한 static 으로 작성한다.

#### Javascript 의 private 변수

```javascript
// 전역 변수
submitted = false
var submit_form = function(form_name) {
  if (submitted) {
    return // 이중 투고 금지
  }
  submitted = true
}

// closure를 이용한 private변수
var submit_form = (function() {
  var submitted = false
  return function(form_name) {
    if (submitted) {
      return
    }
    submitted = true
  }
})()
```

- 변수는 한번만 작성한다.

```javascript
// 파악하기 어렵다
var setFirstEmptyInput = function(new_value) {
  var found = false
  var i = 1
  var elem = document.getElementById('input' + i)
  while (elem !== null) {
    if (elem.value === '') {
      found = true
      break
    }
    i++
    elem = document.getElementById('input' + i)
  }
  if (found) elem.value = new_value
  return elem
}

// 파악하기 쉽다
var setFirstEmptyInput = function(new_value) {
  for (var i = 1; true; i++) {
    var elem = document.getElementById(' input' + i)
    if (elem === null) {
      return null // Search Failed. No empty input found.
    }
    if (elem.value === '') {
      elem.value = new_value
      return elem
    }
  }
}
```

#### 짧은 코드를 작성한다.

- 범용 함수, 범용 라이브러리를 만들어 재사용한다.
- 평균적인 프로덕트 함수 코드는 10.
