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
        'cb': function(pin) {
            c.write('X');
        }
    };

    c.on('data', (data) => {
        stream += data.toString();

        while (stream.indexOf("\n") > 0) {
            var command = stream.substr(0, stream.indexOf("\n"));
            stream = stream.substr(stream.indexOf("\n") + 1);
            console.log("In: " + command);

            var params = command.split(" ").map(function(x) {
                if (x.indexOf(':') === 0) {
                    return specialParams[x.substr(1)];
                } else {
                    return isNaN(x) ? x.trim() : parseInt(x);
                }
            });
            var method = params.shift().trim();

            if (rpio[method]) {
                var result = rpio[method].apply(rpio, params);
                if (typeof result === 'boolean' || typeof result === 'number') {
                    result = result.toString();
                }
                if (typeof result === 'string') {
                    console.log("Out: " + result);
                    c.write(result);
                }
            } else {
                console.log(method + " not supported");
            }
        }
    });
});

// GPIO = 7-16-9-15
server.listen(7695, () => {
    console.log('Listening on port 7695');
});

// Stop on CTRL+C
process.on('SIGINT', function() {
    console.log('Terminating');
    process.exit();
});
