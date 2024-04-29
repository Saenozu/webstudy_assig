var express = require("express");

var app = express();

var randNum;  //출석번호 변수
function rand() {  //출석번호 생성 함수
	return Math.round(Math.random()*1000);
};

app.use(express.json());
app.use(express.urlencoded({extended:true}));

app.listen(3000, function () {
	console.log("listening on port 3000");
	//서버 시작할 때 출석번호 생성
	randNum = rand();
});

app.get("/", function(req, res) {
	res.sendFile(__dirname + "/public/index.html");
	//컨닝용 출력
	console.log(randNum);
});

app.post("/", function(req, res) {
	if (req.body.inputNum == randNum) {
		//메시지 출력 후 출석번호 재생성
		res.send("<h1>출석했습니다.</h1>");
		randNum = rand();
	} else {
		//알림창 띄운 후 재시도를 위해 페이지 이동
		res.send("<script>alert('인증번호 다시 확인하세요');location.href='/';</script>");
	}
});
