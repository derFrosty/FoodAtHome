let httpServer = require('http').createServer()
let io = require('socket.io')(httpServer)
let SessionManager = require("./SessionManager.js")

let https = require('https')



httpServer.listen(8080, function () {
    console.log('listening on *:8080')
})

let sessions = new SessionManager()

io.on('connection', function (socket) {
    console.log('Client has connected. Socket ID = ' + socket.id)
        // socket.on('global_message', (payload) => {
    //     switch (payload.type) {
    //         //manager
    //         case 'EM':
    //             break;
    //         //cook
    //         case 'EC':
    //             break;
    //         //delivery
    //         case 'ED':
    //             break;
    //         //customer
    //         case 'C':
    //             break;
    //         default:
    //
    //             break;
    //     }
    // })

    socket.on('user_logged', (user) => {
        if (user) {
            sessions.addUserSession(user, socket.id)
            socket.join(user.type)
            console.log('User Logged: UserID= ' + user.id + ' Socket ID= ' + socket.id)
            console.log(' -> Total Sessions= ' + sessions.users.size)
        }
    })

    socket.on('user_logged_out', (user) => {
        if (user) {
            socket.leave(user.type)
            sessions.removeUserSession(user.id)
            console.log('User Logged OUT: UserID= ' + user.id + ' Socket ID= ' + socket.id)
            console.log(' -> Total Sessions= ' + sessions.users.size)
        }
    })

    // socket.on('disconnect', (reason) => {
    //     let x = sessions.removeSocketIDSession(socket.id)
    //     // console.log('Disconnect user' + x.user.id)
    //     console.log('Disconnect Socket ID= ' + socket.id)
    //     console.log(' -> Total Sessions= ' + sessions.users.size)
    // })

    socket.on('disconnect', (reason) => {
        let x = sessions.removeSocketIDSessionAndGetId(socket.id)

        let data = JSON.stringify({
            user_id: x.user.id,
            availability: 0
        })

        let options = {
            hostname: 'http://projeto.test/api',
            port: 443,
            path: '/updateAvailability',
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Content-Length': data.length
            }
        }

        let req = https.request(options, res => {
            console.log(`statusCode: ${res.statusCode}`)

            res.on('data', d => {
                process.stdout.write(d)
            })
        })

        req.on('error', error => {
            console.error(error)
        })

        req.write(data)
        req.end()


        console.log('Disconnect user' + x.user.id)

        console.log('Disconnect Socket ID= ' + socket.id)
        console.log(' -> Total Sessions= ' + sessions.users.size)
    })





})