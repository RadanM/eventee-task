import {useContext, useEffect, useState} from "react";
import {TokenContext} from "../context/TokenContext.tsx";
import {Link} from "react-router-dom";

export const ChatRooms = () => {
	const [availableUsers, setAvailableUsers] = useState<{id: string, email: string[]}[]>([]);
	const [chatRooms, setChatRooms] = useState<{id: string, emails: string[]}[]>([]);
	const [selectedUsers, setSelectedUsers] = useState<number[]>([]);

	const context = useContext(TokenContext);

	useEffect(() => {
		if (!context?.token) return;

		fetch('http://127.0.0.1:8000/api/showChatRooms', {
			headers: {
				'Accept': 'application/json',
				'Authorization': 'Bearer ' + context?.token,
				'Content-Type': 'application/json',
			},
			method: 'GET'
		})
		.then((response) => response.json())
		.then((data) => {
			setChatRooms(data);
		});

		fetch('http://127.0.0.1:8000/api/listAvailableUsers', {
			headers: {
				'Accept': 'application/json',
				'Authorization': 'Bearer ' + context?.token,
				'Content-Type': 'application/json',
			},
			method: 'GET'
		})
		.then((response) => response.json())
		.then((data) => {
			setAvailableUsers(data);
		});
	}, [context?.token]);

	const openChatRoom = () => {
		if (selectedUsers.length === 0) {
			window.alert('At least one user has to be selected.');
			return;
		}

		fetch('http://127.0.0.1:8000/api/createChatRoom', {
			body: JSON.stringify({
				user_ids: selectedUsers,
			}),
			headers: {
				'Accept': 'application/json',
				'Authorization': 'Bearer ' + context?.token,
				'Content-Type': 'application/json',
			},
			method: 'POST'
		})
		.then((response) => response.json())
		.then((data) => {
			if (typeof data.id === 'number') {
				setChatRooms(
					prevChatRooms => ([
						...prevChatRooms,
						data,
					]),
				);
			}
		});
	};

	return (
		<>
			<h1>Chat rooms</h1>

			<select
				onChange={(e) => {
					setSelectedUsers(
						Array.from(
							e.target.selectedOptions,
							option => parseInt(option.value),
						),
					);
				}}
				multiple
			>
				{availableUsers.map((user) => (
					<option key={user.id} value={user.id}>
						{user.email}
					</option>
				))}
			</select>

			<button onClick={openChatRoom}>Create a chat room</button>
			{
				chatRooms.map((chatRoom) => (
					<div>
						<ul>
							{chatRoom.emails.map((email) => (
								<li key={email}>{email}</li>
							))}
						</ul>
						<Link to={'/chat-room/' + chatRoom.id}>Open</Link>
					</div>

				))
			}
		</>
	);
}
