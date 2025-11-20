import { io } from "socket.io-client";
import {useContext, useEffect, useState} from "react";
import {Link, useParams} from "react-router-dom";
import {TokenContext} from "../context/TokenContext.tsx";

const socket = io('http://localhost:3000', {
	autoConnect: false,
});

export const ChatRoom = () => {
	const [lastOffset, setLastOffset] = useState(0);
	const [message, setMessage] = useState<string>('');
	const [messages, setMessages] = useState<{
		created_at: string,
		id: number,
		user_id: number,
		text: string,
	}[]>([]);
	const [metadata, setMetadata] = useState<{
		isLast: boolean,
		lastMessageId: number | null,
	}>({
		isLast: false,
		lastMessageId: null,
	})
	const [participants, setParticipants] = useState<{id: number, email: string}[]>([]);

	const { id } = useParams();

	if (id === undefined) {
		return;
	}

	const tokenContext = useContext(TokenContext);

	const roomId = parseInt(id);

	useEffect(() => {
		if (!tokenContext?.token) return;

		fetchMessages(0);

		fetch('http://127.0.0.1:8000/api/listUsersInChatRoom?chatRoomId=' + roomId, {
			headers: {
				'Accept': 'application/json',
				'Authorization': 'Bearer ' + tokenContext?.token,
				'Content-Type': 'application/json',
			},
			method: 'GET'
		})
		.then(response => response.json())
		.then(data => {
			setParticipants(data);
		});
	}, [tokenContext, roomId]);

	useEffect(() => {
		if (!tokenContext?.token) return;

		if (!socket.connected) {
			socket.auth = { token: tokenContext.token };
			socket.connect();
		}

		socket.emit('join_room', roomId);

		socket.on('receive_message', (message) => {
			setMessages((prev) => [
				{
					created_at: message.createdAt,
					id: message.id,
					user_id: message.userId,
					text: message.text
				},
				...prev,
			]);
		});

		return () => {
			socket.emit('leave_room', roomId);
			socket.off('receive_message');
		};
	}, [tokenContext, roomId]);

	const fetchMessages = (offset: number) => {
		setLastOffset(offset);

		const lastMessageId = messages.length > 0 ? messages[messages.length - 1].id : 0

		fetch('http://127.0.0.1:8000/api/showMessages?chatRoomId=' + roomId + '&offset=' + offset + '&lastMessageId=' + lastMessageId, {
			headers: {
				'Accept': 'application/json',
				'Authorization': 'Bearer ' + tokenContext?.token,
				'Content-Type': 'application/json',
			},
			method: 'GET'
		})
		.then(response => response.json())
		.then(data => {
			setMessages((prev) => [
				...prev,
				...data.messages,
			]);

			setMetadata(data.metadata);
		});
	}

	const sendMessage = async () => {
		if (message === '') {
			return;
		}

		const response = await fetch('http://127.0.0.1:8000/api/storeMessage', {
			body: JSON.stringify({
				chatRoomId: roomId,
				text: message,
			}),
			headers: {
				'Accept': 'application/json',
				'Authorization': 'Bearer ' + tokenContext?.token,
				'Content-Type': 'application/json',
			},
			method: 'POST'
		});

		const data = await response.json();

		socket.emit('send_message', {
			createdAt: data.created_at,
			id: data.id,
			roomId: data.chat_room_id,
			userId: data.user_id,
			text: data.text,
		});
	};

	return (
		<>
			<Link to={'/'}>Back to the list</Link>

			<h1>Chat Room: {id}</h1>

			<textarea onChange={(e) => setMessage(e.target.value)}></textarea>
			<button onClick={sendMessage}>Send Message</button>

			<ul>
				{messages.map((message, index) => {
					const createdAt = new Date(message.created_at);
					const email = participants.find(participant => participant.id === message.user_id)?.email;

					return (
						<li key={index}>
							<b>{email} {createdAt.toLocaleString()}</b><br/>
							{message.text}
						</li>
					);
				})}
			</ul>

			{!metadata.isLast && (
				<button onClick={() => fetchMessages(lastOffset + 1)}>Show older messages</button>
			)}
		</>
	);
};
