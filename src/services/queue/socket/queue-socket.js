module.exports = function ({io}) {
    io.of('/queue').on("connection", (socket) => {
        socket.on("monitor", function (office) {
            socket.join('monitor-'+(office.toString()));
        });
    });

    return io;
}