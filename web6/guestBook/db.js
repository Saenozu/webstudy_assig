const mysql = require('mysql');

const connection = mysql.createConnection( {
    host: 'localhost',
    user: 'snz2262',
    password: '2022Wnsldj!',
    port: 3306,
    database: 'snz2262',
    dateStrings: 'date',
    multipleStatements: true
});
connection.connect( function(err) {
    if (err) console.log(err);
    else console.log('Connected!');
});
module.exports = connection;