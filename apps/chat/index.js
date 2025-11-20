const config = require('./local.config.json');
const http = require("http");
const jwt = require("jsonwebtoken");
const { Server } = require("socket.io");

const httpServer = http.createServer();

const io = new Server(httpServer, {
	cors: {
		origin: "http://localhost:5173",
		methods: ['GET', 'POST'],
		credentials: true
	}
});

io.use((socket, next) => {
	const { token } = socket.handshake.auth;

	if (!token) {
		return next(new Error('No token provided'));
	}

	try {
		socket.user = jwt.verify(token, config.auth.jwtSecret);
		next();
	} catch (err) {
		next(new Error('Invalid token'));
	}
});

io.on('connection', (socket) => {
	socket.on('join_room', async (roomId) => {
		try {
			const response = await fetch('http://127.0.0.1:8000/api/showChatRooms', {
				headers: {
					'Accept': 'application/json',
					'Authorization': 'Bearer ' + socket.handshake.auth.token,
					'Content-Type': 'application/json',
				},
				method: 'GET'
			});

			const data = await response.json();

			if (data.some(chatRoom => chatRoom.id === roomId) === false) {
				return socket.emit('error', 'Unauthorized access');
			}

			socket.join(roomId);
		} catch (err) {
			console.error(err);
			socket.emit('error', 'Failed to join room');
		}
	});

	socket.on('send_message', (message) => {
		console.log(message);
		io.to(message.roomId).emit('receive_message', message);
	});

	socket.on('leave_room', (roomId) => {
		socket.leave(roomId);
	});
});

httpServer.listen(3000);
