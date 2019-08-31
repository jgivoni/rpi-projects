var net = require('net');
var rpio = require('rpio');
// https://www.npmjs.com/package/rpio

rpio.init({gpiomem: false});

var server = net.createServer((c) => {
    console.log('Client connected');
    c.write('Welcome to GPIO server!\r\n');
    c.on('end', () => {
        console.log('Client disconnected');
    });
    var stream = "";

    var specialParams = {
        'cb': function (pin) {
            c.write('X');
        }
    };

    c.on('data', (data) => {
        try {
            stream += data.toString();

            while (stream.indexOf("\n") > 0) {
                var command = stream.substr(0, stream.indexOf("\n"));
                stream = stream.substr(stream.indexOf("\n") + 1);
                console.log(command);

                var cmd = JSON.parse(command);

                var method;

                for (method in cmd) {
                    var params = cmd[method];

                    if (rpio[method]) {
                        var result = rpio[method].apply(rpio, params);
                        if (result !== undefined) {
                            var rs = JSON.stringify(result);
                            console.log(rs);
                            c.write(rs);
                        }
                    } else {
                        throw new Error("Invalid command \"" + method + "\"");
                    }
                }
            }
        } catch (e) {
            console.log(e.toString());
            return;
        }
    });
});

// GPIO = 7-16-9-15
server.listen(7695, () => {
    console.log('Listening on port 7695');
});

// Stop on CTRL+C
process.on('SIGINT', function () {
    console.log('Terminating');
    process.exit();
});
