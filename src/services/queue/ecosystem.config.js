module.exports = {
    apps: [
        {
            name: "queue-node-services",
            script: "./server.js",
            instances: 1,
            exec_mode: "cluster",
            watch: true,
            env: {
                PORT: 3001,
                NODE_ENV: "production",
            },
        },
    ],
};