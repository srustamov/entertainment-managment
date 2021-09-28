const socket = require('socket.io');
const queueSocket = use('sockets/queue-socket')

module.exports = function (server, app) {

    let io = socket(server, {
        cors: { origin: '*'}
    });

    app.get('/',(request,response,next) => response.json({message: 'run nigga run'}));

    let context = {server,io,app}

    queueSocket(context)

    use('routes/queue')(app,io)

    return app;
}
