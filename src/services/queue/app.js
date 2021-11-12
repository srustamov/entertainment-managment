const express = require('express');
const bodyParser = require('body-parser')
const app = express();

app.use(require("cors")({ origin: "*" }));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

module.exports = app;