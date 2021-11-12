const redis = require('redis')
const REDIS_PREFIX = 'management_database_'
const QUEUE_CHANNEL = `${REDIS_PREFIX}queue_channel`;

module.exports = function (route,io) {

    const queueRedisClient = redis.createClient()

    queueRedisClient.subscribe(QUEUE_CHANNEL);

    queueRedisClient.on("message",(channel,message) => {

        if (QUEUE_CHANNEL === channel) {

            let { event, location, data } = JSON.parse(message);

            io.in(`monitor-${location.toString()}`).emit(event, data);
        }
    });

    io.on('connection',(socket) => {
        socket.on('call',function (data) {
            io.in(`monitor-${data.location.toString()}`).emit('call',data)
        })
    })

}