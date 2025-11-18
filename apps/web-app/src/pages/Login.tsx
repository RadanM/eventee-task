import {Link, useNavigate} from 'react-router-dom';
import {type FormEvent, useContext, useState} from "react";
import {TokenContext} from "../context/TokenContext.tsx";

export const Login = () => {
	const [email, setEmail] = useState<string | null>(null);
	const [errorMessage, setErrorMessage] = useState(null);
	const [password, setPassword] = useState<string | null>(null);

	const navigate = useNavigate();

	const context = useContext(TokenContext);

	const setTokenCookie = (token: string) => {
		const expires = new Date();
		expires.setTime(expires.getTime() + 60 * 60 * 1000);
		document.cookie = `token=${token};expires=${expires.toUTCString()};path=/;Secure;SameSite=Strict`;
	};

	const handleSubmit = async (e: FormEvent<HTMLFormElement>) => {
		e.preventDefault();

		setErrorMessage(null);

		fetch('http://127.0.0.1:8000/api/authenticateWithPassword', {
			body: JSON.stringify({
				email: email,
				password: password,
			}),
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json',
			},
			method: 'POST'
		})
		.then((response) => response.json())
		.then((data) => {
			if (data.message) {
				setErrorMessage(data.message);
				return;
			}

			setTokenCookie(data.token);
			context?.setToken(data.token);
			navigate('/');
		});
	}

	return (
		<>
			<Link to="/registration">
				Go to Registration
			</Link>

			<h1>Login</h1>

			{errorMessage && (
				<p>{errorMessage}</p>
			)}

			<form onSubmit={handleSubmit}>
				<label>
					E-mail
					<input
						type="email"
						name="email"
						onChange={(e) => { setEmail(e.target.value); }}
						required
					/>
				</label>

				<label>
					Password
					<input
						type="password"
						name="password"
						onChange={(e) => { setPassword(e.target.value); }}
						required
					/>
				</label>

				<button>
					Login
				</button>
			</form>
		</>
	);
}
