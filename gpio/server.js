var net = require("net");
var rpio = require("rpio");
// https://www.npmjs.com/package/rpio

var server = net.createServer((c) => {
    console.log("\x1b[36m%s\x1b[0m", "Client connected");
    c.write("Welcome to the GPIO server!\r\n" +
        "You can send me commands in JSON format.\n");
    c.on('end', () => {
        console.log("\x1b[36m%s\x1b[0m", "Client disconnected");
    });
    var stream = "";

    var specialParams = {
        'cb': function (pin) {
            c.write("X");
        }
    };

    c.on("data", (data) => {
        try {
            stream += data.toString();

            while (stream.indexOf("\n") > 0) {
                var command = stream.substr(0, stream.indexOf("\n"));
                stream = stream.substr(stream.indexOf("\n") + 1);
                console.log("\x1b[33m%s\x1b[0m", command);

                var cmd = JSON.parse(command);

                var method;

                for (method in cmd) {
                    var params = cmd[method];

                    if (rpio[method]) {
                        var result = rpio[method].apply(rpio, params);
                        if (result !== undefined) {
                            var rs = JSON.stringify(result);
                            console.log("\x1b[32m%s\x1b[0m", rs);
                            c.write(rs);
                        }
                    } else {
                        throw new Error("Invalid command \"" + method + "\"");
                    }
                }
            }
        } catch (e) {
            console.log("\x1b[31m%s\x1b[0m", e.toString());
            return;
        }
    });
});

// GPIO = 7-16-9-15
server.listen(7695, () => {
    console.log("\x1b[1m%s\x1b[0m", 'Listening on port 7695');
});

// Stop on CTRL+C
process.on('SIGINT', function () {
    console.log("\x1b[1m%s\x1b[0m", "Terminating (recieved SIGINT)");
    process.exit();
});

// Stop on docker stop
process.on('SIGTERM', function () {
    console.log("\x1b[1m%s\x1b[0m", "Terminating (received SIGTERM)");
    process.exit();
});
