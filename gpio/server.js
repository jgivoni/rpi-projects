var net = require('net');
var rpio = require('rpio');

var server = net.createServer((c) => {
    console.log('Client connected');
    c.write('Welcome to GPIO server!\r\n');
    c.on('end', () => {
        console.log('Client disconnected');
    });
    var stream = "";
    c.on('data', (data) => {
        stream += data.toString();

        while (stream.indexOf("\n") > 0) {
            var command = stream.substr(0, stream.indexOf("\n"));
            stream = stream.substr(stream.indexOf("\n") + 1);
            console.log(command);

            var params = command.split(" ").map(function(x) {
                return isNaN(x) ? x.trim() : parseInt(x);
            });
            var method = params.shift().trim();

            if (rpio[method]) {
                rpio[method].apply(rpio, params);
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
