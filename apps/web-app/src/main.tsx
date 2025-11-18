import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import { ChatRoom } from './pages/ChatRoom.tsx'
import { ChatRooms } from './pages/ChatRooms.tsx'
import { Login } from './pages/Login.tsx'
import { Registration } from './pages/Registration.tsx'
import { ProtectedRoute } from "./components/ProtectedRoute.tsx";
import {TokenProvider} from "./context/TokenProvider.tsx";


createRoot(document.getElementById('root')!).render(
	<StrictMode>
		<TokenProvider>
			<Router>
				<Routes>
					<Route
						path="/"
						element={
							<ProtectedRoute>
								<ChatRooms/>
							</ProtectedRoute>
						}
					/>
					<Route
						path="/chat-room/:id"
						element={
							<ProtectedRoute>
								<ChatRoom/>
							</ProtectedRoute>
						}
					/>
					<Route
						path="/registration"
						element={
							<Registration/>
						}
					/>
					<Route
						path="/login"
						element={
							<Login/>
						}
					/>
				</Routes>
			</Router>
		</TokenProvider>
	</StrictMode>,
)
