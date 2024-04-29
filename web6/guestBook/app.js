const express = require("express");
const ejs = require("ejs");
const path = require("path");
const app = express();
const conn = require('./db.js');

app.listen(8010, function () {
	console.log("listening on port 8010");
});

app.use('/Image',express.static(path.join(__dirname,'Image')));

app.use(express.urlencoded({ extended: false }));
app.set("views", path.join(__dirname, "views"));
app.set("view engine", "ejs");

app.get("/", function (req, res) {
	var sql = 'SELECT * FROM guestBook';
	conn.query(sql, function (err, rows) {
		if (err) console.log("query is not excuted. select fail!\n" + err);
		else res.render("index.ejs", { list: rows, form: "" });
	});
} );
app.post("/", function (req, res) {
	console.log(req.body);
	var sql = 'INSERT INTO guestBook (name, nick, content) VALUES (?,?,?);'+'SELECT * FROM guestBook;';
	var params = [req.body.inputName,req.body.inputNick,req.body.inputText];
	conn.query(sql, params, function (err, rows) {
		if (err) console.log("query is not excuted. insert fail!\n" + err);
		else res.render("index.ejs", { list: rows[1], form: "" });
	});
} );

app.get("/modify/:no", function (req, res) {
	const no = req.params.no;
	var sql = 'SELECT * FROM guestBook;'+'SELECT * FROM guestBook WHERE no=?;';
	conn.query(sql, no, function (err, rows) {
		if (err) console.log("query is not excuted. select fail!\n" + err);
		else res.render("index.ejs", { list: rows[0], form: rows[1] });
	});
});
app.post("/modify/:no", function (req, res) {
	const no = req.params.no;
	const name = req.body.inputName;
	const nick = req.body.inputNick;
	const content = req.body.inputText;
	var sql = 'UPDATE guestBook SET name=?, nick=?, content=? WHERE no=?;';
	var params = [name, nick, content, no];

	conn.query(sql, params, function (err, rows) {
		if (err) console.log("query is not excuted. modify fail!\n"+err);
		else res.redirect("/");
	});
});

app.get("/delete/:no", function (req, res) {
	const no = req.params.no;
	var sql = 'DELETE FROM guestBook WHERE no=?;';
	conn.query(sql, no, function (err, rows) {
		if (err) console.log("query is not excuted. delete fail!\n" + err);
		else res.redirect("/");
	});
});