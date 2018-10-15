var net = require('net');
var rpio = require('rpio');

var server = net.createServer((c) => {
    console.log('Client connected');
    c.write('Welcome to GPIO server!\r\n');
    c.on('end', () => {
        console.log('Client disconnected');
    });
    c.on('data', (data) => {
        
        rpio.open(12, rpio.OUTPUT, rpio.LOW);

        rpio.write(12, rpio.HIGH);
        rpio.sleep(1);

        rpio.write(12, rpio.LOW);
        rpio.close(12);
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
