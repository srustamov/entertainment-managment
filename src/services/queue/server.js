#!/usr/bin/env node
global.use = (path) => require(__dirname.concat(`/${path}`))

const app        = use('app');
const bindRoutes = use('routes');
const https      = require('http');
const fs         = require('fs');


const port = 3001;

app.set('port', port);


const server = https.createServer({
    key: fs.readFileSync("../../storage/certs/mover.az.key"),
    cert: fs.readFileSync("../../storage/certs/mover.az.crt"),
    requestCert: false,
    rejectUnauthorized: false,
}, app);

server.listen(port);

bindRoutes(server, app)


const onError = (error) => {
    if (error.syscall !== 'listen') {
        throw error;
    }

    let bind = typeof port === 'string'
        ? 'Pipe ' + port
        : 'Port ' + port;

    switch (error.code) {
        case 'EACCES':
            console.error(bind + ' requires elevated privileges');
            process.exit(1);
            break;
        case 'EADDRINUSE':
            console.error(bind + ' is already in use');
            process.exit(1);
            break;
        default:
            throw error;
    }
}
const onListening = () => {
    let addr = server.address();
    let bind = typeof addr === 'string'
        ? 'pipe ' + addr
        : 'port ' + addr.port;
    console.log('Listening on ' + bind);
}

server.on('error', onError);
server.on('listening', onListening);